<div class="row">
	<?php foreach ($fields as $f_name => $field_data):
		
		// Setting defaults
		$inputLabel = isset($field_data['label']) ? $field_data['label'] : '';
		$f_type  = isset($field_data['type']) ? $field_data['type'] : 'text';
		$f_value = isset($field_data['value']) ? $field_data['value'] : set_value($f_name);
		$inputCol   = isset($field_data['col']) ? $field_data['col'] : 'col-12';
		$inputHelp  = isset($field_data['help-text']) ? $field_data['help-text'] : '';
		$isRequired = isset($field_data['required']) ? $field_data['required'] : false;
		$inputAttr  = ['class' => isset($field_data['class']) ? $field_data['class'] : 'form-control'];
		if (isset($field_data['attr'])) $inputAttr = array_merge($inputAttr, $field_data['attr']);

		
		if ($isRequired) $inputAttr['required'] = 'required ';

		if(isset($field_data['attr'])) $inputAttr = array_merge($inputAttr, $field_data['attr']);
		
		// Adding BS4 error validation class for inputs with errors
		if (form_error($f_name)) {
			// Append error class
			$inputAttr['class'] = (isset($inputAttr['class']) ? $inputAttr['class'] : '').' is-invalid';
		}

		$attr = ''; foreach($inputAttr as $key => $value) { $attr .= ($key.'="'.$value.'"'); }
		?>

		<div class="<?= $inputCol // BS4 Columns for input widths ?>">
			<div class="form-group">

				<?php if($f_type !== 'checkbox') {
				// Input Label
				if ($inputLabel) echo form_label($inputLabel, $f_name, ['class'=>'control-label mb-1']);
				
				// Input Help Text
				echo $inputHelp ? '<small class="form-text text-muted mt-0 mb-1">'.$inputHelp.'</small>' : '';
				} ?>

				<?php
				// Generate different field types
				switch ($f_type) {
					case 'upload':
						// BS4 Custom File Browser
						echo '<div class="custom-file">
							<input type="file" class="custom-file-input" id="customFile">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>';
						break;
					case 'image':
						// Javascript Cropper will write into these fields
						echo form_hidden('crop_x', '');
						echo form_hidden('crop_y', '');
						echo form_hidden('crop_width', '');
						echo form_hidden('crop_height', '');
						?>
						<div class="">
							<div class="fileinput fileinput-new card m-auto" data-provides="fileinput" style="min-width:200px">
								<div class="fileinput-new thumbnail text-center" style="width:100%">
									<?php if ($f_value): ?>
										<img src="<?php echo base_url('image/'.$f_value) ?>">
									<?php else: ?>
										<div class="h1 d-block mx-2 my-4 text-muted"> <i class="fa fa-image"></i> </div>
									<?php endif ?>
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail"></div>
								<div class="card-footer p-0">
									<div class="btn-group btn-block">
										<div class="btn btn-secondary btn-file">
											<span class="fileinput-new"><?php echo lang('btn_select') ?></span>
											<span class="fileinput-exists"> <?php echo lang('btn_edit') ?> </span>
											<input type="file" name="<?= $f_name ?>" <?php if ($isRequired) echo 'required' ?>>
										</div>
										<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><?php echo lang('btn_delete') ?></a>
									</div>
								</div>
							</div>
						</div> 
						
						<?php
						break;
					case 'checkbox':
						$checked = isset($field_data['checked']) ? $field_data['checked'] : [];
						?>
						<div class="custom-control custom-checkbox">
							<?= form_checkbox($f_name, $f_value, $checked,
								['class'=>"custom-control-input", 'id'=>"check_".$f_name])
							?>
							<?php
							// Input Help Text
							$inputLabel .= $inputHelp ? '<small class="form-text text-muted mt-0 mb-1">'.$inputHelp.'</small>' : ' '; 
							// Input Label
							if ($inputLabel) echo form_label($inputLabel, 'check_'.$f_name, ['class'=>'custom-control-label']);
							// Input is required
							if ($isRequired) echo '<span class="text-danger font-weight-bold"> *</span>';
							?>
						</div>
						<?php
					break;
					case 'select':
						if (isset($inputAttr['multiple'])): ?>
						<?php if (form_error($f_name)): ?>
							<div class="invalid-feedback d-block m-0"><?php echo form_error($f_name) ?></div>
						<?php endif ?>
						<div class="card card-body" style="max-height:150px;overflow:auto">
							<?php foreach ($field_data['options'] as $key => $option): ?>
							<div class="pb-1">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="check_<?php echo $f_name.$key ?>"
									name="<?php echo $f_name ?>" value="<?php echo $key ?>"
									<?php echo (in_array($key, $field_data['selected'])) ? 'checked="checked"' : set_checkbox($f_name, $key) ?>
									>
									<label for="check_<?php echo $f_name.$key ?>" class="custom-control-label">
										<?php echo $option ?>
									</label>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						<?php else:
						// Dropdown Select Input
						$selected = isset($field_data['selected']) ? $field_data['selected'] : [];
						echo form_dropdown($f_name, $field_data['options'], $selected, $attr);
						endif;
						
						break;
					case 'hidden':
						echo form_hidden($f_name, $f_value, $inputAttr);
						break;
					case 'password':
						echo form_password($f_name, $f_value, $inputAttr);
						break;
					case 'textarea':
						echo "<textarea rows=\"8\" type=\"$f_type\" name=\"$f_name\" id=\"$f_name\" $attr>$f_value</textarea>";
						break;
					default:
						// Input with type of defined
						echo "<input type=\"$f_type\" name=\"$f_name\" id=\"$f_name\" value=\"$f_value\" $attr>";
						break;
				}
				
				// Validation error feedback
				if (form_error($f_name)) {
					echo '<div class="invalid-feedback">'.form_error($f_name).'</div>';
				}
				?>
			</div>
		</div>
	<?php endforeach ?>
</div>