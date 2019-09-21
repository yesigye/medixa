<?php if ($person['group_name'] == 'physicians'): ?>
	<div role="tabpanel" class="tab-pane" id="medical">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?php echo form_error('reg_no') ? 'has-error' : '' ?>">
					<label class="control-label" for="reg_no">Medical Council Reg No.</label>
					<input class="form-control" type="text" name="reg_no" value="<?= set_value('reg_no') ? set_value('reg_no') : $profile['reg_no'] ?>">
					<div class="text-danger"><?php echo form_error('reg_no') ? form_error('reg_no') : '' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?php echo form_error('speciality') ? 'has-error' : '' ?>">
					<label class="control-label" for="speciality">Speciality</label>
					<?php $options = array() ?>
					<?php foreach ($specialities as $key => $row): ?>
						<?php $options[$row->id] = $row->name ?>
					<?php endforeach ?>
					<?= form_dropdown('speciality', $options, set_value('speciality') ? set_value('speciality') : $profile['speciality'], 'class="form-control"') ?>
					<div class="text-danger"><?php echo form_error('speciality') ? form_error('speciality') : '' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?php echo form_error('mobile_services') ? 'has-error' : '' ?>">
					<div class="checkbox">
						<label for="mobile_services">
							<input type="checkbox" name="mobile_services" <?= set_checkbox('mobile_services') ? set_checkbox('mobile_services') : (($profile['mobile_services']) ? 'checked' : '') ?> />
							<p>
								<strong>Mobile services</strong>
							</p>
							Offers mobile services to patients?
						</label>
					</div>
					<div class="text-danger"><?php echo form_error('mobile_services') ? form_error('mobile_services') : '' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group <?php echo form_error('description') ? 'has-error' : '' ?>">
					<label class="control-label" for="description" style="margin-bottom:0px">Decription</label>
					<p  style="margin-top:0px" class="help-block">Enter the doctors profile and brief resume</p>
					<textarea class="form-control" name="description" rows="5"><?= set_value('description') ? set_value('description') : $profile['description'] ?></textarea>
					<div class="text-danger"><?php echo form_error('description') ? form_error('description') : '' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group <?php echo form_error('first_qualification') ? 'has-error' : '' ?>">
					<label class="control-label" for="first_qualification">First qualification</label>
					<textarea rows="5" class="form-control" name="first_qualification"><?= set_value('first_qualification') ? set_value('first_qualification') : $profile['first_qualification'] ?></textarea>
					<div class="text-danger"><?php echo form_error('first_qualification') ? form_error('first_qualification') : '' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group <?php echo form_error('other_qualification') ? 'has-error' : '' ?>">
				<label class="control-label" for="other_qualification">Other qualification(s)</label>
					<textarea rows="5" class="form-control" name="other_qualification"><?= set_value('other_qualification') ? set_value('other_qualification') : $profile['other_qualification'] ?></textarea>
					<div class="text-danger"><?php echo form_error('other_qualification') ? form_error('other_qualification') : '' ?></div>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>