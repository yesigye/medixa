<?php $this->load->view('admin/header', array(
	'title' => lang('menu_appointments'),
	'link' => 'appointments',
	'pageTitle' => lang('menu_appointments'),
	'breadcrumb' => array(
        ['name' => lang('menu_appointments'), 'link'=> false],
    ),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
	)
)); ?>

<?php echo form_open(current_url()) ?>
	<div class="table-responsive mt-3">
		<table class="table" id="table">
			<thead>
				<tr>
					<th>Id</th>
					<th><?php echo lang('form_name') ?></th>
					<th><?php echo lang('title_user') ?></th>
					<th><?php echo lang('title_doctor') ?></th>
					<th><?php echo lang('form_date') ?></th>
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

<script>
document.addEventListener("DOMContentLoaded", function() {
	// Define new create item modal
	var create_modal = $('#modal-addType');
	
	// Define datatable
	const table = $('#table').DataTable({
		"processing": true,
		"serverSide": true,
		"rowId": 'id',
		"pageLength": <?php echo $this->app->pageLimit ?>,
		"ajax": "<?php echo site_url('appointments/api') ?>",
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
		],
		columns: [
            { data: "id" },
            {
				data: "title",
                render: function (data, type, row) {
					return '<div title="'+data+'" class="text-truncate"  style="max-width: 300px;">'+data+'</div>';
				}
			},
            { data: "user" },
            { data: "doctor" },
            { data: "date" },
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
		'<script type="text/javascript" src="'.base_url('assets/js/table-actions.js').'"></script>'
	]
]) ?>