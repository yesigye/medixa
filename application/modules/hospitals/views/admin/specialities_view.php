<?php $this->load->view('admin/header', array(
	'title' => lang('menu_hospitals'),
	'link' => 'hospitals',
	'sub_link' => 'specialities',
	'pageTitle' => lang('menu_specialities'),
	'breadcrumb' => array(
        ['name' => lang('menu_hospitals'), 'link'=> 'admin/hospitals'],
        ['name' => lang('menu_specialities'), 'link'=> false],
    ),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
	)
)); ?>

<div class="text-right">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-addType">
		<i class="fa fa-plus mr-1"></i> <?php echo lang('menu_specialities') ?>
	</button>
</div>

<?php echo form_open(current_url()) ?>
	<div class="table-responsive mt-3">
		<table class="table" id="table">
			<thead>
				<tr>
					<th>Id</th>
					<th><?php echo lang('form_doctor_speciality') ?></th>
					<th><?php echo lang('form_hospital_description') ?></th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>

	<button type="submit" name="update_types" value="submit" class="btn btn-success">
		<?php echo lang('btn_edit') ?>    
	</button>
<?php echo form_close() ?>

<div class="modal fade" id="modal-addType">
	<div class="modal-dialog modal-lg">
		<div class="modal-content border-0">
			<div class="modal-header">
				<h5 class="modal-title">Add Specialities</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body table-responsive">
                <?php echo form_open(current_url()) ?>
                <?php if(validation_errors() && $this->input->post('create')): ?>
                    <div class="alert alert-danger alert-dismissable" data-trigger-modal="#modal-spec">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        Check the errors and try again.
                    </div>
                <?php endif ?>
                <table class="table table-sm table-stripped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Key</th>
                            <th>Name</th>
                            <th class="text-center">Row&nbspAction</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($key=0; $key < $insertRows; $key++): ?>
                        <tr>
                            <td>
                                <input type="text" name="insert[<?= $key ?>][name]"
                                class="form-control form-control-sm <?php echo form_error('insert['.$key.'][name]') ? 'is-invalid' : null ?>"
                                value="<?php echo set_value('insert['.$key.'][name]') ? set_value('insert['.$key.'][name]') : null ?>">
                                <div class="small text-danger">
                                    <?php echo (form_error('insert['.$key.'][name]')) ?>
                                </div>
                            </td>
                            <td>
                                <textarea name="insert[<?= $key ?>][description]"
                                    class="form-control form-control-sm <?php echo form_error('insert['.$key.'][description]') ? 'is-invalid' : null ?>"
                                    ><?php echo set_value('insert['.$key.'][description]') ? set_value('insert['.$key.'][description]') : null ?></textarea>
                                <div class="small text-danger">
                                    <?php echo (form_error('insert['.$key.'][description]')) ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
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
                <button type="submit" name="create" value="1" class="btn btn-primary">Create</button>
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
		"rowId": 'id',
		"pageLength": <?php echo $this->app->pageLimit ?>,
		"ajax": "<?php echo site_url('hospitals/api/specialties') ?>",
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
						url: '<?php echo base_url('hospitals/api/deleteSpecialty') ?>',
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