<?php echo $this->load->view('public/templates/header', array(
	'title' => 'Physicians',
	'link' => 'physicians',
	'pageTitle' => $doctor['first_name'].' '.$doctor['last_name'],
	'pageSubTitle' => $doctor['speciality'],
	'breadcrumb' => [
		0 => array('name'=>'Physicians', 'link'=>'physicians'),
		1 => array('name'=>$doctor['first_name'].' '.$doctor['last_name'], 'link'=>false),
	]
)); ?>

<div class="container">
	<div class="page-title mb-4">
		<?= $doctor['speciality_description'] ?>
	</div>
	<?php if (validation_errors() AND $this->input->post('send_message')): ?>
		<div class="alert alert-danger">
			Errors were detected in the
			<a href="#contact-me">Contant Me</a> form. review this form and try again.
			<script>$('form').focus()</script> 
		</div>
	<?php endif ?>
	<?php echo $this->load->view('alerts') ?>
</div>

<div class="container">
	<div class="row card-group m-0">
		<div class="col-sm-4 col-md-3 card">
			<div class="">
				<div class="row">
					<div class="col-5 col-md-12 p-0 text-center">
						<img src="<?php echo base_url('image/'.$doctor['avatar']) ?>" alt="" class='img-fluid'>
					</div>
					<div class="col-7 col-md-12 p-0">
						<div class="card-body">
							<div class="text-muted">Address</div> <?= $doctor['address'] ?>
						</div>
					</div>
					<div class="col-12 col-md-12 p-0">
						<?php if($user_id !== $doctor['id']): ?>
						<button type="button" class="btn btn-block btn-lg btn-primary rounded-0 m-0" data-toggle="modal" data-target="#modal-bkApt">
							<small class="text-uppercase">Request Appointment</small>
						</button>
						<div class="modal fade" id="modal-bkApt" data-backdrop="static" data-keyboard="false">
							<div class="modal-dialog" role="document">
								<div class="modal-content border-0">
									<div class="modal-header bg-primary text-white">
										<h5 class="modal-title">Book an appointment</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<?php if (!$this->app->user()): ?>
											<div class="text-muted my-4">
												You must be signed in to book appointments.
												<a href="<?= site_url('login') ?>">Sign me in</a>
											</div>
										<?php else: ?>
											<?php if (validation_errors() && $this->input->post('book_appointment')): ?>
											<div class="alert alert-danger" data-trigger-modal="#modal-bkApt">
												This form has errors. Correct them and try again.
											</div>
											<?php endif ?>
											
											<?php echo form_open(current_url()) ?>
											<?php $this->load->view('form_fields', ['fields' => $appointment_form]) ?>
											<button type="submit" name="book_appointment" value="1" class="btn btn-lg btn-block btn-secondary">
												SEND
											</button>
											<?php echo form_close() ?>
										<?php endif ?>
									</div>
								</div>
							</div>
						</div>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-8 col-md-9 card">
			<div class="card-body">
				<h5 class="text-muted mb-3">Profile Description</h5>
				<?php echo $doctor['description'] ?>
				
				<h5 class="text-muted my-4">Qualifications</h5>
				<div class="row">
					<div class="col-12 col-md-3 font-weight-light">Speciality</div>
					<div class="col-12 col-md-9"><?php echo $doctor['speciality'] ?></div>
				</div>
				<div class="row my-3">
					<div class="col-12 col-md-3 font-weight-light">First Qualification</div>
					<div class="col-12 col-md-9"><?php echo $doctor['first_qualification'] ?></div>
				</div>
				<?php if ($doctor['other_qualification']): ?>
				<div class="row my-3">
					<div class="col-12 col-md-3 font-weight-light">Other Qualifications</div>
					<div class="col-12 col-md-9"><?php echo $doctor['other_qualification'] ?></div>
				</div>
				<?php endif ?>
				<div class="row">
					<div class="col-12 col-md-3 font-weight-light">Affiliates</div>
					<div class="col-12 col-md-9">
						<?php if (empty($hospitals)): ?>
							<div class="text-muted">No known affiliates</div>
						<?php else: ?>
							<?php foreach ($hospitals as $key => $hospital): ?>
								<a href="<?php echo site_url('hospitals/'.$hospital['slug']) ?>" class="badge">
									<?php echo $hospital['name'] ?>
								</a>
							<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
				<?php if ($doctor['is_mobile']): ?>
					<div class="text-success mt-4">
						<i class="fa fa-ambulance mr-2"></i>	
						This physician offers mobile services
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
	
	<h5 class="text-muted mt-5 mb-3">Other Physicians</h5>
	<?php $this->load->view('public/templates/doctors_cards', ['doctors' => $doctors]) ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy',
	})
});
</script>

<?php $this->load->view('public/templates/footer') ?>