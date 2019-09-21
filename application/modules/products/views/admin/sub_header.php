<ul class="nav nav-tabs mb-3">
	<li class="nav-item">
		<a class="nav-link <?php if($active == 'details') echo 'active' ?>" href="<?php echo site_url('admin/users/edit/'.$user_id) ?>">
			<?php echo lang('menu_user_profile') ?>
		</a>
	</li>

	<?php if($this->ion_auth->in_group('doctors', $user_id)): ?>
	<li class="nav-item">
		<a class="nav-link <?php if($active == 'prof') echo 'active' ?>" href="<?php echo site_url('admin/users/user_profession/'.$user_id) ?>">
			<?php echo lang('menu_user_profession') ?>
		</a>
	</li>
	<?php endif ?>
</ul>