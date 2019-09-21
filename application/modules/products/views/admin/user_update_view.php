<?php $this->load->view('admin/header', array(
	'title' => 'User Profile',
	'pageTitle' => $person['username'],
	'link' => 'users',
	'breadcrumb' => array(
		0 => array('name'=> lang('menu_users'), 'link'=> 'admin/users'),
		1 => array('name'=> $person['username'], 'link'=> 'admin/users/groups'),
		2 => array('name'=> lang('menu_user_profile'), 'link'=> false),
	),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/css/cropper.min.css').'">',
		)
)); ?>

<?php $this->load->view('users/admin/sub_header', ['active' => 'details']) ?>
    
<h5 class="text-muted my-4">
	<?php echo lang('subtitle_update_user') ?>
</h5>

<?php echo form_open_multipart(current_url()); ?>

	<?php $this->load->view('form_fields', ['fields' => $form_fields]); ?>

	<button type="submit" name="update" value="save" class="btn btn-success mt-4">
		<?php echo lang('btn_update') ?>
	</button>
<?php echo form_close(); ?>


<script>
document.addEventListener("DOMContentLoaded", function() {
	$('.fileinput').on('change.bs.fileinput', function (e) {
		$('.fileinput-preview img').cropper({
			aspectRatio: 1 / 1,
			crop: function(e) {
				$('input[name=\"crop_width\"]').val(e.width);
				$('input[name=\"crop_height\"]').val(e.height);
				$('input[name=\"crop_x\"]').val(e.x);
				$('input[name=\"crop_y\"]').val(e.y);
			}
		});
	})
})
</script>

<?php $this->load->view('admin/footer', array(
	'scripts' => [
		'<script src="'.base_url('assets/js/cropper.min.js').'"></script>',
	],
)) ?>