<?php $this->load->view('admin/header', array(
	'title' => lang('menu_languages'),
	'pageTitle' => lang('menu_languages'),
	'link' => 'locations',
	'breadcrumb' => array(
		1 => array('name'=> lang('menu_languages'), 'link'=> false),
	),
)); ?>

<div class="h4 py-3">
	<?php echo lang('title_lang_select') ?>
</div>

<div class="row">
	<?php foreach($languages as $row): ?>
	<div class="col-md-4 col-lg-3 mb-3">
		<a
		href="<?php echo site_url('admin/languages/edit/'.$row['language']) ?>"
		class="card card-body text-center card-link text-dark">
			<p class="my-1"><?php echo $row['language'] ?></p>
		</a>
	</div>
	<?php endforeach ?>

	<div class="col-md-4 col-lg-3 mb-3">
		<?php echo form_open() ?>
		<div class="card p-1 card-body text-center">
			<input
			type="text"
			name="language"
			placeholder="add a new language"
			class="form-control form-control-sm <?= form_error('language') ? 'is-invalid' : '' ?>"
			value="<?= set_value('language') ?>" required/>
			<?php if (form_error('language')): ?>
				<div class="invalid-feedback"><?php echo form_error('language') ?></div>
			<?php endif ?>
			<button type="submit" name="insert" value="1" class="btn btn-sm btn-success mt-1"><?php echo lang('btn_create') ?></button>
		</div>
		<?php echo form_close() ?>
	</div>
</div>

<?php $this->load->view('admin/footer') ?>