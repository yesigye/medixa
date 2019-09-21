<?php echo modules::run('templates/header', array(
	'title' => 'Insert Banner',
	'link' => 'extras',
	'sub_link' => 'banners',
	'breadcrumbs' => array(
		0 => array('name'=>'Banners', 'link'=>'banners'),
		1 => array('name'=>'Insert a new banner', 'link'=>FALSE)
	)
)); ?>

<div class="page-header">
	<h4 class="lead">
		<span class="fa fa-image" style="margin-right:10px"></span> Insert a new banner
	</h4>
	<p>
		Banners are visual adverts or promotions that are displayed at the home page of the store-front.
		Banners can either be images or html text which always overides images.
		Banners can be setup to run at and expire after defined dates.
	</p>
</div>

<?php if (validation_errors()): ?>
	<div class="alert alert-danger">
		Correct the errors in the form and try again
	</div>
<?php else: ?>
	<?php if (! empty($message)): ?>
		<div id="message"> <?=$message ?> </div>
	<?php endif ?>
<?php endif ?>

<?php echo form_open_multipart(current_url()) ?>
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-12">
					<div class="form-group <?php echo form_error('title') ? 'has-error' : '' ?>">
						<label for="title" class="control-label">Title</label>
						<input class="form-control" type="text" name="title" value="<?php echo set_value('title') ? set_value('title') : '' ?>" />
						<div class="text-danger"><?php echo form_error('title') ?></div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-12">
					<div class="form-group">
						<label for="url" class="control-label">Url link</label>
						<input class="form-control" type="text" name="url" value="<?php echo set_value('url') ? set_value('url') : '' ?>" />
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-6">
					<div class="form-group <?php echo form_error('start_date') ? 'has-error' : '' ?>">
						<label for="start_date" class="control-label">Start date</label>
						<input type="text" class="form-control" name="start_date" value="<?php echo (set_value('start_date')) ? set_value('start_date') : '' ?>" />
						<div class="text-danger"><?php echo form_error('start_date') ?></div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-6">
					<div class="form-group <?php echo form_error('end_date') ? 'has-error' : '' ?>">
						<label for="end_date" class="control-label">End date</label>
						<input type="text" class="form-control" name="end_date" value="<?php echo (set_value('end_date')) ? set_value('end_date') : '' ?>" />
						<div class="text-danger"><?php echo form_error('end_date') ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default panel-inverse">
				<div class="panel-heading">
					<div class="panel-title">Banner Type</div>
				</div>
				<div class="panel-body">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#banner-image" aria-controls="banner-image" role="tab" data-toggle="tab">
								Image
							</a>
						</li>
						<li role="presentation">
							<a href="#banner-html" aria-controls="banner-html" role="tab" data-toggle="tab">
								HTML Text
							</a>
						</li>
					</ul>

					<div class="tab-content" style="padding-top:2rem">
						<div role="tabpanel" class="tab-pane active" id="banner-image">
							<p class="help-block form-group">
								Select and upload an image from your computer.
							</p>
							<div class="panel <?php echo form_error('userfile') ? 'panel-danger' : 'panel-default' ?>">
								<?= form_hidden('crop_x', '') ?>
								<?= form_hidden('crop_y', '') ?>
								<?= form_hidden('crop_width', '') ?>
								<?= form_hidden('crop_height', '') ?>
								<div class="fileinput fileinput-item-thumb fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail text-warning">
										<div style="margin:3rem 0">No image selected</div>
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail">
									</div>
									<div class="btn-group btn-block">
										<div class="btn btn-sm btn-default btn-file">
											<span class="fileinput-new">Select Image</span>
											<span class="fileinput-exists">Change Image</span>
											<input type="file" name="userfile">
										</div>
										<a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
							</div>
							<label for="caption">Image Caption</label>
							<input type="text" class="form-control" name="caption" value="<?php echo set_value('caption') ? set_value('caption') : '' ?>" />
						</div>
						<div role="tabpanel" class="tab-pane" id="banner-html">
							<p class="help-block form-group">
								If you enter html text, it will be used instead of the image.
							</p>
							<textarea class="form-control" name="html_text" rows="6"><?php echo set_value('html_text') ? set_value('html_text') : '' ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


    <div class="form-group">
    	<div class="checkbox">
    		<label for="add_another" class="control-label">
				<input type="checkbox" class="" name="add_another" value="1" />
    			After adding banner, Reload this page.
    		</label>
    	</div>
    </div>
    
    <div class="form-group">
		<input type="submit" class="btn btn-lg btn-primary" name="update_banner" value="Update Banner" />
    </div>
<?php echo form_close() ?>


<?php echo modules::run('templates/footer', array(
	'scripts' => array(
		'static/vendor/cropper/cropper.min.js',
	)
)) ?>
<script>
	$(document).ready(function() {
		$('.fileinput').on('change.bs.fileinput', function (e) {
			$('.fileinput-preview img').cropper({
				aspectRatio: 16 / 9,
				crop: function(e) {
					$('input[name="crop_width"]').val(e.width);
					$('input[name="crop_height"]').val(e.height);
					$('input[name="crop_x"]').val(e.x);
					$('input[name="crop_y"]').val(e.y);
				}
			});
		})
	});
</script>