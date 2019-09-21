<?php $this->load->view('public/templates/header', array(
	'title' => 'Forgot Password',
  'link' => 'account',
)); ?>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-lg-5 m-auto">
            <div class="card card-body my-5 text-center">
                <h5 class="text-muted mt-3 mb-4">
                    Recover your Password
                </h5>

                <?php $this->load->view('alert') ?>
                
                <p class="card-text">
                    An email with instructions has been sent to you (<strong><?= $email ?></strong>),
                    Follow the instructions in that email to continue.
                </p>
                <a href="<?php echo current_url() ?>" class="btn btn-lg btn-block btn-outline-secondary">
                    <small>Resend email</small>
                </a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('public/templates/footer') ?>