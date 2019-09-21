<?php echo $this->load->view('public/templates/header', array(
	'title' => 'My Dashboard',
    'link' => 'dashboard',
	'styles' => [
        '<link rel="stylesheet" href="'.base_url('assets/css/cropper.min.css').'">',
        '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
        integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin=""/>'
	]
)); ?>

<?php $this->load->view('sub_header', ['active' => 'about']) ?>

    <?php $this->load->view('templates/alerts') ?>

    <?= form_open_multipart(current_url()) ?>
    
    <h5 class="mb-4">Edit your Profile</h5>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Preview Image</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Site Map</a>
        </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-md-4 order-md-2">
                    <?php 
                    echo form_hidden('crop_x', '');
                    echo form_hidden('crop_y', '');
                    echo form_hidden('crop_width', '');
                    echo form_hidden('crop_height', '');
                    ?>
                    <div class="card">
                        <div class="card-header bg-secondary text-white">Logo</div>
                        <div class="fileinput fileinput-new" data-provides="fileinput" id="fileSelect1">
                            <div class="card-body p-0 fileinput-new thumbnail text-warning">
                                <?php if($hospital['logo']): ?>
                                    <img src="<?php echo base_url('image/'.$hospital['logo']) ?>" alt="">
                                <?php else: ?>
                                    <div class="text-muted">No logo</div>
                                <?php endif ?>
                            </div>
                            <div class="card-body p-0 fileinput-preview fileinput-exists thumbnail" id="fileSelect1-thumb"></div>
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
                </div>
                <div class="col-md-8 order-md-1">
                    <?php $this->load->view('form_fields', ['fields'=>$form_fields]); ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <p class="">
                This is the image that will appear on cards and tiles through out the website.
                It is the first image that a page visitor will see, upload an image that represents you the best.
            </p>
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
        <div class="tab-pane fade active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <p class="">
                To change your location on the map, Drag the blue pointer to where you want it.
                The latitude and longitude values are automatically updated. Only edit them if you
                know the geo-codes of your location.
            </p>
            <div class="card-body my-3" id="map" style="height:300px"></div>
            <?php $this->load->view('form_fields', ['fields'=>$geocode_fields]); ?>
        </div>
    </div>

    <button type="submit" name="update" value="update" class="btn btn-lg btn-primary my-3">
        <small>SAVE CHANGES</small>
    </button>
    <?= form_close() ?>
</div>
</div>

<script>    
document.addEventListener("DOMContentLoaded", function() {
    var latitude = '<?php echo set_value("latitude") ? set_value("latitude") : $hospital["latitude"] ?>';
    var longitude = '<?php echo set_value("longitude") ? set_value("longitude") : $hospital["longitude"] ?>';
    
    var map = L.map('map').setView([latitude, longitude], 13);
        var marker = L.marker([latitude, longitude], {draggable: true}).addTo(map);
    
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibnlhbnNpbyIsImEiOiJjanR2bjV3dTgxdDFyM3lwY3h2NGsxaHYzIn0.6hs6bxbgH6DglQiGzTi72w', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'your.mapbox.access.token'
    }).addTo(map);
    
    // var draggable = new L.Draggable(marker);
    // draggable.enable();
    marker.on('dragend', function(event){
        var marker = event.target;
        var position = marker.getLatLng();
        marker.setLatLng(new L.LatLng(position.lat, position.lng),{draggable:'true'});
        map.panTo(new L.LatLng(position.lat, position.lng))
        $('[name="latitude"]').val(position.lat)
        $('[name="longitude"]').val(position.lng)
    });

    function onMapClick(e) {
        alert("You clicked the map at " + e.latlng);
    }
})
</script>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", initActions);
function initActions() {
    $(document).ready(function() {
        
        var hash = $(location).prop('hash');
        $('body a[href="'+hash+'"]').tab('show')
        
        if(hash !== 'contact') $('#contact').removeClass('active')

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
        
        $('#fileSelect1').on('change.bs.fileinput', function (e) {
            $('#fileSelect1-thumb img').cropper({
                aspectRatio: 1 / 1,
                crop: function(e) {
                    $('input[name="crop_width"]').val(e.width);
                    $('input[name="crop_height"]').val(e.height);
                    $('input[name="crop_x"]').val(e.x);
                    $('input[name="crop_y"]').val(e.y);
                }
            });
        })
    });
}
</script>

<?php $this->load->view('public/templates/footer', ['scripts' => [
    '<script type="text/javascript" src="'.base_url('assets/js/cropper.min.js').'"></script>',
    '<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
    integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
    crossorigin=""></script>'
]]) ?>