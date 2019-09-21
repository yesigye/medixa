<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/styles.css" />

  <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 center-block" style="float:initial">
        <div class="panel panel-inverse m-t-md">
          <div class="panel-heading text-center bg-inverse p-a-md">
            <?php echo $app_name ?>
          </div>
          <div class="panel-body">
            <div class="text-center">
              <h4>Edit User</h4>
              <p>Please enter the user's information below.</p>
              <hr/>
            </div>

            <?php if ($message): ?>
              <div class="alert alert-danger animated fadeInDown" id="message">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <?php echo $message; ?>
              </div>
            <?php endif ?>

            <?php echo form_open_multipart(uri_string()); ?>
              <?php echo form_hidden('id', $user->id) ?>
              <?php echo form_hidden($csrf) ?>
              <div class="row">
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <!-- <div class="form-group text-center">
                          <label for="userfile" style="margin:0">Change Avatar</label>
                          <img class="img-thumbnail" src="<?php echo base_url().'assets/images/users/'.$user->avatar ?>">
                      </div> -->
                      <div class="panel panel-default">
                        <div class="panel-heading text-center">
                          <label for="userfile">Change Avatar:</label>
                        </div>
                        <div class="panel-body">
                          <img class="img-responsive" src="<?php echo base_url().'assets/images/users/'.$user->avatar ?>">
                        </div>
                        <div class="panel-footer">
                          <input type="file" name="userfile" class="form-control" id="userfile">
                        </div>
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="username">UserName:</label>
                          <input class="form-control" type="text" name="username" value="<?php echo $user->username ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="first_name">First Name:</label>
                          <input class="form-control" type="text" name="first_name" value="<?php echo $user->first_name ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="last_name">Last Name:</label>
                          <input class="form-control" type="text" name="last_name" value="<?php echo $user->last_name ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="company">Company:</label>
                          <input class="form-control" type="text" name="company" value="<?php echo $user->company ?>" />
                          <p class="help-block">&nbsp</p>
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="password">Password:</label>
                          <input class="form-control" type="password" name="password" />
                          <p class="help-block">Only if you are changing password.</p>
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-4 col-md-6">
                      <div class="form-group">
                          <label for="password_confirm">Confirm Password:</label>
                          <input class="form-control" type="password" name="password_confirm" />
                          <p class="help-block">Only if you are changing password.</p>
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="form-group">
                          <label for="address">Address:</label>
                          <input class="form-control" type="text" name="address" value="<?php echo $user->address ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="form-group">
                          <label for="email">Email</label>
                          <input class="form-control" type="email" name="email" value="<?php echo $user->email ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                      <div class="form-group">
                          <label for="phone">Phone</label>
                          <input class="form-control" type="phone" name="phone" value="<?php echo $user->phone ?>" />
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <?php if ($this->ion_auth->is_admin()): ?>
                      <h4>User Group</h4>
                      <div class="form-inline">
                        <?php foreach ($groups as $group):?>
                          <?php
                              $gID=$group['id'];
                              $checked = null;
                              $item = null;
                              foreach($currentGroups as $grp) {
                                  if ($gID == $grp->id) {
                                      $checked= ' checked="checked"';
                                  break;
                                  }
                              }
                          ?>
                          <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                          <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                        <?php endforeach?>
                      </div>
                    <?php endif ?>
                  </div>
              </div>
              <hr/>

              <input type="submit" class="btn btn-lg btn-block btn-primary" name="edit_user" value="Submit" />
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



<h1><?php echo lang('edit_user_heading');?></h1>
<p><?php echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>

      <p>
            <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </p>

      <p>
            <?php echo lang('edit_user_company_label', 'company');?> <br />
            <?php echo form_input($company);?>
      </p>

      <p>
            <?php echo lang('edit_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone);?>
      </p>

      <p>
            <?php echo lang('edit_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
            <?php echo form_input($password_confirm);?>
      </p>

      <?php if ($this->ion_auth->is_admin()): ?>

          <h3><?php echo lang('edit_user_groups_heading');?></h3>
          <?php foreach ($groups as $group):?>
              <label class="checkbox">
              <?php
                  $gID=$group['id'];
                  $checked = null;
                  $item = null;
                  foreach($currentGroups as $grp) {
                      if ($gID == $grp->id) {
                          $checked= ' checked="checked"';
                      break;
                      }
                  }
              ?>
              <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
              <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
              </label>
          <?php endforeach?>

      <?php endif ?>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <p><?php echo form_submit('submit', lang('edit_user_submit_btn'));?></p>

<?php echo form_close();?>
