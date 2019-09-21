<?php $this->load->view('dashboard/header', array(
	'link' => 'tools',
	'sub_link' => 'banner manager'
)) ?>

<div class="page-header">
    <h4>
        <span class="glyphicon glyphicon-picture" style="margin-right:10px"></span>
        Edit Banner
    </h4>
</div>

<?php echo form_open(current_url()) ?>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-6">
		<div class="form-group">
			<label for="title">Title:</label>
			<input class="form-control" type="text" name="title" value="<?php echo (set_value('title')) ? set_value('title') : $banner->title ?>" />
		</div>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-6">
		<div class="form-group">
			<label for="url">Url link:</label>
			<input class="form-control" type="text" name="url" value="<?php echo (set_value('url')) ? set_value('url') : $banner->url ?>" />
		</div>
	</div>

	<div class="col-xs-12 col-sm-6 col-md-6 form-group">
		<label for="userfile">Image:</label>
		<div class="panel panel-info">
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-new thumbnail">
					<img class="img-responsive" src="<?php echo $banner->image ?>">
				</div>
				<div class="fileinput-preview thumbnail fileinput-exists">
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
		<label for="caption">Image Caption:</label>
		<input type="text" class="form-control" name="caption" value="<?php echo (set_value('caption')) ? set_value('caption') : $banner->caption ?>" />
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6">
		<label for="html_text">HTML Text: (overrides image)</label>
		<textarea class="form-control" name="html_text" rows="12"><?php echo (set_value('html_text')) ? set_value('html_text') : $banner->html ?></textarea>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 help-block form-group">
		If you enter html text, it will be used instead of the image.
	</div>

	<div class="col-xs-12 col-sm-4 col-md-6">
		<div class="form-group">
			<label for="start_date">Start date:</label>
			<input type="text" class="form-control" name="start_date" value="<?php echo (set_value('start_date')) ? set_value('start_date') : $banner->start_date ?>" />
		</div>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-6">
		<div class="form-group">
			<label for="end_date">End date:</label>
			<input type="text" class="form-control" name="end_date" value="<?php echo (set_value('end_date')) ? set_value('end_date') : $banner->end_date ?>" />
		</div>
	</div>
</div>
<input type="submit" class="btn btn-lg btn-block btn-primary" name="update_banner" value="Update" />
<?php echo form_close() ?>

<?php $this->load->view('dashboard/footer') ?>