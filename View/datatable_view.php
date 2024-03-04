/*Template*/

<script type="text/javascript">
	var table;
	var base_url = '<?php echo base_url(); ?>';

	$(document).ready(function() {
		//datatables
		table = $('#table').DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			/*Memuat data untuk konten tabel dari sumber Ajax*/
			"ajax": {
				"url": "<?php echo site_url('member/kegiatan/program/ajax_list') ?>",
				"type": "POST"
			},

			//Tetapkan properti kolom.
			"columnDefs": [{
					"targets": [0], //kolom ke 1
					"orderable": false, //diatur tidak bisa di searching
				}, {
					"targets": [3], //kolom ke 4
					"orderable": false, //diatur tidak bisa di searching
				},
			],
		});
	}  
                    </script>

<div class="page-inner">
	<div class="page-header">
		<h4 class="page-title">Program</h4>
		<ul class="breadcrumbs">
			<li class="nav-home">
				<a href="#">
					<i class="fas fa-tasks"></i>
				</a>
			</li>
		</ul>
	</div>
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="d-flex align-items-center">
					<h4 class="card-title">Program</h4>
					<div class="ml-auto">
					
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
						<div class="row">
							<div class="col-sm-12">
			          /*Datatables*/
								<table id="table" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
									<thead>
										<tr role="row">
											<th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">#</th>
											<th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">ID Kegiatan</th>
											<th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">Nama Kegiatan</th>
											<th tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Opsi</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

/*Template*/
