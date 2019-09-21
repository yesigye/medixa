<ul class="nav nav-tabs mb-3">
	<li class="nav-item">
		<a class="nav-link <?php if($active == 'details') echo 'active' ?>" href="<?php echo site_url('admin/users/edit_group/'.$group_id) ?>">
			<?= lang('menu_details') ?>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link <?php if($active == 'users') echo 'active' ?>" href="<?php echo site_url('admin/users/group_users/'.$group_id) ?>">
			<?= lang('menu_group_users') ?>
		</a>
	</li>
</ul>