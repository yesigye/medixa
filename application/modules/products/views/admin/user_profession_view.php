<?php $this->load->view('admin/header', array(
	'title' => lang('menu_users').' '.lang('menu_user_profession'),
	'pageTitle' => $username,
	'link' => 'users',
	'breadcrumb' => array(
		0 => array('name'=> lang('menu_users'), 'link'=> 'admin/users'),
		1 => array('name'=> $username, 'link'=> 'admin/users/groups'),
		2 => array('name'=> lang('menu_user_profession'), 'link'=> false),
	),
)); ?>

<?php $this->load->view('users/admin/sub_header', ['active' => 'prof']) ?>

<h5 class="text-muted my-4">
	<?php echo lang('form_edit_head') ?>
</h5>

<?php echo form_open(current_url()); ?>
    <?php $this->doctors->updateForm($user_id); ?>

    <button type="submit" name="save" value="save" class="btn btn-success mt-4">
        <?php echo lang('btn_edit') ?>
    </button>
<?php echo form_close(); ?>

<?php
$scriptCode = '<script>';
foreach ($locationTypes as $key => $type) {
    if ($key == 0) continue;
    $scriptCode .= '$("#'.$type['code'].'").remoteChained({
        parents : "#'.$locationTypes[$key-1]['code'].'",
        url : "'.site_url('locations/api/nodes').'"
    });';
}
$scriptCode .= '</script>';
?>

<?php $this->load->view('admin/footer', [
    'scripts' => [
        '<script src="'.base_url('assets/js/jquery.chained.remote.min.js').'"></script>',
        $scriptCode
    ],
]) ?>