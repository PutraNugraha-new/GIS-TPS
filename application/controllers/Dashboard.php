<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public $status;
    public $roles;

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_tps");
		$this->load->model("M_kab");
		$this->load->model("M_kel");
		$this->load->model("M_kec");
		$this->load->model("M_all");
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
        $this->load->library('userlevel');
	}

    public function index()
    {
        //user data from session
	    $data = $this->session->userdata;
	    if(empty($data)){
	        redirect(site_url().'main/login/');
	    }

	    //check user level
	    if(empty($data['role'])){
	        redirect(site_url().'main/login/');
	    }
	    $dataLevel = $this->userlevel->checkLevel($data['role']);
        // var_dump($dataLevel);
        // die();
	    //check user level
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
            $data = array(
                'title2'=>'Dashboard',
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/dashboard/v_home',
                'tps' => $this->M_all->countTps(),
                'kab' => $this->M_all->countKab(),
                'kec' => $this->M_all->countKec(),
                'kel' => $this->M_all->countKel(),
                'map' => $this->M_tps->allData(),
                'dataLevel' => $dataLevel
            );
            // var_dump($data);
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }
    }
    public function getMarkers() {
        // Ambil data dari model atau database Anda
        $data = $this->M_tps->allData(); // Gantilah Your_model dengan model Anda

        // Set header untuk menunjukkan bahwa respons adalah JSON
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }

}

/* End of file Admin.php */

