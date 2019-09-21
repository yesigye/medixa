<?php $this->load->view('admin/header', array(
	'title' => lang('menu_groups'),
	'pageTitle' => lang('menu_groups'),
	'link' => 'users',
	'sub_link' => 'groups',
	'breadcrumb' => array(
		1 => array('name' => lang('menu_users'), 'link'=> 'admin/users'),
		0 => array('name' => lang('menu_groups'), 'link'=> false),
	),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
	)
)); ?>

<div class="text-right">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#group-create-modal">
		<?php echo lang('btn_create') ?>
	</button>
</div>

<div class="table-responsive mt-3">
	<table class="table" id="table">
		<thead>
			<tr>
				<th>id</th>
				<th><?php echo lang('form_group_name') ?></th>
				<th><?php echo lang('form_group_description') ?></th>
				<th><?php echo lang('menu_users') ?></th>
				<th><?php echo lang('table_action') ?></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

<form method="POST" class="needs-validation" id="group-create" novalidate>
	<div class="modal fade" id="group-create-modal" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content border-0">
				<div class="modal-header">
					<b><?php echo lang('menu_groups') ?></b>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="text-muted">
						<?php echo lang('form_create_head') ?>
					</p>
					<div class="error-message"></div>

					<?php echo $this->load->view('form_fields', ['fields' => $form_fields]) ?>
					
					<button type="submit" name="add_user" value="ADD" class="btn btn-block btn-success mt-2">
						<?php echo lang('btn_create') ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
	// Define new create item modal
	var create_modal = $('#group-create-modal');
	
	// Define datatable
	// With a "Delete Selected" button
	const table = $('#table').DataTable({
		"processing": true,
		"serverSide": true,
		"rowId": 'id',
		"pageLength": <?php echo $this->app->pageLimit ?>,
		"ajax": "<?php echo site_url('users/api/groups') ?>",
		dom: 'Bfrtip',
		buttons: [
			{
				extend: "colvis",
				className: "btn-sm btn-secondary",
				titleAttr: 'Toggle visible columns',
				text: 'Columns'
			},
			{
				extend: "copy",
				className: "btn-sm btn-secondary",
				titleAttr: 'Copy to clipboard',
				text: 'Copy'
			},
			{
				extend: "excel",
				className: "btn-sm btn-secondary",
				titleAttr: 'Export in Excel',
				text: 'Excel'
			},
			{
				extend: "pdf",
				className: "btn-sm btn-secondary",
				titleAttr: 'Export in PDF',
				text: 'PDF'
			},
			{
				extend: 'selected',
				text: '<?php echo lang('btn_delete_selected') ?>',
				className: "btn-sm btn-danger",
				action: function ( e, dt, button, config ) {
					// Delete multiple selected items
					$.ajax({
						url: '<?php echo base_url('users/api/groups/delete') ?>',
						type: 'POST',
						data: {
							ids: table.columns().checkboxes.selected()[0],
							'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'
						},
						success: function(result) {
							table.rows('.selected').deselect().draw();
						},
					});
				}
			}
		],
		columns: [
            { data: "id" },
            { data: "name" },
            { data: "description" },
            {
				data: "users_count",
                className: "text-center",
                render: function (data, type, row) {
					return '<span class="badge '+((data == 0) ? 'badge-secondary' : 'badge-info')+'">'+data+'</span>';
				}
			},
            { 
				data: "action",
                className: "text-center"
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

	// Insert item to datatable
	$("#group-create").datatableInsert({
		table: table,
		formId: "group-create",
		alertId: 'app-notif',
		modal: create_modal,
		urlCreate: '<?php echo site_url('users/api/groups/create') ?>',
		csrf_token: '<?php echo $this->security->get_csrf_token_name() ?>',
		csrf_hash: '<?php echo $this->security->get_csrf_hash() ?>',
	});

	// Delete item from datatable
	$('#table').on('click', '.delete-row', function() {
		var row = $(this).parents('tr');
		// AJAX to delete item
		$.ajax({
			url: '<?php echo base_url('users/api/groups/delete/') ?>'+row.attr('id'),
			type: 'DELETE',
			success: function(result) {
				table.row(row).deselect().remove().draw();
			},
			error: function(result) {
				console.log(result);
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