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
        '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
        integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin=""/>'
	),
)); ?>

<?php $this->load->view('sub_header', array('active' => 'location')) ?>

<?php echo form_open(current_url()) ?>
<div class="row">
    <div class="col-md-6">
        <p><?php echo lang('form_edit_head') ?></p>
        <?php $this->load->view('form_fields', ['fields' => $form_fields]) ?>
    </div>
    <div class="col-md-6">
        <p class="text-muted my-2">
            To change your location on the map, Drag the blue pointer to where you want it.
            The latitude and longitude values are automatically updated. Only edit them if you
            know the geo-codes of your location.
        </p>
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">Map</div>
            <div class="card-body" id="map" style="height:250px"></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 form-group">
                        <label class="sr-only" for="locLat">Latitude</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text px-2 py-0"><small>Lat</small></div>
                            </div>
                            <input type="text" name="latitude" class="form-control form-control-sm" id="locLat" placeholder="Latitude" value="<?php echo set_value('latitude') ? set_value('latitude') : $hospital['latitude'] ?>">
                        </div>
                    </div>
                    <div class="col-6 form-group pl-0">
                        <label class="sr-only" for="locLng">Longitude</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text px-2 py-0"><small>Lang</small></div>
                            </div>
                            <input type="text" name="longitude" class="form-control form-control-sm" id="locLng" placeholder="Longitude" value="<?php echo set_value('longitude') ? set_value('longitude') : $hospital['longitude'] ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="sr-only" for="locAddress">Address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text px-2 py-0"><small>Address</small></div>
                            </div>
                            <input type="text" name="address" class="form-control form-control-sm" id="locAddress" placeholder="Address" value="<?php echo set_value('address') ? set_value('address') : $hospital['address'] ?>">
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<input type="submit" name="update" class="btn btn-success" value="<?php echo lang('btn_save') ?>">

<?php echo form_close() ?>

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
        $('#locLat').val(position.lat)
        $('#locLng').val(position.lng)
    });

    function onMapClick(e) {
        alert("You clicked the map at " + e.latlng);
    }
})
</script>

<?php
$scriptcode = '<script>';
foreach ($locationTypes as $key => $type) {
    if ($key == 0) {
        // $scriptcode .= '$("#'.$locationTypes[$key]['code'].'").val("'.$location_lineage[$key]['code'].'").change();';
    } else {
        $scriptcode .= '
        $("#'.$type['code'].'").remoteChained({
            parents : "#'.$locationTypes[$key-1]['code'].'",
            url : "'.site_url('locations/api/nodes').'"
        });';
        // $scriptcode .= '$("#'.$locationTypes[$key]['code'].'").val("'.$location_lineage[$key]['code'].'").change();';
    }
}
$scriptcode .= '</script>';
?>

<?php $this->load->view('admin/footer', [
    'scripts' => [
        '<script src="'.base_url('assets/js/jquery.chained.remote.min.js').'"></script>',
        $scriptcode,
        '<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
        integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
        crossorigin=""></script>'
    ]
]) ?>