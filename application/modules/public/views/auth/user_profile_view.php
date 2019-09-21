<?php echo Modules::run('public/templates/header', array(
    'title' => 'Profile',
    'link' => 'account',
    'page' => array(
        'title-img' => true,
        'title' => 'My Profile',
    )
)) ?>

<?php echo form_open_multipart(uri_string()); ?>
<?php echo form_hidden('id', $person->id) ?>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-3">
		<div class="form-group">
			<?= form_hidden('crop_x', '') ?>
			<?= form_hidden('crop_y', '') ?>
			<?= form_hidden('crop_width', '') ?>
			<?= form_hidden('crop_height', '') ?>
			<label class="control-label" for="userfile">Profile Photo</label>
			<div class="panel panel-default">
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail text-warning">
						<img class="img-responsive" src="<?= $person->avatar ?>">
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail">
					</div>
					<div class="btn-group btn-block">
						<div class="btn btn-primary btn-file">
							<span class="fileinput-new">Select image</span>
							<span class="fileinput-exists">Change</span>
							<input type="file" name="userfile">
						</div>
						<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group <?= form_error('first_name') ? 'has-error' : '' ?>">
					<label class="control-label" for="first_name">First Name</label>
					<input class="form-control" type="text" name="first_name" value="<?= set_value('first_name') ? set_value('first_name') : $person->first_name ?>" />
					<div class="text-danger"><?= form_error('first_name') ? form_error('first_name') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group <?= form_error('last_name') ? 'has-error' : '' ?>">
					<label class="control-label" for="last_name">Last Name</label>
					<input class="form-control" type="text" name="last_name" value="<?= set_value('last_name') ? set_value('last_name') : $person->last_name ?>" />
					<div class="text-danger"><?= form_error('last_name') ? form_error('last_name') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('username') ? 'has-error' : '' ?>">
					<label class="control-label" for="username">Username</label>
					<input class="form-control" type="text" name="username" value="<?= set_value('username') ? set_value('username') : $person->username ?>" />
					<div class="text-danger"><?= form_error('username') ? form_error('username') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('password') ? 'has-error' : '' ?>">
					<label class="control-label" for="password">Password</label>
					<input class="form-control" type="password" name="password" value="<?= set_value('password') ?>" />
					<div class="text-danger"><?= form_error('password') ? form_error('password') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('password_confirm') ? 'has-error' : '' ?>">
					<label class="control-label" for="password_confirm">confirm Password</label>
					<input class="form-control" type="password" name="password_confirm" value="<?= set_value('password_confirm') ?>" />
					<div class="text-danger"><?= form_error('password_confirm') ? form_error('password_confirm') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('email') ? 'has-error' : '' ?>">
					<label class="control-label" for="email">Email</label>
					<input class="form-control" type="email" name="email" value="<?= set_value('email') ? set_value('email') : $person->email ?>" />
					<div class="text-danger"><?= form_error('email') ? form_error('email') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('birth') ? 'has-error' : '' ?>">
					<label class="control-label" for="birth">Date of Birth</label>
					<input class="form-control" type="date('y/m/d')" name="birth" value="<?= set_value('birth') ? set_value('birth') : $person->birth_date ?>" />
					<div class="text-danger"><?= form_error('birth') ? form_error('birth') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('address') ? 'has-error' : '' ?>">
					<label class="control-label" for="address">Address</label>
					<input class="form-control" type="text" name="address" value="<?= set_value('address') ? set_value('address') : $person->address ?>" />
					<div class="text-danger"><?= form_error('address') ? form_error('address') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('phone') ? 'has-error' : '' ?>">
					<label class="control-label" for="phone">Phone</label>
					<input class="form-control" type="phone" name="phone" value="<?= set_value('phone') ? set_value('phone') : $person->phone ?>" />
					<div class="text-danger"><?= form_error('phone') ? form_error('phone') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('gender') ? 'has-error' : '' ?>">
					<label class="control-label" for="gender">Gender</label>
					<hr style="margin: 2px 0 3px 0;">
					<input type="radio" name="gender" value="0" style="position:relative;top:2px;" <?= set_radio('gender', '0') ? set_radio('gender', '0') : ( ! $person->gender) ? 'checked' : '' ?> />
					<label>Male</label>
					<input type="radio" name="gender" value="1" style="margin-left:20px;position:relative;top:2px;" <?= set_radio('gender', '1') ? set_radio('gender', '1') : ($person->gender) ? 'checked' : '' ?> />
					<label>Female</label>
					<hr style="margin:0;">
					<div class="text-danger"><?= form_error('gender') ? form_error('gender') : '&nbsp' ?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<input type="submit" class="btn btn-lg btn-block btn-primary" name="edit_user" value="Update Profile" />
<?php echo form_close();?>

<?php echo Modules::run('public/templates/footer') ?>