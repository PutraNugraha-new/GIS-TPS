<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tps extends CI_Model {

    // ambil data 
    public function allData(){
        $this->db->select('*');
        $this->db->from('tps');
        return $this->db->get()->result();
    }

	//add
    public function add($data)
    {
        $this->db->insert('tps',$data);
    }


    function get_detail_modal($id)
	{
		return $this->db->where('id_tps', $id)
			->get('tps')
			->row();
	}
}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */