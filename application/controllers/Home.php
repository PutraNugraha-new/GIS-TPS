<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_tps");
		$this->load->model("M_kab");
		$this->load->model("M_kec");
		$this->load->model("M_kel");
	}


    public function index()
    {
        $data = array(
            'title'=>'Sistem Informasi ...',
            'title2'=>'Dashboard',
            'user' => 'Putra Nugraha',
            'isi'   =>  'v_home',
            'map' => $this->M_tps->allData(),
            'kab' => $this->M_kab->allData(),
            'kec' => $this->M_kec->allData(),
            'kel' => $this->M_kel->allData(),
            'jumlah' => $this->M_tps->count_tps_per_kabupaten(),
            'jumlah_kec' => $this->M_tps->count_tps_per_kecamatan(),
        );
        // var_dump($data['map']);
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function getMarkers() {
        // Ambil data dari model atau database Anda
        $data = $this->M_tps->allData(); // Gantilah Your_model dengan model Anda

        // Set header untuk menunjukkan bahwa respons adalah JSON
        $this->output->set_content_type('application/json');
        echo json_encode($data);
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

