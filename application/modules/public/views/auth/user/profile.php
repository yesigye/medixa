<?php echo $this->load->view('public/templates/header', array(
	'title' => 'My Dashboard',
    'link' => 'profile',
	'styles' => [
		'<link rel="stylesheet" href="'.base_url('assets/css/cropper.min.css').'">',
	]
)); ?>

<div class="container">
    <?php $this->load->view('sub_header', ['active' => 'details']) ?>
    
    <?= form_open_multipart(current_url()) ?>
    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <?php $this->load->view('form_fields', ['fields'=>$form_fields]); ?>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="rounded mb-2" id="map" style="height: 300px"></div>
            <?php $this->load->view('form_fields', ['fields'=>$medical_fields]); ?>
        </div>
    </div>

    <button type="submit" name="save" value="save" class="btn btn-lg btn-primary my-5">
        <small>SAVE CHANGES</small>
    </button>
    <?= form_close() ?>
</div>


<script type="text/javascript">

document.addEventListener("DOMContentLoaded", initActions);

function initActions() {
    var hash = $(location).prop('hash');
    $('body a[href="'+hash+'"]').tab('show')

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
}
</script>

<?php $this->load->view('public/templates/footer', ['scripts' => [
    '<script type="text/javascript" src="'.base_url('assets/js/cropper.min.js').'"></script>',
]]) ?>