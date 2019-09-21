<?php $this->load->view('admin/header', array(
	'title' => 'Permissions',
	'pageTitle' => 'Permissions',
	'link' => 'perms',
	'breadcrumb' => array(
        0 => array('name'=>'Permissions', 'link'=>FALSE),
    )
)); ?>

<div class="card">
    <div class="card-body">
        <?php if(empty($permissions)): ?>
            <div class="my-4 text-muted">
                No permissions have been defined.
                <a href="#" data-toggle="modal" data-target="#modal-perm">Create</a>
            </div>
        <?php else: ?>
            <?= form_open(current_url()) ?>
                <table class="table table-striped table-borderless table-checkable">
                    <thead class="table-actions">
                        <tr>
                            <td colspan="2">
                                <strong class="checked-num">0</strong> selected
                                <button type="submit" name="delete_selected" value="1" class="btn btn-sm btn-danger">delete</button>
                            </td>
                            <td class="text-right">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-perm">Create</button>
                            </td>
                        </tr>
                    </thead>
                    <thead class="thead-dark">
                        <tr>
                            <th>Key</th>
                            <th>Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($permissions as $permission) : ?>
                        <tr class="check">
                            <td>
                                <div class="d-none">
                                    <?= form_checkbox('selected[]', $permission['id']) ?>
                                </div>
                                <?php echo $permission['key']; ?>
                            </td>
                            <td><?php echo $permission['name']; ?></td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-info" href="/admin/update-permission/<?php echo $permission['id']; ?>">Edit</a>
                                <a class="btn btn-sm btn-danger" href="<?= site_url('admin/users/deletePerm/'.$permission['id']); ?>">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?= form_close() ?>
        <?php endif ?>
    </div>
</div>

<?= form_open(current_url()) ?>
<div class="modal fade" id="modal-perm">
	<div class="modal-dialog">
		<div class="modal-content border-0">
			<div class="modal-header">
				<h5 class="modal-title text-uppercase">Add Permission</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body table-responsive">
                <?php if(validation_errors() && $this->input->post('addPerm')): ?>
                    <div class="alert alert-danger alert-dismissable" data-trigger-modal="#modal-perm">
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
                                <input type="text" name="insert[<?= $key ?>][permKey]"
                                class="form-control form-control-sm <?php echo form_error('insert['.$key.'][permKey]') ? 'is-invalid' : null ?>"
                                value="<?php echo set_value('insert['.$key.'][permKey]') ? set_value('insert['.$key.'][permKey]') : null ?>">
                                <div class="small text-danger">
                                    <?php echo (form_error('insert['.$key.'][permKey]')) ?>
                                </div>
                            </td>
                            <td>
                                <input 
                                    type="text" name="insert[<?= $key ?>][permName]"
                                    class="form-control form-control-sm <?php echo form_error('insert['.$key.'][permName]') ? 'is-invalid' : null ?>"
                                    value="<?php echo set_value('insert['.$key.'][permName]') ? set_value('insert['.$key.'][permName]') : null ?>">
                                <div class="small text-danger">
                                    <?php echo (form_error('insert['.$key.'][permName]')) ?>
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
                <button type="submit" name="addPerm" value="1" class="btn btn-sm btn-primary">Create</button>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>

<?php $this->load->view('admin/footer', array(
	'scripts' => array(
        '<script type="text/javascript" src="'.base_url('assets/js/table-actions.js').'"></script>',
    )
)) ?>