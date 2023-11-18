<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_all extends CI_Model {

    // ambil data 
    public function countTps(){
        $this->db->select('*');
        $this->db->from('data_tps');
        return $this->db->count_all_results();
    }
    public function countKab(){
        $this->db->select('*');
        $this->db->from('kabupaten');
        return $this->db->count_all_results();
    }
    public function countKec(){
        $this->db->select('*');
        $this->db->from('kecamatan');
        return $this->db->count_all_results();
    }
    public function countKel(){
        $this->db->select('*');
        $this->db->from('kelurahan');
        return $this->db->count_all_results();
    }
}

/* End of file M_Wisata.php */
/* Location: ./application/models/M_Wisata.php */