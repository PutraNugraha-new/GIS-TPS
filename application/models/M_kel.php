<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kel extends CI_Model {

    // ambil data 
    public function allData(){
        $this->db->select('*');
        $this->db->from('kelurahan');
        return $this->db->get()->result();
    }

    public function isDuplicate($kode_kel)
    {     
        $this->db->get_where('kelurahan', array('kode_kel' => $kode_kel), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }

    public function add($data){
        $this->db->insert('kelurahan', $data);
    }

    public function delete($data){
        $this->db->where('kode_kel', $data['kode_kel']);
        $this->db->delete('kelurahan', $data);
    }

    function get_detail_modal($id)
    {
        $this->db->select('*');
        $this->db->from('kelurahan');
        $this->db->where('kelurahan.kode_kel', $id);
        return $this->db->get()->row();
    }
}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */