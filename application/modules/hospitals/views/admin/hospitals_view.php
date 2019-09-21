<?php $this->load->view('admin/header', array(
	'title' => lang('menu_hospitals'),
	'link' => 'hospitals',
	'pageTitle' => lang('menu_hospitals'),
	'breadcrumb' => array(
        ['name' => lang('menu_hospitals'), 'link'=> false],
    ),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
	)
)); ?>

<div class="text-right">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add">
		<i class="fa fa-plus mr-1"></i> <?php echo lang('menu_hospitals') ?>
	</button>
</div>

<?php echo form_open(current_url()) ?>
	<div class="table-responsive mt-3">
		<table class="table" id="table">
			<thead>
				<tr>
					<th>Id</th>
					<th></th>
					<th><?php echo lang('form_name') ?></th>
					<th><?php echo lang('form_email') ?></th>
					<th><?php echo lang('menu_doctors') ?></th>
					<th><?php echo lang('form_status') ?></th>
					<th><?php echo lang('table_action') ?></th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>

	<button type="submit" name="update_types" value="submit" class="btn btn-success">
		<?php echo lang('btn_edit') ?>    
	</button>
<?php echo form_close() ?>

<?php echo form_open_multipart(current_url()) ?>
	<div
    id="modal-add"
    class="modal fade"
    <?php if (validation_errors() && $this->input->post('add_hospital')) echo 'data-trigger-modal="#modal-add"' ?>
    >
		<div class="modal-dialog">
			<div class="modal-content border-0">
				<div class="modal-header bg-primary text-white">
					<div class="modal-title"> <?php echo lang('menu_hospitals') ?> </div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <p><?php echo lang('title_create_hospital') ?></p>

					<?php $this->load->view('form_fields', ['fields' => $form_fields]) ?>
            
                    <button type="submit" class="btn btn-primary" name="add_hospital" value="Save">
                        <?php echo lang('btn_create') ?>
                    </button>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close() ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
	// Define new create item modal
	var create_modal = $('#modal-add');
	
	// Define datatable
	const table = $('#table').DataTable({
		"processing": true,
		"serverSide": true,
		"rowId": 'id',
		"pageLength": <?php echo $this->app->pageLimit ?>,
		"ajax": "<?php echo site_url('hospitals/api') ?>",
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
						url: '<?php echo base_url('hospitals/api/delete') ?>',
						type: 'POST',
						data: {
							ids: table.columns().checkboxes.selected()[0],
							'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'
						},
						success: function(result) {
							$('body').append(result)
							table.rows('.selected').deselect().draw();
						},
						error: function(result) {
							$('body').append(result)
						},
					});
				}
			}
		],
		columns: [
            { data: "id" },
            {
				data: "logo",
                className: "text-center",
                render: function (data, type, row) {
					return '<img src="'+data+'" style="width:30px">';
				}
			},
            { data: "name" },
            { data: "email" },
            {
				data: "doctors",
                className: "text-center",
                render: function (data, type, row) {
					return '<span class="badge badge-'+((data == 0) ? 'secondary' : 'primary')+'">'+data+'</span>';
				}
			},
            {
				data: "active",
                className: "text-center",
                render: function (data, type, row) {
					return '<i class="fa '+((data == 1) ? 'fa-check-circle text-success' : 'fa-times-circle text-danger')+'"></span>';
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
	$("#user-create").datatableInsert({
		table: table,
		formId: "user-create",
		alertId: 'app-notif',
		modal: create_modal,
		urlCreate: '<?php echo site_url('hospitals/api/create') ?>',
		csrf_token: '<?php echo $this->security->get_csrf_token_name() ?>',
		csrf_hash: '<?php echo $this->security->get_csrf_hash() ?>',
	});

	// Delete item from datatable
	$('#table').on('click', '.delete-row', function() {
		var row = $(this).parents('tr');
		// AJAX to delete item
		$.ajax({
			url: '<?php echo base_url('hospitals/api/delete/') ?>'+row.attr('id'),
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
		'<script type="text/javascript" src="'.base_url('assets/js/app.datatables.js').'"></script>',
		'<script type="text/javascript" src="'.base_url('assets/js/app.js').'"></script>',
	]
]) ?>