
<?php $this->load->view('admin/header', array(
	'title' => lang('menu_hospitals'),
	'link' => 'hospitals',
	'pageTitle' => $hospital_name,
	'breadcrumb' => array(
        ['name' => lang('menu_hospitals'), 'link'=> 'admin/hospitals'],
    ),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
	),
)); ?>

<?php $this->load->view('/sub_header', ['active' => 'users']) ?>

<div class="text-right">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-users">
		<?php echo lang('btn_assign_users') ?>
	</button>
</div>

<div class="table-responsive mt-3">
	<table class="table" id="table">
		<thead>
			<tr>
				<th>id</th>
				<th> <i class="fa fa-image"></i> </th>
				<th>username</th>
				<th>email</th>
				<th>active</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

<div class="modal fade" id="modal-users">
	<div class="modal-dialog modal-lg">
		<div class="modal-content border-0">
			<div class="modal-header">
				<strong class="modal-title"><?php echo lang('title_assign_users') ?></strong>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-muted"><?php echo $this->lang->line('subtitle_assign', '<b>"'.$hospital_name.'"</b>') ?></p>
				<div class="table-responsive mt-3">
					<table class="table table-sm" id="table-unassigned" style="width:100%">
						<thead>
							<tr>
								<th>id</th>
								<th>username</th>
								<th>email</th>
								<th>active</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
	// Define new create item modal
	var create_modal = $('#user-create-modal');
	
	// Define datatable
	const table = $('#table').DataTable({
		"processing": true,
		"serverSide": true,
		"rowId": 'id',
		"pageLength": <?php echo $this->app->pageLimit ?>,
		"ajax": '<?php echo site_url("hospitals/api/users/$hospital_id") ?>',
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'selected',
				text: '<?php echo lang('btn_remove_selected') ?>',
				className: "btn-sm btn-danger",
				action: function (e, dt, button, config) {
					// Delete multiple selected items
					$.ajax({
						url: '<?php echo base_url("hospitals/api/remove_assigned/$hospital_id") ?>',
						type: 'POST',
						data: {
							ids: table.columns().checkboxes.selected()[0],
							'<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'
						},
						success: function(result) {
							table.rows('.selected').deselect().draw();
							tableAssign.draw();
						},
					});
				}
			}
		],
		columns: [
            { data: "id" },
            {
				data: "thumbnail",
                className: "text-center",
                render: function (data, type, row) {
					return '<img src="'+data+'" style="width:30px">';
				}
			},
            { data: "username" },
            { data: "email" },
            {
				data: "active",
                className: "text-center",
                render: function (data, type, row) {
					return '<i class="fa '+((data == 0) ? 'fa-times-circle text-danger' : 'fa-check-circle text-success')+'"></i>';
				}
			},
        ],
		columnDefs: [{
			targets: 0,
			checkboxes: {
				selectRow: true,
			}
		}],
		select: {
			style: 'multi'
		},
		order: [[2, 'asc']],
		"drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-sm');
        }
	});

	const tableAssign = $('#table-unassigned').DataTable({
		"processing": true,
		"serverSide": true,
		"rowId": 'id',
		"pageLength": <?php echo $this->app->pageLimit ?>,
		"ajax": '<?php echo site_url("hospitals/api/nonUsers/$hospital_id") ?>',
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'selected',
				text: '<?php echo lang('btn_assign') ?>',
				className: "btn-sm btn-success",
				action: function ( e, dt, button, config ) {
					// Delete multiple selected items
					$.ajax({
						url: '<?php echo base_url("hospitals/api/assign/$hospital_id") ?>',
						type: 'POST',
						data: {
							ids: tableAssign.columns().checkboxes.selected()[0],
							'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'
						},
						success: function(result) {
							tableAssign.rows('.selected').deselect().draw();
							table.draw();
						},
					});
				}
			}
		],
		columns: [
            { data: "id" },
            { data: "username" },
            { data: "email" },
            {
				data: "active",
                className: "text-center",
                render: function (data, type, row) {
					return '<i class="fa '+((data == 0) ? 'fa-times-circle text-danger' : 'fa-check-circle text-success')+'"></i>';
				}
			},
        ],
		columnDefs: [{
			targets: 0,
			checkboxes: {
				selectRow: true,
			}
		}],
		select: {
			style: 'multi'
		},
		order: [[1, 'asc']],
		"drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-sm');
        }
	});

	// Delete item from datatable
	$('#table').on('click', '.delete-row', function() {
		var row = $(this).parents('tr');
		// AJAX to delete item
		$.ajax({
			url: '<?php echo base_url('users/api/delete/') ?>'+row.attr('id'),
			type: 'DELETE',
			success: function(result) {
				table.row(row).deselect().remove().draw();
			},
		});
	});

	create_modal.on('shown.bs.modal', function (e) {
		$(this).first('input').focus();
	})
});
</script>

<?php $this->load->view('admin/footer', [
	'scripts' => [
		'<script type="text/javascript" src="'.base_url('assets/vendor/datatables/datatables.min.js').'"></script>',
		'<script type="text/javascript" src="'.base_url('assets/vendor/datatables/dataTables.checkboxes.min.js').'"></script>',
		'<script type="text/javascript" src="'.base_url('assets/js/app.datatables.js').'"></script>'
	]
]) ?>