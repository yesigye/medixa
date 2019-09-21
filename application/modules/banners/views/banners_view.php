<?php echo modules::run('templates/header', array(
	'title' => 'Manage Banners',
	'link' => 'extras',
	'sub_link' => 'banners',
	'breadcrumbs' => array(
		0 => array('name'=>'Banners','link'=>FALSE)
	),
	'breadcrumb_action' => array(
		'name'=>'Add Banner', 'link'=>'admin/banners/add',
	)
)); ?>

<div class="page-header">
	<h4 class="lead">
		<span class="fa fa-image" style="margin-right:10px"></span> Banners
	</h4>
	<p>
		Banners are visual adverts or promotions that are displayed at the home page of the store-front.
		Banners can either be images or html text which always overides images.
		Banners can be setup to run at and expire after defined dates.
	</p>
</div>

<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check banners that you want to delete firsts.</div>
<?php else: ?>
	<?php if (! empty($message)): ?>
		<div id="message"> <?=$message ?> </div>
	<?php endif ?>
<?php endif ?>

<?php if ($banners): ?>
	<?php echo form_open(current_url()) ?>

		<div class="panel panel-default panel-inverse">
			<div class="panel-heading">
				<input type="submit" name="delete_selected" value="Delete Selected" class="btn btn-xs btn-danger">
			</div>

			<table class="table table-flat table-striped">
				<tbody>
					<?php foreach ($banners as $key => $banner): ?>
						<tr>
							<td class="text-center"><?php echo form_checkbox('selected[]', $banner->id) ?></td>
							<td>
								<img src="<?php echo base_url('image/'.$banner->image) ?>" alt="" style="height:25px">
							</td>
							<td class="text-center">
								<a href="<?php echo base_url('admin/banners/update/'.$banner->id) ?>">
									<?php echo $banner->title ?>
								</a>
							</td>
							<td class="text-center">
								<?php if ($banner->end_date): ?>
									<?php if ($banner->is_expired): ?>
										<span class="label label-danger">expired</span>
									<?php else: ?>
										<span class="label label-success">running</span>
									<?php endif ?>
								<?php else: ?>
									<span class="label label-warning">pending</span>
								<?php endif ?>
							</td>
							<td class="text-center">
								<?php echo $banner->days_left ?> left
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	<?php echo form_close() ?>
<?php else: ?>
	<div class="alert alert-warning">
		You have no banners setup.
		<?php echo anchor('admin/insert_banner', 'Insert Banners', 'class="alert-link"') ?>
	</div>
<?php endif ?>

<?php echo modules::run('templates/footer', array(
	'scripts' => array(
		'static/js/select-all-checkbox.js',
	)
)) ?>