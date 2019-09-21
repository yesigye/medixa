<div class="row">
	<h5 class="col-md-9 my-4">
		<?= ($active == 'details') ? 'Edit your profile' : 'Edit your medical information' ?>
	</h5>
	<div class="col-md-3 text-right">
		<a class="btn btn-outline-secondary my-4" data-toggle="modal" href="#modal-changePass">Change Password</a>
	</div>
</div>

<?php $this->load->view('templates/alerts') ?>

<ul class="nav nav-tabs">
	<li class="nav-item">
		<a class="nav-link <?= ($active == 'details') ? 'active' : '' ?>" href="<?php echo site_url('profile') ?>">
			Profile
		</a>
	</li>

	<?php if($this->ion_auth->in_group('doctors')): ?>
	<li class="nav-item">
		<a class="nav-link <?= ($active == 'prof') ? 'active' : '' ?>" href="<?php echo site_url('profile/medical') ?>">
			Profession
		</a>
	</li>
	<?php endif ?>
</ul>

<?php echo form_open(site_url('change_password')) ?>
<div class="modal fade" id="modal-changePass" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content border-0">
			<div class="modal-header bg-secondary text-white">
				<i class="fa fa-lock mr-3	"></i> Change Password
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php if (validation_errors() && $this->input->post('passChange')): ?>
				<div class="alert alert-danger" data-trigger-modal="#modal-changePass">
					This form has errors. Correct them and try again.
				</div>
				<?php endif ?>
				
				<div class="form-group">
					<input type="password" name="password" placeholder="Current password"
					class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>"
					value="<?php echo set_value('password') ?>" placeholder="password" />
					<div class="invalid-feedback"><?= form_error('password') ?></div>
				</div>
				<div class="form-group">
					<input type="password" name="new_password" placeholder="New password"
					class="form-control <?= form_error('new_password') ? 'is-invalid' : '' ?>"
					value="<?php echo set_value('new_password') ?>" placeholder="New password" />
					<div class="invalid-feedback"><?= form_error('new_password') ?></div>
				</div>
			</div>
			<div class="modal-footer border-0 pt-0">
				<button type="submit" name="passChange" value="submit" class="btn btn-primary">
					<small>CHANGE</small>
				</button>
			</div>
		</div>
	</div>
</div>
<?php echo form_close() ?>