# Datatable Basic Codeigniter 3
### Ini adalah code paling dasar untuk belajar menggunakan datatable.


### Saya akan memberikan sedikit gambaran kode yang saya tulis akan menjadi seperti dibawah ini :
<img width="100%" alt="datatable" src="https://github.com/Hoream-Ngoding/Create-Datatable-CI-3/assets/94790639/1e8c0a3a-16c9-4144-92de-a8417b8a7243">



### Page.php (Controller)
```php

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

```

### Datatable_model.php (Model)

```php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Datatable_model extends CI_Model
{
    /*nama tabel di My SQL*/
    public $table = 'tbl_kegiatan';

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

public function get_by_id($id_kegiatan)
    {
        $this->db->from($this->table);
        $this->db->where('id_kegiatan', $id_kegiatan);
        $query = $this->db->get();

        return $query->row();
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

```