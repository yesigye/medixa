<?php $this->load->view('public/templates/header', array(
	'title' => 'Forgot Password',
  'link' => 'account',
)); ?>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-lg-5 m-auto">
            <?php echo form_open(current_url()); ?>
            <div class="card card-body my-5 text-center">
                <h5 class="text-muted mt-3 mb-4">
                    Recover your Password
                </h5>
                <p class="card-text">
                    Enter your email address and an email with instructions will be sent to you.
                </p>
                <?php $this->load->view('alert') ?>
                <div class="form-group">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text text-muted"><i class="fa fa-envelope"></i></div>
                        </div>
                        <input type="text" class="form-control form-control-lg" name="identity" value="<?php echo set_value('identity') ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg btn-block btn-primary">
                        <small>Recover Password</small>
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