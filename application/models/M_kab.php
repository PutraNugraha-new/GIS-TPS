<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kab extends CI_Model {

    // ambil data 
    public function allData(){
        $this->db->select('*');
        $this->db->from('kabupaten');
        return $this->db->get()->result();
    }

	//add
    public function add($data)
    {
        $this->db->insert('kabupaten',$data);
    }

    public function delete($data)
	{
		$this->db->where('kode_kab', $data['kode_kab']);
		$this->db->delete('kabupaten',$data);
	}
}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */