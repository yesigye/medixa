<?php $this->load->view('admin/header', array(
    'title' => lang('menu_facilities'),
	'link' => 'hospitals',
	'sub_link' => 'facilities',
	'pageTitle' => lang('menu_facilities'),
	'breadcrumb' => array(
        ['name' => lang('menu_hospitals'), 'link'=> 'admin/hospitals'],
        ['name' => lang('menu_facilities'), 'link'=> false],
    ),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
	)
)); ?>

<div class="text-right">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-addType">
		<i class="fa fa-plus mr-1"></i> <?php echo lang('menu_facilities') ?>
	</button>
</div>

<?php echo form_open(current_url()) ?>
	<div class="table-responsive mt-3">
		<table class="table" id="table">
			<thead>
				<tr>
					<th>Id</th>
					<th><?php echo lang('form_name') ?></th>
					<th><?php echo lang('form_code') ?></th>
					<th><?php echo lang('form_description') ?></th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>

	<button type="submit" name="update_facilities" value="submit" class="btn btn-success">
		<?php echo lang('btn_edit') ?>    
	</button>
<?php echo form_close() ?>

<div class="modal fade" id="modal-addType">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header">
                <div class="modal-title"><?php echo lang('form_create_head') ?></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (validation_errors() && $this->input->post('create')): ?>
                    <div class="alert alert-danger" data-trigger-modal="#modal-add"><?php echo lang('alert_') ?></div>
                <?php endif ?>
                <?php echo form_open(current_url()) ?>
                    <table class="table table-striped table-borderless">
                        <thead class="thead-info">
                            <tr>
                                <th><?php echo lang('form_name') ?></th>
                                <th><?php echo lang('form_description') ?></th>
                                <th class="text-center"><?php echo lang('form_action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($key=0; $key < $insertRows; $key++): ?>
                            <tr>
                                <td class="form-group <?php echo form_error('insert['.$key.'][name]') ? 'has-error' : null ?>">
                                    <input type="text" name="insert[<?= $key ?>][name]"
                                    class="form-control form-control-sm <?php echo form_error('insert['.$key.'][name]') ? 'is-invalid' : null ?>"
                                    value="<?php echo set_value('insert['.$key.'][name]') ? set_value('insert['.$key.'][name]') : null ?>">
                                    <div class="small text-danger"><?= form_error('insert['.$key.'][name]') ?></div>
                                </td>
                                <td class="form-group <?php echo form_error('insert['.$key.'][description]') ? 'has-error' : null ?>">
                                    <input type="text" name="insert[<?php echo $key ?>][description]" class="form-control form-control-sm" value="<?php echo set_value('insert['.$key.'][description]') ?>">
                                    <?php if (form_error('insert['.$key.'][description]')): ?>
                                        <?php echo form_error('insert['.$key.'][description]') ?>
                                    <?php endif ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" style="width:74px">
                                        <button type="button" class="btn btn-sm btn-outline-secondary copy-row">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                                            <span class="fa fa-minus"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endfor ?>
                        </tbody>
                    </table>
                    
                    <input type="submit" name="create" value="<?php echo lang('btn_create') ?>" class="btn btn-primary">
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
	// Define new create item modal
	var create_modal = $('#modal-addType');
	
	// Define datatable
	const table = $('#table').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": "<?php echo site_url('hospitals/api/facilities/') ?>",
		"rowId": 'id',
		"pageLength": <?php echo $this->app->pageLimit ?>,
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
						url: '<?php echo base_url('hospitals/api/deleteFacilities') ?>',
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
            { data: "code" },
            { data: "description" },
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