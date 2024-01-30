<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public $status;
    public $roles;

    public function __construct()
	{
		parent::__construct();
        $this->load->model('User_model', 'user_model', TRUE);
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
                    'title2'=>'Data Pengguna',
                    'user' => $this->session->userdata['first_name'],
                    'isi'   =>  'admin/users/v_home',
                    'groups' => $this->user_model->getUserData(),
                    'dataLevel' => $dataLevel
                );
                // var_dump($data);
                $this->load->view('admin/layout/v_wrapper', $data, FALSE);
            }
        }else{
            redirect(site_url().'main/');
        }
    }

    public function tambah()
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
                    'title'=>'Sistem Informasi ...',
                    'title2'=>'Data Pengguna',
                    'user' => $this->session->userdata['first_name'],
                    'isi'   =>  'admin/users/v_tambah',
                    'dataLevel' => $dataLevel
                );
                // var_dump($data);
                $this->load->view('admin/layout/v_wrapper', $data, FALSE);
            }
        }else{
            redirect(site_url().'main/');
        }
    }

    public function adduser()
    {
        $data = $this->session->userdata;
        if(empty($data['role'])){
	        redirect(site_url().'main/login/');
	    }

        //check user level
	    if(empty($data['role'])){
	        redirect(site_url().'main/login/');
	    }
	    $dataLevel = $this->userlevel->checkLevel($data['role']);
	    //check user level

	    //check is admin or not
	    if($dataLevel == "is_admin"){
            $this->form_validation->set_rules('firstname', 'First Name', 'required');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('role', 'role', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data Pengguna',
                'user' => $this->session->userdata['first_name'],
                'dataLevel' => $dataLevel,
                'isi'   =>  'admin/users/v_tambah',
            );
            // var_dump($data);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/layout/v_wrapper', $data, FALSE);
            }else{
                if($this->user_model->isDuplicate($this->input->post('email'))){
                    $this->session->set_flashdata('flash_message', 'User email already exists');
                    redirect(site_url().'users/adduser');
                }else{
                    $this->load->library('password');
                    $post = $this->input->post(NULL, TRUE);
                    $cleanPost = $this->security->xss_clean($post);
                    $hashed = $this->password->create_hash($cleanPost['password']);
                    $cleanPost['email'] = $this->input->post('email');
                    $cleanPost['role'] = $this->input->post('role');
                    $cleanPost['firstname'] = $this->input->post('firstname');
                    $cleanPost['lastname'] = $this->input->post('lastname');
                    $cleanPost['banned_users'] = 'unban';
                    $cleanPost['password'] = $hashed;
                    unset($cleanPost['passconf']);

                    //insert to database
                    if(!$this->user_model->addUser($cleanPost)){
                        $this->session->set_flashdata('flash_message', 'There was a problem add new user');
                    }else{
                        $this->session->set_flashdata('success_message', 'New user has been added.');
                    }
                    redirect(site_url().'users');
                };
            }
	    }else{
	        redirect(site_url().'main/');
	    }
    }

    //delete user
    public function deleteuser($id) {
        $data = $this->session->userdata;
        if(empty($data['role'])){
        redirect(site_url().'main/login/');
    }
    $dataLevel = $this->userlevel->checkLevel($data['role']);
    //check user level

    //check is admin or not
    if($dataLevel == "is_admin"){
        $this->user_model->deleteUser($id);
        if($this->user_model->deleteUser($id) == FALSE )
        {
            $this->session->set_flashdata('flash_message', 'Error, cant delete the user!');
        }
        else
        {
            $this->session->set_flashdata('success_message', 'Delete user was successful.');
        }
        redirect(site_url().'users');
    }else{
        redirect(site_url().'users');
    }
}

public function edit() {
    echo json_encode($this->user_model->get_detail_modal($_POST['id']));
}

public function banuser() 
	{
        $data = $this->session->userdata;
        //check user level
	    if(empty($data['role'])){
	        redirect(site_url().'main/login/');
	    }
	    $dataLevel = $this->userlevel->checkLevel($data['role']);
	    //check user level

	    $data['title'] = "Ban User";
	    $data['groups'] = $this->user_model->getUserData();

	    //check is admin or not
	    if($dataLevel == "is_admin"){

            $this->form_validation->set_rules('email', 'Your Email', 'required');
            $this->form_validation->set_rules('banuser', 'Ban or Unban', 'required');

            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data Pengguna',
                'user' => $this->session->userdata['first_name'],
                'dataLevel' => $dataLevel,
                'isi'   =>  'users',
            );
            // var_dump($data);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('admin/layout/v_wrapper', $data, FALSE);
            }else{
                $post = $this->input->post(NULL, TRUE);
                $cleanPost = $this->security->xss_clean($post);
                $cleanPost['email'] = $this->input->post('email');
                $cleanPost['banuser'] = $this->input->post('banuser');
                if(!$this->user_model->updateUserban($cleanPost)){
                    $this->session->set_flashdata('flash_message', 'There was a problem updating');
                }else{
                    $this->session->set_flashdata('success_message', 'The status user has been updated.');
                }
                redirect(site_url().'users');
            }
	    }else{
	        redirect(site_url().'users');
	    }
	}



}

/* End of file Admin.php */

