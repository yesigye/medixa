<?php $this->load->view('admin/header', array(
	'title' => 'User Permissions',
	'pageTitle' => 'User',
	'pageSubTitle' => $username,
	'link' => 'users',
	'breadcrumb' => array(
		0 => array('name'=>'Users', 'link'=> 'admin/users'),
		1 => array('name'=> $username, 'link'=> 'admin/users/groups'),
		2 => array('name'=>'permissions', 'link'=> false),
	),
)); ?>

<div class="card border-0 shade">

    <?php $this->load->view('users/admin/sub_header', ['active' => 'perms']) ?>
    
    <div class="card-body">
        <h5 class="text-muted mb-3">
            Permissions for
            <a href="<?= site_url('admin/users/edit/'.$user_id) ?>"><?= $username ?></a>
        </h5>

        <?php echo form_open(current_url()); ?>
            <table class="table table-striped table-borderless">
                <thead class="thead-dark">
                    <tr>
                        <th>Permission</th>
                        <th class="text-center">Allow</th>
                        <th class="text-center">Deny</th>
                        <th class="text-center">Inherited From Group</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($permissions) : ?>
                    <?php foreach($permissions as $k => $v) : ?>
                    <tr>
                        <td><?php echo $v['name']; ?></td>
                        <td class="text-center"><?php echo form_radio("perm_{$v['id']}", '1', set_radio("perm_{$v['id']}", '1', $this->ion_auth_acl->is_allowed($v['key'], $users_permissions))); ?></td>
                        <td class="text-center"><?php echo form_radio("perm_{$v['id']}", '0', set_radio("perm_{$v['id']}", '0', $this->ion_auth_acl->is_denied($v['key'], $users_permissions))) ?></td>
                        <td class="text-center">
                            <?php echo form_radio("perm_{$v['id']}", 'X', set_radio("perm_{$v['id']}", 'X', ( $this->ion_auth_acl->is_inherited($v['key'], $users_permissions) || ! array_key_exists($v['key'], $users_permissions)) ? TRUE : FALSE)); ?>
                            <div class="text-muted">
                                <?php if($this->ion_auth_acl->is_inherited($v['key'], $group_permissions, 'value')): ?>
                                    <div class="text-success">Inherited Allow</div>
                                <?php else:  ?>
                                    <div class="text-danger">Inherited Deny</div>
                                <?php endif  ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">There are currently no permissions to manage, please add some permissions</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <button type="submit" name="save" value="save" class="btn btn-success mt-4">
                Update
            </button>
        <?php echo form_close(); ?>
    </div>
</div>

<?php $this->load->view('admin/footer') ?>