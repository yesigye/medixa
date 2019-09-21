<?php $this->load->view('admin/header', array(
	'title' => lang('menu_groups'),
	'pageTitle' => $group['name'],
	'link' => 'groups',
	'breadcrumb' => array(
		0 => array('name'=> lang('menu_users'), 'link'=> 'admin/users'),
		1 => array('name'=> lang('menu_groups'), 'link'=> 'admin/users/groups'),
		2 => array('name'=> $group['name'], 'link'=> false),
	),
)); ?>


<?php $this->load->view('/sub_header', ['active' => 'details']) ?>

<h5 class="text-muted mb-4"><?php echo lang('title_update_group') ?></h5>
<?= form_open(current_url()) ?>
	<?= form_hidden('id', $group['id']) ?>
	
	<?php $this->load->view('form_fields', ['fields' => $form_fields]); ?>
	
	<button type="submit" name="update_group" value="1" class="btn btn-primary">
		<?php echo lang('btn_edit') ?>
	</button>
<?= form_close() ?>

<?php $this->load->view('admin/footer') ?>