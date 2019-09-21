<?php $this->load->view('admin/header', array(
	'title' => lang('menu_hospitals'),
	'link' => 'hospitals',
	'pageTitle' => $hospital['name'],
	'breadcrumb' => array(
        ['name' => lang('menu_hospitals'), 'link'=> 'admin/hospitals'],
    ),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
        '<link rel="stylesheet" href="'.base_url('assets/css/cropper.min.css').'">',
	),
)); ?>

<?php $this->load->view('sub_header', array('active' => 'details')) ?>

<p><?php echo lang('form_edit_head') ?></p>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger">Correct the errors in the form and try again</div>
<?php endif ?>

<?php echo form_open_multipart(current_url()) ?>
    <div class="row">
        <div class="col-md-8">
            <?php $this->load->view('form_fields', ['fields' => $form_fields]) ?>
        </div>

        <div class="col-md-4">
            <div class="form-group <?php echo form_error('userfile') ? 'has-error' : null ?>">
                <?php 
                echo form_hidden('crop_x', '');
                echo form_hidden('crop_y', '');
                echo form_hidden('crop_width', '');
                echo form_hidden('crop_height', '');
                ?>
                <div class="card">
                    <div class="card-header bg-secondary text-white">Logo</div>
                    <div class="fileinput fileinput-new" data-provides="fileinput" id="logo-input">
                        <div class="card-body p-0 fileinput-new thumbnail text-warning">
                            <?php if($hospital['logo']): ?>
                                <img src="<?php echo base_url('image/'.$hospital['logo']) ?>" alt="">
                            <?php else: ?>
                                <div class="text-muted">No logo</div>
                            <?php endif ?>
                        </div>
                        <div class="card-body p-0 fileinput-preview fileinput-exists thumbnail" id="logo-thumb"></div>
                        <div class="card-footer p-0 btn-group btn-block">
                            <div class="btn btn-file rounded-0">
                                <span class="fileinput-new">Select image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="userfile">
                            </div>
                            <a href="#" class="btn btn-danger rounded-0 fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                </div>

                <?php
                echo form_hidden('crop_x2', '');
                echo form_hidden('crop_y2', '');
                echo form_hidden('crop_width2', '');
                echo form_hidden('crop_height2', '');
                ?>
                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">Preview</div>
                    <div class="fileinput fileinput-new" data-provides="fileinput" id="preview-input">
                        <div class="card-body p-0 fileinput-new thumbnail text-warning">
                            <?php if($hospital['preview']): ?>
                                <img src="<?php echo base_url('image/'.$hospital['preview']) ?>" alt="">
                            <?php else: ?>
                                <div class="text-muted">No Image</div>
                            <?php endif ?>
                        </div>
                        <div class="card-body p-0 fileinput-preview fileinput-exists thumbnail" id="preview-thumb"></div>
                        <div class="card-footer p-0 btn-group btn-block">
                            <div class="btn rounded-0 btn-file">
                                <span class="fileinput-new">Select image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="preview">
                            </div>
                            <a href="#" class="btn btn-danger rounded-0 fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <?php echo lang('menu_facilities') ?>
                </div>
                <div class="card-body pb-0" style="max-height:250px;overflow:auto">
                    <?php if( empty($all_facilities) ): ?>
                        <div class="text-muted pb-3">Please define facilities first.</div>
                    <?php else: ?>
                    <?php foreach ($all_facilities as $key => $facility): ?>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="check_<?php echo $key ?>"
                                name="facilities[]" value="<?php echo $facility['id'] ?>"
                                <?php echo (in_array($facility['id'], $facilities)) ? 'checked="checked"' : set_checkbox('facilities[]', $facility['id']) ?>
                                >
                                <label for="check_<?php echo $key ?>" class="custom-control-label">
                                    <?php echo $facility['name'] ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
        
    <button type="submit" class="btn btn-primary mt-3" name="update" value="Save">
        <?php echo lang('btn_save') ?>
    </button>
<?php echo form_close() ?>


<script>

document.addEventListener("DOMContentLoaded", function() {
    $('#logo-input').on('change.bs.fileinput', function (e) {
        $('#logo-thumb img').cropper({
            aspectRatio: 1 / 1,
            crop: function(e) {
                $('input[name="crop_width"]').val(e.width);
                $('input[name="crop_height"]').val(e.height);
                $('input[name="crop_x"]').val(e.x);
                $('input[name="crop_y"]').val(e.y);
            }
        });
    })
    $('#preview-input').on('change.bs.fileinput', function (e) {
        $('#preview-thumb img').cropper({
            aspectRatio: 16 / 9,
            crop: function(e) {
                $('input[name="crop_width2"]').val(e.width);
                $('input[name="crop_height2"]').val(e.height);
                $('input[name="crop_x2"]').val(e.x);
                $('input[name="crop_y2"]').val(e.y);
            }
        });
    })
});
</script>

<?php $this->load->view('admin/footer', [
    'scripts' => ['<script type="text/javascript" src="'.base_url('assets/js/cropper.min.js').'"></script>'],
]) ?>