<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->app->name ?> Dashboard</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') ?>" />
</head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-5 col-xl-4 center-block" style="margin:auto;float:initial;margin-top:2.5%">
                    <?php echo form_open(current_url(), 'class="needs-validation"'); ?>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-3 col-md-2">
                                        <img alt="Brand" src="<?= base_url($this->app->logo) ?>" alt="" style="width:50px">
                                    </div>
                                    <div class="col-sm-9 col-md-10">
                                        <strong><?php echo $this->app->name ?> </strong>
                                        <p class="text-muted"><?php echo lang('dash_login_title') ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Alerts -->
                            <?php if ($error_message): ?>
                                <p class="bg-danger text-white py-1 px-3">
                                    <?php echo $error_message ?>
                                </p>
                            <?php elseif ($redirect): ?>
                                <p class="bg-warning py-1 px-3">
                                    <?php echo lang('alert_login_required') ?>
                                </p>
                            <?php endif ?>
                            <?php $this->load->view('alert') ?>
                            <!-- End of alerts -->
                                
                            <div class="card-body">
                                    <div class="form-group row">
                                    <label for="username" class="col-3 pr-0 pt-1"><?php echo lang('form_email') ?></label>
                                    <div class="col-9">
                                        <input
                                            type="email"
                                            class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>"
                                            name="username"
                                            value="<?= set_value('username') ?>"
                                            required>
                                        <?php if (form_error('username')): ?>
                                        <div class="invalid-feedback"><?php echo form_error('username') ?></div>
                                        <?php else: ?>
                                        <div class="invalid-feedback">
                                            <div data-rule="valueMissing" class="d-none">
                                                <?php echo $this->lang->line('form_error_value_missing', lang('form_email')) ?>
                                            </div>
                                            <div data-rule="typeMismatch" class="d-none">
                                                <?php echo $this->lang->line('form_error_type_mismatch', lang('form_email')) ?>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-3 pr-0 pt-1"><?php echo lang('form_password') ?></label>
                                    <div class="col-9">
                                        <input
                                            type="password"
                                            class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>"
                                            name="password"
                                            value="<?= set_value('password') ?>"
                                            required>
                                        <?php if (form_error('password')): ?>
                                        <div class="invalid-feedback"><?php echo form_error('password') ?></div>
                                        <?php else: ?>
                                        <div class="invalid-feedback">
                                            <div data-rule="valueMissing" class="d-none">
                                                <?php echo $this->lang->line('form_error_value_missing', lang('form_password')) ?>
                                            </div>
                                        </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group <?php echo form_error('remember') ? 'has-error' : '' ?>">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember" <?= set_value('remember') ? 'checked="checked"' : '' ?>>
                                        <label class="custom-control-label" for="customCheck1"><?php echo lang('form_remember_me') ?></label>
                                    </div>
                                </div> 

                                <button type="submit" name="login" value="1" class="btn btn-lg btn-block btn-primary">
                                <?php echo lang('btn_login') ?>
                                </button>
                            </div>
                        <?php echo form_close() ?>
                    </div>
                    <div class="my-5 text-center text-muted">
                        <?php echo '&copy '.date('Y').' '.$this->app->name ?>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</html>