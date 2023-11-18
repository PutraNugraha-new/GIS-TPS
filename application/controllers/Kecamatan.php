<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends CI_Controller {
    public $status;
    public $roles;

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_kec");
        $this->load->model("M_kab");
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
            //check user level
            if($dataLevel == "is_admin"){
                if(empty($this->session->userdata['email'])){
                    redirect(site_url().'main/login/');
                }else{
                    $data = array(
                        'title2'=>'Data kecamatan',
                        'user' => $this->session->userdata['first_name'],
                        'isi'   =>  'admin/kecamatan/v_home',
                        'kec' => $this->M_kec->allData(),
                        'kab' => $this->M_kab->allData(),
                        'dataLevel' => $dataLevel
                    );
                    // var_dump($data);
                    $this->load->view('admin/layout/v_wrapper', $data, FALSE);
                }
            }else{
                redirect(site_url().'main/');
            }
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
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/kecamatan/v_home',
                'dataLevel' => $dataLevel
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
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/kecamatan/v_home',
                'dataLevel' => $dataLevel
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

