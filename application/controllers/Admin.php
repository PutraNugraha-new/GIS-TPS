<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
class Admin extends CI_Controller {

    public $status;
    public $roles;

    public function __construct()
	{
		parent::__construct();
        $this->load->model('User_model', 'user_model', TRUE);
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
        $this->load->library('userlevel');

		$this->load->model("M_tps");
		$this->load->model("M_kab");
		$this->load->model("M_kel");
		$this->load->model("M_kec");
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
        
	    $data['title'] = "Dashboard Admin";
	    
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data TPS',
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/gis/v_home',
                'map' => $this->M_tps->allData(),
                'kel' => $this->M_kel->allData(),
                'kab' => $this->M_kab->allData(),
                'kec' => $this->M_kec->allData(),
                'dataLevel' => $dataLevel
            );
           // var_dump($data);
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }
    }
    public function getDataForTable() {
        // Ambil data dari model atau database Anda
        $data = $this->M_tps->allData(); // Gantilah Your_model dengan model Anda

        // Set header untuk menunjukkan bahwa respons adalah JSON
        $this->output->set_content_type('application/json');
        echo json_encode($data);
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
	    
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data TPS',
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/gis/v_tambah',
                'map' => $this->M_tps->allData(),
                'kel' => $this->M_kel->allData(),
                'kab' => $this->M_kab->allData(),
                'kec' => $this->M_kec->allData(),
                'dataLevel' => $dataLevel
            );
            // var_dump($data);
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }
    }
    public function edit($id)
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
	    
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data TPS',
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/gis/v_edit',
                'map' => $this->M_tps->get_detail_modal($id),
                'kel' => $this->M_kel->allData(),
                'kab' => $this->M_kab->allData(),
                'kec' => $this->M_kec->allData(),
                'dataLevel' => $dataLevel
            );
            // var_dump($data);
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }
    }

    public function getTpsByKabupaten() {
        $kabupaten = $this->input->post('kabupaten');


        // Ambil data TPS berdasarkan kode kabupaten (ganti dengan model dan method yang sesuai)
        $tpsData = $this->M_tps->getTpsByKabupaten($kabupaten);

        // Kembalikan data dalam format JSON
        echo json_encode(array('tpsData' => $tpsData));

    }

    public function update($id){
        $i = $this->input;
            $data = array(
                'id_tps'	=> $id,
                'kode_kab'	=> $i->post('kode_kab'),
                'kode_kec'	=> $i->post('kode_kec'),
                'kode_kel'	=> $i->post('kode_kel'),
                'nama_tps'	=> $i->post('nama_tps'),
                'alamat'			=> $i->post('alamat'),
                'latitude'			=> $i->post('latitude'),
                'longitude'			=> $i->post('longitude')
            );
            // var_dump($data);
            // die();
            $this->M_tps->edit($data);
            $this->session->set_flashdata('sukses', ' Data TPS Berhasil DIUPDATE !');
            redirect('admin', 'refresh');

            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data TPS',
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/gis/v_home',
                'dataLevel' => $dataLevel
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }

    public function get_kecamatan_by_kabupaten($id_kabupaten) {
        $data = $this->M_tps->get_kecamatan_by_kabupaten($id_kabupaten);
        echo json_encode($data);
    }
    
    public function get_kelurahan_by_kecamatan($id_kecamatan) {
        $data = $this->M_tps->get_kelurahan_by_kecamatan($id_kecamatan);
        echo json_encode($data);
    }

    public function add()
	{
            $i = $this->input;
            $data = array(
                'kode_kab'	=> $i->post('kode_kab'),
                'kode_kec'	=> $i->post('kode_kec'),
                'kode_kel'	=> $i->post('kode_kel'),
                'nama_tps'	=> $i->post('nama_tps'),
                'alamat'			=> $i->post('alamat'),
                'longitude'			=> $i->post('longitude'),
                'latitude'			=> $i->post('latitude'),
            );
            $this->M_tps->add($data);
            $this->session->set_flashdata('sukses', ' Data TPS Berhasil Ditambahkan !');
            redirect('admin', 'refresh');

            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data TPS',
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/gis/v_home',
                'dataLevel' => $dataLevel
            );
		$this->load->view('admin/layout/v_wrapper', $data, FALSE);
	}

    //Delete one item
	public function hapus($id)
	{
		$data = array('id_tps' => $id);
		$this->M_tps->delete($data);
		$this->session->set_flashdata('sukses', 'Data Berhasil Dihapus');
		redirect('admin', 'refresh');
	}

    public function importData() {
        // Load library dan helper CodeIgniter yang diperlukan
       $this->load->helper('url');
       $this->load->helper('form');

       // Konfigurasi upload file
       $config['upload_path'] = './csv/';
       $config['allowed_types'] = 'xlsx';
       $config['max_size'] = 10240; // 10MB

       $this->load->library('upload', $config);
       $this->upload->initialize($config);

       // Proses upload file
       if (!$this->upload->do_upload('mentahTPS')) {
           $error = array('error' => $this->upload->display_errors());
           print_r($error);
           return;
       }

       // Dapatkan informasi file yang diunggah
       $upload_data = $this->upload->data();
       $fileTarget = $upload_data['full_path'];

       // Load library PhpSpreadsheet
       $spreadsheet = IOFactory::load($fileTarget);
       $sheet = $spreadsheet->getActiveSheet();
       $array = $sheet->toArray();

       $kodekabupaten = null;
       $kodekecamatan = null;
       $kodekelurahan = null;
       foreach (array_slice($array, 1) as $data) {
           $kabupaten = $data[0];
           $kecamatan = $data[1];
           $kelurahan = $data[2];


           if (($kabupaten != "")) {
               $ambilDetailkabupaten = $this->db->query("SELECT * FROM `kabupaten` WHERE LOWER (`nama_kab`) LIKE LOWER ('$kabupaten')");
               $detailkabupaten = $ambilDetailkabupaten->row_array();
               if ($detailkabupaten && isset($detailkabupaten['kode_kab'])) {
                   $kodekabupaten = $detailkabupaten['kode_kab'];
               }
           }
           if (($kecamatan != "")) {
                $kecamatanLike = "%". $kecamatan . "%";
                $ambilDetailkecamatan = $this->db->query("SELECT * FROM `kecamatan` WHERE LOWER (`nama_kec`) LIKE LOWER ('$kecamatanLike')");
                $detailkecamatan = $ambilDetailkecamatan->row_array();
                if ($detailkecamatan && isset($detailkecamatan['kode_kec'])) {
                    $kodekecamatan = $detailkecamatan['kode_kec'];
                }
            }
            if (($kelurahan != "") && ($kelurahan != "JUMLAH")) {
                $kelurahanLike = "%" . $kelurahan . "%";
                $ambilDetailKelurahan = $this->db->query("SELECT * FROM `kelurahan` WHERE LOWER (`nama_kel`) LIKE LOWER ('$kelurahanLike')");
                $detailkelurahan = $ambilDetailKelurahan->row_array();
                if ($detailkelurahan && isset($detailkelurahan['kode_kel'])) {
                    $kodekelurahan = $detailkelurahan['kode_kel'];
                }
            }
           if (($data[3] != "") && ($data[4] != "") && ($data[5] != "") && ($data[6] != "")) {
               $nomorTPS = $data[3];
               $potensiAlamatTPS = $this->db->escape_str($data[4]);
               $latitude = $data[5];
               $longitude = $data[6];
               // $data =[
               //     'lat' => $data[5],
               //     'long' => $data[6]
               // ];
               // if (strpos($data[7], ',') !== false) {
               //     // Jika ada koma, gunakan pendekatan dengan explode
               //     $lokasi = explode(",", $data[7]);
               //     $latitude = $lokasi[0];
               //     $longitude = $lokasi[1];
               // } else {
               //     // Jika tidak ada koma, gunakan pendekatan dengan preg_match
               //     preg_match('/([+-]?\d+\.\d+)\s+([+-]?\d+\.\d+)/', $data[7], $matches);
               //     $latitude = isset($matches[1]) ? $matches[1] : null;
               //     $longitude = isset($matches[2]) ? $matches[2] : null;
               // }

               

               $data = array(
                   'kode_kab' => $kodekabupaten,
                   'kode_kec' => $kodekecamatan,
                   'kode_kel' => $kodekelurahan,
                   'nama_tps' => $nomorTPS,
                   'alamat' => $potensiAlamatTPS,
                   'latitude' => $latitude,
                   'longitude' => $longitude
               );

               error_reporting(0);
               $this->M_tps->add($data);
            }
            // var_dump($data);
            // die();
            // die();
        }

       // Hapus file yang diunggah setelah selesai diproses
       $this->session->set_flashdata('sukses', ' Import Berhasil !');
       unlink($fileTarget);
       redirect('admin');
   }

    public function unduh_file($nama_file) {
        // Tentukan path lengkap ke file yang akan diunduh
        $this->load->helper('download');
        $file_path = FCPATH . 'assets/template/' . $nama_file;

        // Periksa apakah file ada
        if (file_exists($file_path)) {
            // Tentukan tipe konten untuk respons HTTP
            $tipe_konten = mime_content_type($file_path);

            // Lakukan unduhan
            force_download($nama_file, file_get_contents($file_path), $tipe_konten);
        } else {
            // Jika file tidak ditemukan, tampilkan pesan error atau redirect ke halaman lain
            echo "File tidak ditemukan";
        }
    }

    public function detail($id)
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
	    
        if(empty($this->session->userdata['email'])){
            redirect(site_url().'main/login/');
        }else{
            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data TPS',
                'user' => $this->session->userdata['first_name'],
                'isi'   =>  'admin/gis/v_detail',
                'map' => $this->M_tps->get_detail_modal($id),
                'kel' => $this->M_kel->allData(),
                'kab' => $this->M_kab->allData(),
                'kec' => $this->M_kec->allData(),
                'dataLevel' => $dataLevel
            );
            // var_dump($data);
            $this->load->view('admin/layout/v_wrapper', $data, FALSE);
        }
    }

}

/* End of file Admin.php */

