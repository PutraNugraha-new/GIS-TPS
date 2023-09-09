<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kabupaten extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_kab");
	}

    public function index()
    {
        $data = array(
            'title2'=>'Data Kabupaten',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/kabupaten/v_home',
            'kab' => $this->M_kab->allData(),
        );
        // var_dump($data);
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function edit() {
        echo json_encode($this->M_kab->get_detail_modal($_POST['id']));
    }

    public function update($id){
        $i = $this->input;
            $data = array(
                'kode_kab'	=> $id,
                'nama_kab'	=> $i->post('nama_kab'),
            );
            // var_dump($data);
            $this->M_kab->edit($data);
            $this->session->set_flashdata('sukses', ' Data Berhasil DIUPDATE !');
            redirect('kabupaten', 'refresh');

            $data = array(

                'title2'=>'Data TPS',
                'user' => 'Putra Nugraha',
                'isi'   =>  'admin/kabupaten/v_home',
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function add()
	{
            $i = $this->input;
            $data = array(
                'kode_kab'	=> $i->post('kode_kab'),
                'nama_kab'	=> $i->post('nama_kab'),
            );
            $this->M_kab->add($data);
            $this->session->set_flashdata('sukses', ' Data Kabupaten Berhasil Ditambahkan !');
            redirect('Kabupaten', 'refresh');

            $data = array(

                'title2'=>'Data TPS',
                'user' => 'Putra Nugraha',
                'isi'   =>  'admin/kabupaten/v_home',
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
	}

    //Delete one item
	public function hapus($id)
	{
		$data = array('kode_kab' => $id);
		$this->M_kab->delete($data);
		$this->session->set_flashdata('sukses', 'Data Berhasil Dihapus');
		redirect('kabupaten', 'refresh');
	}



}

/* End of file Admin.php */

