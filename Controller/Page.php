public function index (){
$this->load->template('template/kerangka', 'datatable');
}

public function datatables(){
$this->model->get_datatables();

}
