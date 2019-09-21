<?php $this->load->view('admin/header', array(
	'title' => 'Groups',
	'pageTitle' => 'Group',
	'pageSubTitle' => $group_name,
	'link' => 'groups',
	'breadcrumb' => array(
		0 => array('name'=>'Users', 'link'=> 'admin/users'),
		1 => array('name'=>'Groups', 'link'=> 'admin/users/groups'),
		2 => array('name'=>'Permissions', 'link'=> false),
	),
)); ?>


<div class="card border-0 shade">
	
	<?php $this->load->view('/sub_header', ['active' => 'perms']) ?>
	
	<div class="card-body">
        <?php if(empty($permissions)): ?>
        <div class="text-muted mb-4">
            You have not defined any permissions yet.
            <a href="<?= site_url('admin/users/permissions') ?>">Define permissions</a>
        </div>
        <?php else: ?>
            <h5 class="text-muted mb-4">
                Permissions for "<?= $group_name ?>"
                <p class="small mt-2">
                    Permissions set to "Ignore" will not apply to this group
                </p>
            </h5>
            <?= form_open(current_url()) ?>
                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Key</th>
                                <th>Name</th>
                                <th class="text-center">Allow</th>
                                <th class="text-center">Deny</th>
                                <th class="text-center">Ignore</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($permissions as $v): ?>
                                <tr>
                                    <td class="">
                                        <?= $v['key'] ?>
                                    </td>
                                    <td>
                                        <?= $v['name'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?= form_radio("perm_{$v['id']}", '1', set_radio("perm_{$v['id']}", '1', ( array_key_exists($v['key'], $groupPermissions) && $groupPermissions[$v['key']]['value'] === TRUE ) ? TRUE : FALSE)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= form_radio("perm_{$v['id']}", '0', set_radio("perm_{$v['id']}", '0', ( array_key_exists($v['key'], $groupPermissions) && $groupPermissions[$v['key']]['value'] != TRUE ) ? TRUE : FALSE)); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= form_radio("perm_{$v['id']}", 'X', set_radio("perm_{$v['id']}", 'X', ( ! array_key_exists($v['key'], $groupPermissions) ) ? TRUE : FALSE)); ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" name="updatePerms" value="submit" class="btn btn-success">
                    Update Permission
                </button>
            <?= form_close() ?>
        <?php endif ?>
    </div>
</div>

<?php $this->load->view('admin/footer') ?>