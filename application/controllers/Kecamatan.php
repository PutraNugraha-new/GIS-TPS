<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_kec");
        $this->load->model("M_kab");
	}

    public function index()
    {
        $data = array(
            'title2'=>'Data kecamatan',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/kecamatan/v_home',
            'kec' => $this->M_kec->allData(),
            'kab' => $this->M_kab->allData(),
        );
        // var_dump($data);
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function edit() {
        echo json_encode($this->M_kec->get_detail_modal($_POST['id']));
    }

    public function update($id){
        $i = $this->input;
            $data = array(
                'kode_kec'	=> $id,
                'kode_kab'	=> $i->post('kode_kab'),
                'nama_kec'	=> $i->post('nama_kec'),
            );
            $this->M_kec->edit($data);
            $this->session->set_flashdata('sukses', ' Data  Berhasil DIUPDATE !');
            redirect('kecamatan', 'refresh');

            $data = array(

                'title2'=>'Data TPS',
                'user' => 'Putra Nugraha',
                'isi'   =>  'admin/kecamatan/v_home',
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function add()
	{
            $i = $this->input;
            $data = array(
                'kode_kec'	=> $i->post('kode_kec'),
                'kode_kab'	=> $i->post('kode_kab'),
                'nama_kec'	=> $i->post('nama_kec'),
            );
            $this->M_kec->add($data);
            $this->session->set_flashdata('sukses', ' Data kecamatan Berhasil Ditambahkan !');
            redirect('kecamatan', 'refresh');

            $data = array(

                'title2'=>'Data TPS',
                'user' => 'Putra Nugraha',
                'isi'   =>  'admin/kecamatan/v_home',
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
	}

    //Delete one item
	public function hapus($id)
	{
		$data = array('kode_kec' => $id);
		$this->M_kec->delete($data);
		$this->session->set_flashdata('sukses', 'Data Berhasil Dihapus');
		redirect('kecamatan', 'refresh');
	}

    public function getTpsByKabupaten() {
        $kabupaten = $this->input->post('kabupaten');
        // Ambil data TPS berdasarkan kode kabupaten (ganti dengan model dan method yang sesuai)
        $tpsData = $this->M_kec->getTpsByKabupaten($kabupaten);
        // Kembalikan data dalam format JSON
        echo json_encode(array('tpsData' => $tpsData));

    }



}

/* End of file Admin.php */

