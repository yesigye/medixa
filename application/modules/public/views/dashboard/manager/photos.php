<?php echo $this->load->view('public/templates/header', array(
	'title' => 'My Dashboard',
    'link' => 'dashboard',
	'styles' => [
		'<link rel="stylesheet" href="'.base_url('assets/css/cropper.min.css').'">',
	]
)); ?>

<?php $this->load->view('sub_header', ['active' => 'photos']) ?>

    <?php $this->load->view('templates/alerts') ?>
    <div class="row">
        <div class="col-md-8">
            <p class="text-muted mb-3">
                <?= count($images) ?> photo<?= count($images) > 1 ? 's' : '' ?>
            </p>
        </div>

        <div class="col-md-4 text-right">
            <button type="button" class="btn btn-outline-secondary mb-3" data-toggle="modal" data-target="#add-modal">
                <small>UPLOAD</small>
            </button>
        </div>
    </div>

    <div class="card-columns mb-3">
        <?php foreach($images as $key => $image): ?>
        <?php echo form_open_multipart(current_url(), 'class="card mb-3 card-container"') ?>
            <div class="card-header p-0">
                <nav class="nav justify-content-end">
                    <a class="nav-link text-primary" data-toggle="modal" data-target="#edit-image-<?php echo $image['id'] ?>">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button type="submit" class="btn bg-white nav-link text-danger" name="delete_image" value="<?= $image['id'] ?>">
                        <i class="fa fa-times"></i>
                    </button>
                </nav>
            </div>
            <img src="<?= base_url('image/'.$image['url']) ?>" alt="" class="card-img-top">
            <?php if($image['caption']): ?>
            <div class="card-footer"><?= $image['caption'] ?></div>
            <?php endif ?>

            <div class="modal fade" id="edit-image-<?php echo $image['id'] ?>">
                <div class="modal-dialog">
                    <div class="modal-content border-0">
                        <div class="modal-header">
                            <h6 class="modal-title text-uppercase">Edit Image</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body file-container">
                            <div class="d-none">
                                <?= form_input('crop_x_'.$image['id'], '', 'class="crop_x"') ?>
                                <?= form_input('crop_y_'.$image['id'], '', 'class="crop_y"') ?>
                                <?= form_input('crop_width_'.$image['id'], '', 'class="crop_width"') ?>
                                <?= form_input('crop_height_'.$image['id'], '', 'class="crop_height"') ?>
                            </div>
                            <img src="<?= base_url('image/'.$image['url']) ?>" alt="" class="edit-img img-thumbnail img-fluid">
                            
                            <div class="form-group mt-2">
                                <label for="caption">Caption</label>
                                <input type="text" class="form-control" name="caption_<?= $image['id'] ?>" value="<?= $image['caption'] ?>">
                            </div>
                            <button type="submit" name="edit_image" value="<?= $image['id'] ?>" class="btn btn-primary mt-2">
                                <small>SAVE</small>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php echo form_close() ?>
        <?php endforeach ?>
    </div>
</div>
</div>

<?php echo form_open_multipart(current_url()) ?>
<div class="modal fade" id="add-modal">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Add Images</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (validation_errors() && $this->input->post('upload_images')): ?>
                    <div class="alert alert-danger" data-trigger-modal="#add-modal">Correct the errors in the form and try again</div>
                <?php endif ?>
                
                <?php if ($max_upload === 0): ?>
                    <p class="text-muted">
                        You can not upload any more images. You reached your limit of <?= $max_allowed ?> images.
                    </p>
                <?php else: ?>
                    <p class="text-muted">
                        You can upload up to <?= $max_upload ?> images.
                    </p>
                    <?php echo form_hidden('id', $hospital_id) ?>
                    <?php for ($i = 0; $i < $max_upload; $i++): ?>
                    <div class="card file-container mb-3">
                        <div class="d-none">
                            <?= form_input('crop_x['.$i.']', '', 'class="crop_x"') ?>
                            <?= form_input('crop_y['.$i.']', '', 'class="crop_y"') ?>
                            <?= form_input('crop_width['.$i.']', '', 'class="crop_width"') ?>
                            <?= form_input('crop_height['.$i.']', '', 'class="crop_height"') ?>
                        </div>
                        <div class="fileinput fileinput-hospital fileinput-new" data-provides="fileinput" data-key="<?php echo $i ?>">
                            <div class="card-body fileinput-new thumbnail">
                                <div class="text-muted" style="margin:1rem 0">no file selected</div>
                            </div>
                            <div class="fileinput-preview thumbnail fileinput-exists">
                            </div>
                            <div class="btn-group btn-block">
                                <a class="btn btn-sm btn-secondary btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="files[<?php echo $i ?>]">
                                </a>
                                <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="text" name="captions[<?php echo $i ?>]" value="" placeholder="Type caption here..." class="form-control form-control-sm">
                        </div>
                    </div>
                    <?php endfor ?>
                    
                    <input type="submit" class="btn btn-primary mt-2" name="upload_images" value="Upload Images"/>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?php echo form_close() ?>

<?php $this->load->view('public/templates/footer', ['scripts' => [
    '<script type="text/javascript" src="'.base_url('assets/js/cropper.min.js').'"></script>',
    "<script>
        $(document).ready(function() {
            $('.fileinput').on('change.bs.fileinput', function (e) {
                var el = $(this);
                el.find('.fileinput-preview img').cropper({
                    aspectRatio: 4 / 2,
                    crop: function(e) {
                        var container = el.closest('.file-container');
                        container.find('input.crop_width').val(e.width);
                        container.find('input.crop_height').val(e.height);
                        container.find('input.crop_x').val(e.x);
                        container.find('input.crop_y').val(e.y);
                    }
                });
            })

            $('.edit-img').cropper({
                aspectRatio: 4 / 2,
                crop: function(e) {
                    var container = $(this).closest('.file-container');
                    container.find('input.crop_width').val(e.width);
                    container.find('input.crop_height').val(e.height);
                    container.find('input.crop_x').val(e.x);
                    container.find('input.crop_y').val(e.y);
                }
            });
        });
    </script>",
]]) ?>