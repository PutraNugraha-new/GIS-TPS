<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kec extends CI_Model {

    // ambil data 
    public function allData(){
        $this->db->select('*');
        $this->db->from('kecamatan');
        return $this->db->get()->result();
    }

    public function isDuplicate($kode_kec)
    {     
        $this->db->get_where('kecamatan', array('kode_kec' => $kode_kec), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }

    public function add($data){
        $this->db->insert('kecamatan', $data);
    }

    public function delete($data){
        $this->db->where('kode_kec', $data['kode_kec']);
        $this->db->delete('kecamatan', $data);
    }

    function get_detail_modal($id)
    {
        $this->db->select('*');
        $this->db->from('kecamatan');
        $this->db->where('kecamatan.kode_kec', $id);
        return $this->db->get()->row();
    }

    public function edit($data)
    {
        $this->db->where('kode_kec',$data['kode_kec']);
        $this->db->update('kecamatan',$data);
    }

    public function getTpsByKabupaten($kabupaten) {
        $this->db->select('*');
        $this->db->from('kecamatan');
        $this->db->where('kecamatan.kode_kab', $kabupaten);
    
        $query = $this->db->get();
    
        return $query->result();
    }
}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */