<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kel extends CI_Model {

    // ambil data 
    public function allData(){
        $this->db->select('*');
        $this->db->from('kelurahan');
        return $this->db->get()->result();
    }

}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */