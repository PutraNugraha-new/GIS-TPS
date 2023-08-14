<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_tps");
	}

    public function index()
    {
        $data = array(
            'title'=>'Sistem Informasi ...',
            'title2'=>'Data TPS',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/v_home',
            'map' => $this->M_tps->allData(),
        );
        // var_dump($data);
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function add()
	{
            $i = $this->input;
            $data = array(
                'nama_tps'	=> $i->post('nama_tps'),
                'kode_kab'	=> $i->post('kode_kab'),
                'kode_kel'	=> $i->post('kode_kel'),
                'alamat'			=> $i->post('alamat'),
                'longitude'			=> $i->post('longitude'),
                'latitude'			=> $i->post('latitude'),
                'lk'			=> $i->post('lk'),
                'pr'			=> $i->post('pr'),
            );
            $this->M_tps->add($data);
            $this->session->set_flashdata('sukses', ' Data Wisata Berhasil Ditambahkan !');
            redirect('admin', 'refresh');

            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data TPS',
                'user' => 'Putra Nugraha',
                'isi'   =>  'admin/v_home',
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
	}



}

/* End of file Admin.php */

