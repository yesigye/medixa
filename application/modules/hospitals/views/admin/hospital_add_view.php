<?php $this->load->view('admin/header', array(
	'title' => 'Hospitals',
	'link' => 'hospitals',
	'pageTitle' => 'Hospitals',
	'breadcrumb' => array(
        ['name'=>'Hospitals', 'link'=>'admin/hospitals'],
        ['name'=>'new hospital', 'link'=>null],
    ),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/css/cropper.min.css').'">',
		)
)); ?>

<div class="card">
    <?php $this->load->view('sub_header', array('active' => 'hospitals')) ?>
    <div class="card-body">
        <div class="h5 text-muted mt-2 mb-3">Add a new hospital</div>
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger">Correct the errors in the form and try again</div>
        <?php endif ?>
        <?php echo form_open(current_url()) ?>
            <?php $this->load->view('form_fields', ['fields'=>$form_fields]); ?>
            
            <button type="submit" class="btn btn-primary" name="submit" value="Save">
                Add Hospital
            </button>
        <?php echo form_close() ?>
    </div>
</div>

<?php $this->load->view('admin/footer', array(
	'scripts' => array(
		'<script type="text/javascript" src="'.base_url('assets/js/cropper.min.js').'"></script>',
		"<script>
			$(document).ready(function() {
				$('.fileinput').on('change.bs.fileinput', function (e) {
					$('.fileinput-preview img').cropper({
						aspectRatio: 4 / 2,
						crop: function(e) {
							$('input[name=\"crop_width\"]').val(e.width);
							$('input[name=\"crop_height\"]').val(e.height);
							$('input[name=\"crop_x\"]').val(e.x);
							$('input[name=\"crop_y\"]').val(e.y);
						}
					});
				})
			});
		</script>"
	)
)) ?>