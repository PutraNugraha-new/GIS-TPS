<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kelurahan extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_kel");
	}

    public function index()
    {
        $data = array(
            'title2'=>'Data kelurahan',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/kelurahan/v_home',
            'kec' => $this->M_kel->allData(),
        );
        // var_dump($data);
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function edit($id)
    {
        $data = array(
            'title2'=>'Data TPS',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/kelurahan/v_edit',
            'kab' => $this->M_kel->allData(),
        );
        // var_dump($data);
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function update($id){
        $i = $this->input;
            $data = array(
                'id_tps'	=> $id,
                'nama_tps'	=> $i->post('nama_tps'),
                'kode_kab'	=> $i->post('kode_kab'),
                'kode_kec'	=> $i->post('kode_kec'),
                'kode_kel'	=> $i->post('kode_kel'),
                'alamat'			=> $i->post('alamat'),
                'latitude'			=> $i->post('latitude'),
                'longitude'			=> $i->post('longitude')
            );
            $this->M_tps->edit($data);
            $this->session->set_flashdata('sukses', ' Data Berhasil DIUPDATE !');
            redirect('admin', 'refresh');

            $data = array(

                'title2'=>'Data TPS',
                'user' => 'Putra Nugraha',
                'isi'   =>  'admin/kelurahan/v_home',
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function add()
	{
            $i = $this->input;
            $data = array(
                'kode_kec'	=> $i->post('kode_kec'),
                'nama_kec'	=> $i->post('nama_kec'),
            );
            $this->M_kel->add($data);
            $this->session->set_flashdata('sukses', ' Data kelurahan Berhasil Ditambahkan !');
            redirect('kelurahan', 'refresh');

            $data = array(

                'title2'=>'Data TPS',
                'user' => 'Putra Nugraha',
                'isi'   =>  'admin/kelurahan/v_home',
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
	}

    //Delete one item
	public function hapus($id)
	{
		$data = array('kode_kec' => $id);
		$this->M_kel->delete($data);
		$this->session->set_flashdata('sukses', 'Data Berhasil Dihapus');
		redirect('kelurahan', 'refresh');
	}



}

/* End of file Admin.php */

