<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kab extends CI_Model {

    // ambil data 
    public function allData(){
        $this->db->select('*');
        $this->db->from('kabupaten');
        return $this->db->get()->result();
    }
    public function isDuplicate($kode_kab)
    {     
        $this->db->get_where('kabupaten', array('kode_kab' => $kode_kab), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }

	//add
    public function add($data)
    {
        $this->db->insert('kabupaten',$data);
    }

    public function edit($data)
    {
        $this->db->where('kode_kab',$data['kode_kab']);
        $this->db->update('kabupaten',$data);
    }

    function get_detail_modal($id)
    {
        $this->db->select('*');
        $this->db->from('kabupaten');
        $this->db->where('kabupaten.kode_kab', $id);
        return $this->db->get()->row();
    }

    public function delete($data)
	{
		$this->db->where('kode_kab', $data['kode_kab']);
		$this->db->delete('kabupaten',$data);
	}
}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */