<?php $this->load->view('admin/header', array(
	'title' => 'User Profile',
	'pageTitle' => $username,
	'link' => 'profile',
	'breadcrumb' => array(
		2 => array('name'=> lang('menu_user_profile'), 'link'=> false),
	),
)); ?>

<div class="row mt-3">
    <div class="col-md-3">
        <?php $this->load->view('settings_menu', ['active' => 'profile']) ?>
    </div>
    <div class="col-md-9">
		<h5 class="text-muted mb-4">
			<?php echo lang('subtitle_update_user') ?>
		</h5>

		<?php echo form_open_multipart(current_url()); ?>

			<?php $this->load->view('form_fields', ['fields' => $form_fields]); ?>

			<button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#confirm-modal">
				<?php echo lang('btn_update') ?>
			</button>

			<div class="modal fade" id="confirm-modal" data-backdrop="static" data-keyboard="false">
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
								<?php echo lang('alert_enter_old_password') ?>
							</p>
							
							<div class="form-group">
								<input type="password" class="form-control <?= form_error('old_password') ? 'is-invalid' : '' ?>" name="old_password" value="<?= set_value('old_password') ?>" required/>
								<?php if (form_error('old_password')): ?>
									<div class="invalid-feedback"><?php echo form_error('old_password') ?></div>
								<?php endif ?>
							</div>

							<button type="submit" name="update" value="save" class="btn btn-primary btn-block">
								<?php echo lang('btn_confirm') ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<?php $this->load->view('admin/footer') ?>