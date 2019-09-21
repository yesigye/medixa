<?php $this->load->view('public/templates/header', array(
	'title' => 'Login',
    'link' => 'account',
)); ?>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-lg-5 m-auto">
			<?php echo form_open(current_url(), 'class="text-left"'); ?>
				<div class="card card-body shade my-5">

					<h5 class="text-muted mt-3 mb-4">
						Login with your email address and password
					</h5>

					<?php $this->load->view('alert') ?>

					<div class="form-group">
						<label for="username" style="display:none">Username</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<div class="input-group-text text-muted"><i class="fa fa-user"></i></div>
							</div>
							<input type="text" name="username"
							class="form-control form-control-lg <?= form_error('username') ? 'is-invalid' : '' ?>"
							value="<?php echo set_value('username') ?>" placeholder="email address" />
							<div class="invalid-feedback">
								<?= form_error('username') ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="password" style="display:none">Password</label>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<div class="input-group-text text-muted"><i class="fa fa-lock"></i></div>
							</div>
							<input type="password" name="password"
							class="form-control form-control-lg <?= form_error('password') ? 'is-invalid' : '' ?>"
							value="<?php echo set_value('password') ?>" placeholder="password" />
							<div class="invalid-feedback">
								<?= form_error('password') ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<div class="checkbox">
									<label for="remember">
										<input type="checkbox" name="remember">
										Remember Me
									</label>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="checkbox text-right">
									<a href="<?php echo site_url('forgot-password') ?>">Forgotten Password?</a>
								</div>
							</div>
						</div>
					</div>

					<button type="submit" name="login_user" value="Login" class="btn btn-lg btn-block btn-primary">
						<small>Login</small>
					</button>

					<a href="<?= site_url('register') ?>" class="btn btn-lg btn-block btn-outline-secondary">
						<small>I Don't Have an Account</small>
					</a>
					
				</div>
			<?php echo form_close() ?>
		</div>
	</div>
</div>

<?php $this->load->view('public/templates/footer') ?>