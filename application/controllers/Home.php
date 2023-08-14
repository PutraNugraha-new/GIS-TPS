<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_tps");
	}


    public function index()
    {
        $data = array(
            'title'=>'Sistem Informasi ...',
            'title2'=>'Dashboard',
            'user' => 'Putra Nugraha',
            'isi'   =>  'v_home',
            'map' => $this->M_tps->allData(),
        );
        // var_dump($data);
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function detail($id){
        $data = array (
            'title'=>'Sistem Informasi ...',
            'jadwal' => '14 Februari 2023',
            'user' => 'Putra Nugraha',
            'isi'   =>  'v_detail',
            'map' => $this->M_tps->allData(),
            'detail' => $this->M_tps->get_detail_modal($id),
        );
        // var_dump($data);
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

}

/* End of file Admin.php */

