<?php $this->load->view('public/templates/header') ?>

<?php $this->load->view('alert') ?>

<section class="py-5 bg-light">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<h1>Access healthcare anywhere, anytime</h1>
				<p class="mt-3 mb-5">
					Find a profession physician or a hospital that will cater to your needs.
				</p>
				<a href="<?php echo base_url('register') ?>" class="btn btn-lg btn-outline-secondary text-left my-3">
					<small>Create an account</small>
				</a>
			</div>
			<div class="col-md-4">	
				<img src="<?= base_url('assets/images/appointment.svg') ?>" alt="" class="img-fluid">
			</div>
		</div>
	</div>
</section>

<section class="container bg-white py-4" id="how-it-works">
	<h2 class="my-5 h1 font-weight-light">How does it all work?</h2>
	<div class="row">
		<div class="col-md-6 mt-3">
			<h4 class="lead my-3"> <span class="badge badge-pill badge-secondary mr-2 py-2 px-3">1</span> Find a doctor</h4>
			<p>
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, at consectetur recusandae voluptas nobis ab amet molestias harum quasi labore delectus ex commodi eligendi aspernatur rem. Nesciunt expedita vel dicta!
			</p>
			<div class="h3">
				<i class="fa fa-file-alt mr-2 text-info"></i>
				<i class="fa fa-user-md mr-2 text-danger"></i>
				<i class="fa fa-hospital text-muted"></i>
			</div>
		</div>
		<div class="col-md-6">
			<img src="<?= base_url('assets/images/doc.svg') ?>" alt="" class="img-fluid">
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 order-md-2">
			<img src="<?= base_url('assets/images/appointment.svg') ?>" alt="" class="img-fluid">
		</div>
		<div class="col-md-6 mt-3 order-md-2">
			<h4 class="lead my-4"> <span class="badge badge-pill badge-secondary mr-2 py-2 px-3">2</span> Request an appointment</h4>
			<p>
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, at consectetur recusandae voluptas nobis ab amet molestias harum quasi labore delectus ex commodi eligendi aspernatur rem. Nesciunt expedita vel dicta!
			</p>
			<div class="h3">
				<i class="fa fa-file-alt mr-2 text-info"></i>
				<i class="fa fa-user-md mr-2 text-danger"></i>
				<i class="fa fa-hospital text-muted"></i>
			</div>
		</div>
	</div>
	<!-- Feature is coming soon
	<div class="row">
		<div class="col-md-6 mt-3">
			<h4 class="lead my-4"> <span class="badge badge-pill badge-secondary mr-2 py-2 px-3">3</span> Online Consultation</h4>
			<p>
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, at consectetur recusandae voluptas nobis ab amet molestias harum quasi labore delectus ex commodi eligendi aspernatur rem. Nesciunt expedita vel dicta!
			</p>
			<div class="h3">
				<i class="fa fa-file-alt mr-2 text-info"></i>
				<i class="fa fa-user-md mr-2 text-danger"></i>
				<i class="fa fa-hospital text-muted"></i>
			</div>
		</div>
		<div class="col-md-6">
			<img src="<?= base_url('assets/images/video-chat.svg') ?>" alt="" class="img-fluid">
		</div>
	</div>
	!-->
	<div class="row">
		<div class="col-md-6 order-md-2">
			<img src="<?= base_url('assets/images/agreement.svg') ?>" alt="" class="img-fluid">
		</div>
		<div class="col-md-6 mt-3 order-md-2">
			<h4 class="lead my-4"> <span class="badge badge-pill badge-secondary mr-2 py-2 px-3">4</span> Feel Better</h4>
			<p>
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, at consectetur recusandae voluptas nobis ab amet molestias harum quasi labore delectus ex commodi eligendi aspernatur rem. Nesciunt expedita vel dicta!
			</p>
			<div class="h3">
				<i class="fa fa-file-alt mr-2 text-info"></i>
				<i class="fa fa-user-md mr-2 text-danger"></i>
				<i class="fa fa-hospital text-muted"></i>
			</div>
		</div>
	</div>
</section>

<section class="mt-3 bg-dark text-white-50 py-5">
	<div class="container">
		<div class="row">
			<div class="col-md-7 m-auto">
				<h2 class="my-3">Register now. Feel Better. Stay informed</h2>
				<p>
					Sign up for an account to get access to online consulting, booking and scheduling,
					stay informed with our newsletters with updates, event information, special offers and more.
				</p>
				<?php echo form_open('register') ?>
					<?php $this->load->view('form_fields', ['fields' => $form_fields, 'cols' => 'col-sm-12']) ?>
					<div class="small text-muted mb-2">
						By clicking below, I agree to the
						<a class="text-white" href="<?= site_url('legal/terms-of-service') ?>">Terms of service</a>
						and
						<a class="text-white" href="<?= site_url('legal/privacy-policy') ?>">Privacy policy</a>.
					</div>
					<div class="form-group text-center mt-3 mt-md-5">
						<button type="submit" name="register" value="1" class="btn btn-lg btn-secondary rounded-0">
							<small>SIGN UP NOW</small>
						</button>
					</div>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</section>

<?php $this->load->view('public/templates/footer') ?>