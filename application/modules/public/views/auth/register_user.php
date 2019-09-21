
<?php $this->load->view('public/templates/header', array(
	'title' => 'Register',
    'link' => 'register',
)); ?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="media my-5">
				<img src="<?= base_url('assets/images/appointment.svg') ?>" class="align-self-center mr-3" style="width:135px">
				<div class="media-body">
					<h4 class="media-heading">Book appointments</h4>
					Creating an account will give you access to the booking system. <br>
					Your appointment will automatically be added to the physician's calendar and he/she will be notified immediately by email.
				</div>
			</div>
			<div class="media my-5">
				<div class="media-body">
					<h4 class="media-heading">Hospitals</h4>
					Browse our vast directory of healthcare centers and doctors. <br>
					A varied list of hospitals from everywhere that provide different facilities and services.
				</div>
				<img src="<?= base_url('assets/images/workers.svg') ?>" class="align-self-center ml-3" style="width:135px">
			</div>
			<div class="media my-5">
				<img src="<?= base_url('assets/images/doc.svg') ?>" class="align-self-center mr-3" style="width:135px">
				<div class="media-body">
					<h4 class="media-heading">Physicians</h4>
					Get anytime access to credible and professional physicians. <br>
					No more waiting in line, You could meet the doctor from the comfort of your own home, contact him/her about your symptoms and have them diagnose or prescribe treatment.
				</div>
			</div>
			<div class="media my-5">
				<div class="media-body">
					<h4 class="media-heading">Stay up-to-date</h4>
					Be the first to know and be informed of new events and changes. <br>
					We shall notify you of any updates through your email address or directly through your account's page.
				</div>
				<img src="<?= base_url('assets/images/notes.svg') ?>" class="align-self-center ml-3" style="width:135px">
			</div>
		</div>
		
		<div class="col-md-4">
			<h4 class="mt-5 mb-3">Sign up for free</h4>
			
			<?php $this->load->view('alert') ?>
			
			<?php echo form_open(current_url()) ?>
				<?php $this->load->view('form_fields', ['fields' => $form_fields, 'cols' => 'col-sm-12']) ?>
				<div class="small text-muted mb-2">
					By clicking below, I agree to the
					<a href="<?= site_url('legal/terms-of-service') ?>">Terms of service</a>
					and
					<a href="<?= site_url('legal/privacy-policy') ?>">Privacy policy</a>.
				</div>
				<div class="form-group">
					<button type="submit" name="register" value="1" class="btn btn-lg btn-block btn-secondary">
						Sign up
					</button>
				</div>
			<?php echo form_close() ?>
			
			<a class="btn btn-lg btn-block btn-outline-primary" href="<?= site_url('register_org') ?>" class="my-4">
				<small>Register a Hospital or Company</small>
			</a>
		</div>
	</div>
</div>

<?php $this->load->view('public/templates/footer') ?>
