<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Page extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Page_model', 'page_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        //menampilkan halaman datatable_view
        $this->template->load('template/kerangka', 'datatable_view');
    }

    //ajax get datatables
    public function ajax_list()
    {    
        $list = $this->page_model->get_datatables(); /*memanggil fungsi get_datatables() di page_model*/
        $data = array();  //data yang dikembalikan berupa array
        $no = $_POST['start'];
        foreach ($list as $ta) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ta->id_kegiatan;
            $row[] = $ta->nama_kegiatan;

            //add html for action
            $row[] = '
            <a class="btn btn-sm btn-primary" href="' . site_url('page/update/' . $ta->id_kegiatan) . '" title="Edit"><i class="fas fa-edit"></i> <?php echo ' . $ta->id_kegiatan . '; ?></a>
            <a class="btn btn-sm btn-danger" href="' . site_url('page/delete/' . $ta->id_kegiatan) . '" title="Delete"><i class="fas fa-trash"></i> <?php echo ' . $ta->id_kegiatan . '; ?></a>
            <a class="btn btn-sm btn-info" href="' . site_url('peserta/kegiatan/' . $ta->id_kegiatan) . '" title="Setting"><i class="fas fa-users"></i> <?php echo ' . $ta->id_kegiatan . '; ?></a>'; /*catatan : buat dulu controller "Peserta.php" didalamnya ada function "kegiatan" jika tidak akan eror*/

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->promo->count_all(),
            "recordsFiltered" => $this->promo->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    //ajax get datatables
}

