<?php
$breadcrumb = [0 => ['name' => lang('menu_locations_th'), 'link' => 'admin/locations']];

// Add tier lineage to breadrumb
foreach ($lineage as $key => $tier) {
    // Do not provide a link for the last tier
    $tierLink = ($key == count($lineage)-1) ? false : 'admin/locations/areas/'.$tier['id'];
    
    array_push($breadcrumb, ['name' => $tier['name'], 'link' => $tierLink]);
}
?>

<?php $this->load->view('admin/header', array(
	'title' => lang('menu_locations_th'),
	'pageTitle' => $this->lang->line('menu_locations_places_in', $lineage[count($lineage)-1]['name']),
	'link' => 'locations',
	'breadcrumb' => $breadcrumb,
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
	)
)); ?>

<div class="text-right">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-addPlaces">
        <i class="fa fa-plus"></i> <?php echo $lineage[count($lineage)-1]['name'] ?>
    </button>
</div>

<?php echo form_open(current_url().'#tab-places') ?>
<div class="table-responsive mt-3">
    <table class="table" id="table">
        <thead>
            <tr>
                <th>Id</th>
                <th><?php echo lang('form_location_level') ?></th>
                
                <?php if($parent): ?>
                <th><?php echo lang('form_location_parent') ?></th>
                <?php endif ?>

                <th><?php echo lang('form_location_code') ?></th>
                <th><?php echo lang('table_action') ?></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<button type="submit" name="update_locations" value="submit" class="btn btn-success">
    <?php echo lang('btn_edit') ?>    
</button>
<?php echo form_close() ?>

<div class="modal fade" id="modal-addPlaces" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title">
                    Add a new <b><?php echo $lineage[count($lineage)-1]['name'] ?></b>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <?php if (validation_errors() AND $this->input->post('add_locations')): ?>
                    <div class="alert alert-danger">
                        Correct the errors in the form and try again.
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#modal-addLocations').modal('show')
                        })
                    </script> 
                <?php endif ?>
                <?php echo form_open(current_url().'#tab-places') ?>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th><?php echo lang('form_location_level') ?></th>
                                <?php if($parent): ?>
                                <th><?php echo lang('form_location_parent') ?></th>
                                <?php endif ?>
                                <th><?php echo lang('form_location_code') ?></th>
                                <th><?php echo lang('table_action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($key=0; $key < $insertRows; $key++): ?>
                            <tr>
                                <td class="form-group <?php echo form_error('insert['.$key.'][name]') ? 'has-error' : null ?>">
                                    <input type="text" name="insert[<?= $key ?>][name]" class="form-control form-control-sm" value="<?php echo set_value('insert['.$key.'][name]') ? set_value('insert['.$key.'][name]') : null ?>">
                                    <?php echo (form_error('insert['.$key.'][name]')) ?>
                                </td>
                                
                                <?php if($parent): ?>
                                <td>
                                    <select name="insert[<?= $key ?>][parent_id]" class="form-control form-control-sm">
                                        <option value=""></option>    
                                        <?php foreach ($tiers as $tier): ?>
                                            <option value="<?php echo $tier['id'] ?>">
                                                <?php echo $tier['name'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <?php endif ?>

                                <td class="form-group <?php echo form_error('insert['.$key.'][code]') ? 'has-error' : null ?>">
                                    <input type="text" name="insert[<?php echo $key ?>][code]" class="form-control form-control-sm" value="<?php echo set_value('insert['.$key.'][code]') ?>">
                                    <?php if (form_error('insert['.$key.'][code]')): ?>
                                        <?php echo form_error('insert['.$key.'][code]') ?>
                                    <?php else: ?>
                                        <div class="small text-muted">A Code will be automatically generated if left blank</div>
                                    <?php endif ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" style="width:74px">
                                        <button type="button" class="btn btn-sm btn-primary copy-row">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger remove-row">
                                            <span class="fa fa-minus"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endfor ?>
                        </tbody>
                    </table>
                    
                    <input type="submit" name="add_places" value="submit" class="btn btn-primary">
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
	// Define new create item modal
	var create_modal = $('#modal-addPlace');
	
	// Define datatable
	const table = $('#table').DataTable({
		"processing": true,
		"serverSide": true,
		"rowId": 'id',
		"pageLength": <?php echo $this->app->pageLimit ?>,
		"ajax": "<?php echo site_url('locations/api/places/'.$tierId) ?>",
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
						url: '<?php echo base_url('locations/api/deletePlace') ?>',
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
            
            <?php if($parent): ?>
            { data: "parent" },
            <?php endif ?>

            { data: "code" },
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

	// Delete item from datatable
	$('#table').on('click', '.delete-row', function() {
		var row = $(this).parents('tr');
		// AJAX to delete item
		$.ajax({
			url: '<?php echo base_url('locations/api/deletePlace/') ?>'+row.attr('id'),
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
		'<script type="text/javascript" src="'.base_url('assets/js/table-actions.js').'"></script>'
	]
]) ?>