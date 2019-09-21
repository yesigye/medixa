<?php $this->load->view('admin/header', array(
	'title' => lang('menu_hospitals'),
	'link' => 'hospitals',
	'pageTitle' => $hospital_name,
	'breadcrumb' => array(
        ['name' => lang('menu_hospitals'), 'link'=> 'admin/hospitals'],
    ),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
        '<link rel="stylesheet" href="'.base_url('assets/css/cropper.min.css').'">',
	),
)); ?>

<?php $this->load->view('sub_header', array('active' => 'images')) ?>

<?php echo form_open_multipart(current_url()) ?>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger">Correct the errors in the form and try again</div>
<?php endif ?>

<?php if(empty($images)): ?>

<div class="my-2 text-muted">No images were found</div>

<?php else: ?>

<div class="card-columns">
    <?php foreach ($images as $key => $image): ?>
    <div class="card image-container border-secondary">
        <img src="<?php echo base_url('image/'.$image['url']) ?>" class="card-img-top"  data-toggle="modal" data-target="#update-images-<?php echo $image['id'] ?>">
        <p class="card-text p-1 text-right">
            <button type="button" class="btn btn-sm btn-outline-danger delete-img" data-id="<?php echo $image['id'] ?>"><?php echo lang('btn_delete') ?></button>
        </p>
    </div>
    <?php endforeach ?>

    <a href="#modal-add" data-toggle="modal" class="card card-body border-success text-center">
        <h1><i class="fa fa-plus text-success"></i></h1>
    </a>
</div>

<?php endif ?>

<div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header">
                <div class="modal-title"><?php echo lang('title_create_images') ?></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (validation_errors() && $this->input->post('upload_images')): ?>
                    <div class="alert alert-danger" data-trigger-modal="#add-modal"><?php echo lang('alert_form_errors') ?></div>
                <?php endif ?>
                <?php $max_allowed = $upload_limit - count($images) ?> 
                <p class="text-muted">
                    <?php echo $this->lang->line('subtitle_create_images', $max_allowed) ?>
                </p>
                <?php echo form_hidden('id', $hospital_id) ?>
                <div class="row">
                    <?php for ($i = 0; $i < $max_allowed; $i++): ?>

                    <?= form_hidden('crop_x['.$i.']', '') ?>
                    <?= form_hidden('crop_y['.$i.']', '') ?>
                    <?= form_hidden('crop_width['.$i.']', '') ?>
                    <?= form_hidden('crop_height['.$i.']', '') ?>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="fileinput fileinput-hospital fileinput-new" data-provides="fileinput" data-id="<?php echo $i ?>">
                                <div class="card-body fileinput-new thumbnail">
                                    <div class="text-muted" style="margin:1rem 0"><?php echo lang('form_image_placeholder') ?></div>
                                </div>
                                <div class="fileinput-preview thumbnail fileinput-exists">
                                </div>
                                <div class="btn-group btn-block">
                                    <a class="btn btn-sm btn-secondary btn-file">
                                        <span class="fileinput-new"><?php echo lang('btn_select') ?></span>
                                        <span class="fileinput-exists"><?php echo lang('btn_update') ?></span>
                                        <input type="file" class="add-file-uploader" name="files[<?php echo $i ?>]">
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput"><?php echo lang('btn_delete') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endfor ?>
                </div>
                
                <input type="submit" class="btn btn-primary mt-2" name="upload_images" value="<?php echo lang('btn_save') ?>"/>
            </div>
        </div>
    </div>
</div>
<?php echo form_close() ?>

<script>

document.addEventListener("DOMContentLoaded", function() {
    $('.fileinput').on('change.bs.fileinput', function (e) {
        var id = $(this).attr('data-id');
        $(this).find('.fileinput-preview img').cropper({
            aspectRatio: 16 / 9,
            crop: function(e) {
                $('input[name="crop_width['+id+']"]').val(e.width);
                $('input[name="crop_height['+id+']"]').val(e.height);
                $('input[name="crop_x['+id+']"]').val(e.x);
                $('input[name="crop_y['+id+']"]').val(e.y);
            }
        });
    })
    
    $('.delete-img').click(function() {
        var id = $(this).attr('data-id');
        var el = $(this).closest('.image-container');
        
        $.ajax({
            url: '<?php echo base_url('hospitals/api/deleteImage/') ?>'+id,
            type: 'DELETE',
            beforeSend: function(result) {
                $('.image-container button').attr('disabled', 'disabled');
            },
            success: function(result) {
                el.remove()
            },
            complete: function(result) {
                $('.image-container button').removeAttr('disabled');
            },
        });
    });
});
</script>

<?php $this->load->view('admin/footer', [
    'scripts' => ['<script type="text/javascript" src="'.base_url('assets/js/cropper.min.js').'"></script>'],
]) ?>