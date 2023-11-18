<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kabupaten extends CI_Controller {
    public $status;
    public $roles;

    public function __construct()
	{
		parent::__construct();
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
                    'title2'=>'Data Kabupaten',
                    'user' => $this->session->userdata['first_name'],
                    'isi'   =>  'admin/kabupaten/v_home',
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
        echo json_encode($this->M_kab->get_detail_modal($_POST['id']));
    }

    public function update($id){
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
                    'user' => $this->session->userdata['first_name'],
                    'isi'   =>  'admin/kabupaten/v_home',
                    'dataLevel' => $dataLevel
                );
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
            }else{
                redirect(site_url().'main/');
            }
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
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/kabupaten/v_home',
                'dataLevel' => $dataLevel
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

