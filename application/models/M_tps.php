<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tps extends CI_Model {

    // ambil data 
    public function allData(){
        $this->db->select('data_tps.*, kabupaten.nama_kab, kecamatan.nama_kec, kelurahan.nama_kel');
        $this->db->from('data_tps');
        $this->db->join('kabupaten', 'kabupaten.kode_kab = data_tps.kode_kab', 'left');
        $this->db->join('kecamatan', 'kecamatan.kode_kec = data_tps.kode_kec', 'left');
        $this->db->join('kelurahan', 'kelurahan.kode_kel = data_tps.kode_kel', 'left');
        return $this->db->get()->result();
    }
    
    public function count_tps_per_kabupaten() {
        $this->db->select('kabupaten.nama_kab, COUNT(data_tps.id_tps) as total_tps');
        $this->db->from('data_tps');
        $this->db->join('kabupaten', 'data_tps.kode_kab = kabupaten.kode_kab', 'left');
        $this->db->group_by('kabupaten.nama_kab');
        $query = $this->db->get();
        return $query->result();
    }
    public function count_tps_per_kecamatan() {
        $this->db->select('kecamatan.nama_kec, COUNT(data_tps.id_tps) as total_tps');
        $this->db->from('data_tps');
        $this->db->join('kecamatan', 'data_tps.kode_kec = kecamatan.kode_kec', 'left');
        $this->db->group_by('kecamatan.nama_kec');
        $query = $this->db->get();
        return $query->result();
    }
    

	//add
    public function add($data)
    {
        $this->db->insert('data_tps',$data);
    }
    public function edit($data)
    {
        $this->db->where('id_tps',$data['id_tps']);
        $this->db->update('data_tps',$data);
    }

    public function delete($data)
	{
		$this->db->where('id_tps', $data['id_tps']);
		$this->db->delete('data_tps',$data);
	}


    function get_detail_modal($id)
    {
        $this->db->select('data_tps.*, kabupaten.nama_kab, kecamatan.nama_kec, kelurahan.nama_kel');
        $this->db->from('data_tps');
        $this->db->join('kabupaten', 'kabupaten.kode_kab = data_tps.kode_kab', 'left');
        $this->db->join('kecamatan', 'kecamatan.kode_kec = data_tps.kode_kec', 'left');
        $this->db->join('kelurahan', 'kelurahan.kode_kel = data_tps.kode_kel', 'left');
        $this->db->where('data_tps.id_tps', $id);
        return $this->db->get()->row();
    }

    public function getTpsByKabupaten($kabupaten) {
        $this->db->select('data_tps.*, kabupaten.nama_kab, kecamatan.nama_kec, kelurahan.nama_kel');
        $this->db->from('data_tps');
        $this->db->join('kabupaten', 'data_tps.kode_kab = kabupaten.kode_kab');
        $this->db->join('kecamatan', 'data_tps.kode_kec = kecamatan.kode_kec');
        $this->db->join('kelurahan', 'data_tps.kode_kel = kelurahan.kode_kel');
        $this->db->where('data_tps.kode_kab', $kabupaten);
    
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
        return $this->db->count_all_results('data_tps'); // Ganti 'nama_tabel' dengan nama tabel yang sesuai
    }

    
    
}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */