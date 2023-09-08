<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tps extends CI_Model {

    // ambil data 
    public function allData(){
        $this->db->select('tps.*, kabupaten.nama_kab, kecamatan.nama_kec, kelurahan.nama_kel');
        $this->db->from('tps');
        $this->db->join('kabupaten', 'kabupaten.kode_kab = tps.kode_kab', 'left');
        $this->db->join('kecamatan', 'kecamatan.kode_kec = tps.kode_kec', 'left');
        $this->db->join('kelurahan', 'kelurahan.kode_kel = tps.kode_kel', 'left');
        return $this->db->get()->result();
    }
    
    public function count_tps_per_kabupaten() {
        $this->db->select('kabupaten.nama_kab, COUNT(tps.id_tps) as total_tps');
        $this->db->from('tps');
        $this->db->join('kabupaten', 'tps.kode_kab = kabupaten.kode_kab', 'left');
        $this->db->group_by('kabupaten.nama_kab');
        $query = $this->db->get();
        return $query->result();
    }
    

	//add
    public function add($data)
    {
        $this->db->insert('tps',$data);
    }
    public function edit($data)
    {
        $this->db->where('id_tps',$data['id_tps']);
        $this->db->update('tps',$data);
    }

    public function delete($data)
	{
		$this->db->where('id_tps', $data['id_tps']);
		$this->db->delete('tps',$data);
	}


    function get_detail_modal($id)
    {
        $this->db->select('tps.*, kabupaten.nama_kab, kecamatan.nama_kec, kelurahan.nama_kel');
        $this->db->from('tps');
        $this->db->join('kabupaten', 'kabupaten.kode_kab = tps.kode_kab', 'left');
        $this->db->join('kecamatan', 'kecamatan.kode_kec = tps.kode_kec', 'left');
        $this->db->join('kelurahan', 'kelurahan.kode_kel = tps.kode_kel', 'left');
        $this->db->where('tps.id_tps', $id);
        return $this->db->get()->row();
    }

    public function getTpsByKabupaten($kabupaten) {
        $this->db->select('tps.*, kabupaten.nama_kab, kecamatan.nama_kec, kelurahan.nama_kel');
        $this->db->from('tps');
        $this->db->join('kabupaten', 'tps.kode_kab = kabupaten.kode_kab');
        $this->db->join('kecamatan', 'tps.kode_kec = kecamatan.kode_kec');
        $this->db->join('kelurahan', 'tps.kode_kel = kelurahan.kode_kel');
        $this->db->where('tps.kode_kab', $kabupaten);
    
        $query = $this->db->get();
    
        return $query->result();
    }
    


    public function get_kecamatan_by_kabupaten($id_kabupaten) {
        return $this->db->where('kode_kab', $id_kabupaten)->get('kecamatan')->result_array();
    }
    
    public function get_kelurahan_by_kecamatan($id_kecamatan) {
        return $this->db->where('kode_kec', $id_kecamatan)->get('kelurahan')->result_array();
    }

    public function hitungDataByKodeKab($kodeKab) {
        $this->db->where('kode_kab', $kodeKab);
        return $this->db->count_all_results('tps'); // Ganti 'nama_tabel' dengan nama tabel yang sesuai
    }

    public function importCsvData($filePath) {
        $handle = fopen($filePath, "r");
        if ($handle) {
            $this->db->trans_start(); // Memulai transaksi database
    
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $productData = array(
                    'kode_kab' => $data[0],
                    'kode_kec' => $data[1],
                    'kode_kel' => $data[2],
                    'nama_tps' => $data[3],
                    'alamat' => $data[4],
                    'latitude' => $data[5],
                    'longitude' => $data[6],
                );
    
                $this->db->insert('tps', $productData);
            }
    
            $this->db->trans_complete(); // Menyelesaikan transaksi database
    
            fclose($handle);
    
            if ($this->db->trans_status() === FALSE) {
                return false; // Gagal menambahkan data
            } else {
                return true; // Sukses menambahkan data
            }
        }
    
        return false; // Gagal membuka file
    }
    
    
}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */