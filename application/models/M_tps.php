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
    

	//add
    public function add($data)
    {
        $this->db->insert('tps',$data);
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


    public function get_kecamatan_by_kabupaten($id_kabupaten) {
        return $this->db->where('kode_kab', $id_kabupaten)->get('kecamatan')->result_array();
    }
    
    public function get_kelurahan_by_kecamatan($id_kecamatan) {
        return $this->db->where('kode_kec', $id_kecamatan)->get('kelurahan')->result_array();
    }
    
}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */