<?php $this->load->view('admin/header', array(
	'title' => lang('menu_languages'),
	'link' => 'settings',
    'breadcrumb' => array(
        ['name' => lang('menu_settings'), 'link'=> 'hospitals'],
        ['name' => lang('menu_languages'), 'link'=> false],
    ),
    'styles' => array(
        '<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
        '<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
    )
)); ?>

<div class="row">
    <div class="col-md-3">
        <?php $this->load->view('settings_menu', ['active' => 'languages']) ?>
    </div>
    <div class="col-md-9">
        <div class="row mb-3">
            <div class="col-6">
                <div class="btn-group" role="group">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <strong><?php echo $language ?></strong>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php foreach($languages as $row): ?>
                            <a class="dropdown-item <?php if($language === $row['language']) echo 'active' ?>"
                            href="<?php echo site_url('admin/settings/languages/'.$row['language']) ?>"><?php echo $row['language'] ?></a>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <a class="btn btn-primary" data-toggle="modal" href="#modal-edit">Edit</a>
                </div>
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-success" data-toggle="modal" data-target="#modal-create">
                    <?php echo lang('btn_create') ?>
                </button>
                <button class="btn btn-danger" data-toggle="modal" data-target="#modal-confirm">
                    <?php echo lang('btn_delete') ?>
                </button>
            </div>
        </div>
        
        <?php echo form_open() ?>
        <div class="table-responsive">
            <table class="table table-borderless border-top table-striped" id="table">
                <thead>
                    <tr>
                        <th>Key / Collection</th>
                        <th>Text and Translation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($translations as $index => $row): ?>
                    <tr>
                        <td>
                            <?php echo $row['key'] ?>
                            <div><span class="badge badge-warning badge-pill"><?php echo $row['set'] ?></span></div>
                        </td>
                        <td>
                            <?php if($language !== $default_language): ?>
                            <div class="text-muted mb-1"><?php echo $row['text'] ?></div>
                            <?php endif ?>
                            <?php echo form_hidden('rows['.$index.'][set]', $row['set']) ?>
                            <?php echo form_hidden('rows['.$index.'][key]', $row['key']) ?>
                            <?php echo form_hidden('rows['.$index.'][trans_id]', $row['trans_id']) ?>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text py-0 px-1">
                                        <i class="fa fa-language" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <input
                                    type="text"
                                    name="<?php echo 'rows['.$index.'][translation]' ?>"
                                    value="<?php echo $row['translation'] ?>"
                                    class="form-control form-control-sm"
                                    placeholder="<?php echo ($row['translation']) ? '' : $this->lang->line('form_translate_to', $language) ?>"
                                >
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <button type="submit" name="update" value="1" class="btn btn-success mt-3"><?php echo lang('btn_save') ?></button>
        <?php echo form_close() ?>
    </div>
</div>

<?php echo form_open() ?>
	<div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content border-0">
				<div class="modal-header">
					<b><?php echo lang('btn_create') ?></b>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <input
                        type="text"
                        name="language"
                        placeholder="add a new language"
                        class="form-control form-control-sm <?= form_error('language') ? 'is-invalid' : '' ?>"
                        value="<?= set_value('language') ?>"
                        required
                    />
                    <?php if (form_error('language')): ?>
                    <div class="invalid-feedback"><?php echo form_error('language') ?></div>
                    <?php endif ?>
					
                    <button type="submit" name="insert" value="1" class="btn btn-sm btn-block btn-success mt-2">
                        <?php echo lang('btn_submit') ?>
                    </button>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close() ?>

<?php echo form_open() ?>
	<div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content border-0">
				<div class="modal-header">
					<b><?php echo lang('btn_edit') ?></b>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="text" name="name" value="<?php echo $language ?>" class="form-control">
					
					<button type="submit" name="edit_name" value="1" class="btn btn-block btn-primary mt-2">
						<?php echo lang('btn_confirm') ?>
					</button>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close() ?>

<?php echo form_open() ?>
	<div class="modal fade" id="modal-confirm" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			<div class="modal-content border-0">
				<div class="modal-header bg-danger text-white">
					<b><?php echo lang('alert_confirm_action') ?></b>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="text-muted">
						<?php echo lang('alert_confrim_delete_txt') ?>
					</p>
					
					<button type="submit" name="delete" value="<?php echo $language ?>" class="btn btn-block btn-secondary mt-2">
						<?php echo lang('btn_confirm') ?>
					</button>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close() ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
	// Define datatable
	const table = $('#table').DataTable({
		"pageLength": <?php echo $this->app->pageLimit ?>,
    });
});
</script>

<?php $this->load->view('admin/footer', [
	'scripts' => [
		'<script type="text/javascript" src="'.base_url('assets/vendor/datatables/datatables.min.js').'"></script>',
		'<script type="text/javascript" src="'.base_url('assets/vendor/datatables/dataTables.checkboxes.min.js').'"></script>',
	]
]) ?>