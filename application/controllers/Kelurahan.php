<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kelurahan extends CI_Controller {
    public $status;
    public $roles;

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_kel");
        $this->load->model("M_kab");
		$this->load->model("M_kec");
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
                    'title2'=>'Data kelurahan',
                    'user' => $this->session->userdata['first_name'],
                    'isi'   =>  'admin/kelurahan/v_home',
                    'kec' => $this->M_kel->allData(),
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
        echo json_encode($this->M_kel->get_detail_modal($_POST['id']));
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
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/kelurahan/v_home',
                'dataLevel' => $dataLevel
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function add()
	{
        if($this->M_kel->isDuplicate($this->input->post('kode_kel'))){
            $this->session->set_flashdata('flash_message', 'Kode Kelurahan sudah ada');
            redirect(site_url().'kelurahan');
        }else{
            $i = $this->input;
            $data = array(
                'kode_kel'	=> $i->post('kode_kel'),
                'kode_kec'	=> $i->post('kode_kec'),
                'nama_kel'	=> $i->post('nama_kel'),
            );
            $this->M_kel->add($data);
            $this->session->set_flashdata('sukses', ' Data kelurahan Berhasil Ditambahkan !');
            redirect('kelurahan', 'refresh');

            $data = array(

                'title2'=>'Data TPS',
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/kelurahan/v_home',
                'dataLevel' => $dataLevel
            );
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }
	}

    //Delete one item
	public function hapus($id)
	{
		$data = array('kode_kel' => $id);
		$this->M_kel->delete($data);
		$this->session->set_flashdata('sukses', 'Data Berhasil Dihapus');
		redirect('kelurahan', 'refresh');
	}



}

/* End of file Admin.php */

