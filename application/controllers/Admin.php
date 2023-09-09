<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model("M_tps");
		$this->load->model("M_kab");
		$this->load->model("M_kel");
		$this->load->model("M_kec");
	}

    public function index()
    {
        $data = array(
            'title'=>'Sistem Informasi ...',
            'title2'=>'Data TPS',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/gis/v_home',
            'map' => $this->M_tps->allData(),
            'kel' => $this->M_kel->allData(),
            'kab' => $this->M_kab->allData(),
            'kec' => $this->M_kec->allData()
        );
        // var_dump($data);
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }
    public function tambah()
    {
        $data = array(
            'title'=>'Sistem Informasi ...',
            'title2'=>'Data TPS',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/gis/v_tambah',
            'map' => $this->M_tps->allData(),
            'kel' => $this->M_kel->allData(),
            'kab' => $this->M_kab->allData(),
            'kec' => $this->M_kec->allData()
        );
        // var_dump($data);
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
    }
    public function edit($id)
    {
        $data = array(
            'title'=>'Sistem Informasi ...',
            'title2'=>'Data TPS',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/gis/v_edit',
            'map' => $this->M_tps->get_detail_modal($id),
            'kel' => $this->M_kel->allData(),
            'kab' => $this->M_kab->allData(),
            'kec' => $this->M_kec->allData()
        );
        // var_dump($data);
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
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
            $this->M_tps->edit($data);
            $this->session->set_flashdata('sukses', ' Data TPS Berhasil DIUPDATE !');
            redirect('admin', 'refresh');

            $data = array(
                'title'=>'Sistem Informasi ...',
                'title2'=>'Data TPS',
                'user' => 'Putra Nugraha',
                'isi'   =>  'admin/gis/v_home',
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
                'user' => 'Putra Nugraha',
                'isi'   =>  'admin/gis/v_home',
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
        if ($_FILES['csv_file']['name']) {
            $config['upload_path']   = './csv/';
            $config['allowed_types'] = 'csv';
            $config['max_size']      = 1000; // maksimum file size (KB)
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('csv_file')) {
                $fileData = $this->upload->data();
                $filePath = './csv/' . $fileData['file_name'];
                
                $this->load->model('M_tps');
    
                if ($this->M_tps->importCsvData($filePath)) {
                    // Impor berhasil
                    $this->session->set_flashdata('sukses', ' Import Berhasil !');
                    unlink($filePath);
                    redirect('admin'); // Ganti 'products' dengan halaman yang sesuai
                } else {
                    // Impor gagal
                    $data['error'] = "Terjadi kesalahan saat mengimpor data.";
                }
            } else {
                // Error upload file
                $data['error'] = $this->upload->display_errors();
            }
        }
        $data = array(
            'title'=>'Sistem Informasi ...',
            'title2'=>'Data TPS',
            'user' => 'Putra Nugraha',
            'isi'   =>  'admin/gis/v_home',
            'map' => $this->M_tps->allData(),
            'kel' => $this->M_kel->allData(),
            'kab' => $this->M_kab->allData(),
            'kec' => $this->M_kec->allData()
        );
        // Load view untuk menampilkan form impor
        $this->load->view('admin/layout/v_wrapper', $data, FALSE);
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
    

}

/* End of file Admin.php */

