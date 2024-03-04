<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Datatable_model extends CI_Model
{
    /*nama tabel di My SQL*/
    public $table = 'tbl_kegiatan';
    
    /*kolom di tabel*/
    private $id = 'id';
    private $id_kegiatan = 'id_kegiatan';
    private $nama_kegiatan = 'id_kegiatan';
    
    var $column_order = array(null, 'id_kegiatan', 'nama_kegiatan', null); /*atur database bidang kolom untuk dapat dipesan secara data ke datatable*/
    var $column_search = array('id_kegiatan', 'nama_kegiatan'); /*atur database bidang kolom agar dapat dicari datanya di search datatable*/
    var $order = array('id' => 'asc');

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {

        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) /*Pengulangan kolom*/ 
        {
            if ($_POST['search']['value']) /*jika datatable mengirim POST lewat pencarian*/
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // braket terbuka. query Dimana dengan klausa OR lebih baik dengan tanda kurung. karena mungkin bisa digabungkan dengan WHERE lainnya dengan AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

function update($id_kegiatan, $data)
    {
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->update($this->table, $data);
    }
    
    function delete($id_kegiatan)
    {
        $this->db->where('id_kegiatan', $id_kegiatan);
        return $this->db->delete($this->table);
    }
}

