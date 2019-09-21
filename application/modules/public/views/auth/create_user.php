<?php $this->load->view('public/header.php', array('link' => 'Login')) ?>
        <div class="panel panel-inverse m-t-md text-center">
          <div class="panel-heading bg-inverse p-a-md">
            <?php echo $app_name ?>
          </div>
          <div class="panel-body">
            <h3><?php echo lang('create_user_subheading') ?></h3>
            <hr/>

            <?php if ($message): ?>
                <div class="alert alert-danger animated fadeInDown" id="message">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php echo $message; ?>
                </div>
            <?php endif ?>
            
            <?php echo form_open_multipart('auth/create_user'); ?>
              <div class="row">
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="first_name" style="display:none"></label>
                          <input class="form-control" type="text" name="first_name" placeholder="<?php echo lang('create_user_fname_label') ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="first_name" style="display:none"></label>
                          <input class="form-control" type="text" name="last_name" placeholder="<?php echo lang('create_user_lname_label') ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="name" style="display:none"></label>
                          <input class="form-control" type="text" name="name" placeholder="<?php echo lang('create_user_company_label') ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="username" style="display:none"></label>
                          <input class="form-control" type="text" name="username" placeholder="<?php echo lang('create_user_identity_label') ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="password1" style="display:none"></label>
                          <input class="form-control" type="password" name="password" placeholder="<?php echo lang('create_user_password_label') ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="password_confirm" style="display:none"></label>
                          <input class="form-control" type="password" name="password_confirm" placeholder="<?php echo lang('create_user_password_confirm_label') ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="form-group">
                          <label for="location" style="display:none"></label>
                          <input class="form-control" type="text" name="location" placeholder="Address"/>
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="form-group">
                          <label for="email" style="display:none"></label>
                          <input class="form-control" type="email" name="email" placeholder="<?php echo lang('create_user_email_label') ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="form-group">
                          <label for="phone" style="display:none"></label>
                          <input class="form-control" type="phone" name="phone" placeholder="<?php echo lang('create_user_phone_label') ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-picture"></span>
                      </span>
                      <input type="file" name="userfile" class="form-control" id="userfile">
                    </div>
                  </div>
              </div>
              <hr/>

              <input type="submit" class="btn btn-lg btn-block btn-primary" name="create_user" value="<?php echo lang('create_user_submit_btn') ?>" />
            <?php echo form_close();?>
          </div>
        </div>
        <div class="text-right" style="color: #000; margin:2rem 0">
          <small class="m-l">COPYRIGHT &copy <?php echo date('Y') ?> <?php echo $app_name ?></small>
        </div>
      </div>
    </div>
  </div><!-- /.container -->

  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

  <script type="text/javascript">
    $(function() 
    {
        // Remove No JS Class
        $('html').removeClass('no-js');
        
        // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //
        
        // Fade out status messages, but ensure error messages stay visable.
        if ($('.status_msg').length > 0)
        {
          $('#message').delay(4000).fadeTo(1000,0.01).slideUp(500);
        }

        // Style error and status messages
        $('p.error_msg').closest('.alert').addClass('alert-danger');
        $('p.status_msg').closest('.alert').addClass('alert-success');
        
        // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //

      });
  </script>
  </body>
  </html>