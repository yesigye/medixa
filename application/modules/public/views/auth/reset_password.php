<?php $this->load->view('public/templates/header', array(
	'title' => 'Reset Password',
  'link' => 'account',
)); ?>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-lg-5 m-auto">
            <?php echo form_open(current_url()); ?>
            <div class="card card-body my-5 text-center">
                <h5 class="text-muted mt-3 mb-4">
                    Reset your Password
                </h5>
                <?php $message ? $message : $this->load->view('alert') ?>
                
				<?php $this->load->view('form_fields', ['fields' => $form_fields, 'cols' => 'col-sm-12']) ?>

				
                <div class="form-group">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg btn-block btn-primary">
                        <small>Reset Password</small>
                    </button>

                    <a href="<?= site_url('login') ?>" value="Sign In" class="btn btn-lg btn-block btn-outline-secondary"/>
                        <small>I know my Password</small>
                    </a>
                </div>
			</div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<?php $this->load->view('public/templates/footer') ?>