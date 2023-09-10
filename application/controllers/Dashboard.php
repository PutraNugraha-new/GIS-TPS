<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_tps");
		$this->load->model("M_kab");
		$this->load->model("M_kel");
		$this->load->model("M_kec");
		$this->load->model("M_all");
	}

    public function index()
    {
        $data = array(
            'title'=>'Sistem Informasi ...',
            'title2'=>'Statistics',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/dashboard/v_home',
            'tps' => $this->M_all->countTps(),
            'kab' => $this->M_all->countKab(),
            'kec' => $this->M_all->countKec(),
            'kel' => $this->M_all->countKel(),
        );
        // var_dump($data);
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

}

/* End of file Admin.php */

