# Create-Datatable-CI-3
Cara membuat Datatable di Codeigniter 3 dengan menyertakan Folder Controller, Model, dan View.
Ini adalah code paling dasar untuk belajar menggunakan datatable.

Saya akan memberikan sedikit gambaran kode yang saya tulis akan menjadi seperti dibawah ini :
<img width="793" alt="datatable" src="https://github.com/Hoream-Ngoding/Create-Datatable-CI-3/assets/94790639/1e8c0a3a-16c9-4144-92de-a8417b8a7243">



public function delete($id)
    {
        $this->promo->delete($id);
        $this->session->set_flashdata('message', 'Berhasil menghapus Data Siswa');
        redirect(site_url('member/kegiatan/program'));
    }


