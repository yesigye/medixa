<div class="card-group row m-0 h-100">
	<?php if(!empty($doctors)): ?>
	<div class="<?php if($doctors) echo 'col-md-3' ?> p-0 h-100 card" style="overflow-y:auto">
		<div class="bg-light p-2">
			<p>Top doctors</p>
			<?php $this->load->view('public/templates/doctors_cards', [
				'doctors' => $doctors,
				'row' => 'horizontal-scroll-alt',
				'col' => 'scroll-item',
				]) ?>
		</div>
	</div>
	<?php endif ?>
	<div class="<?php if($doctors) echo 'col-md-9' ?> p-0 h-100 card border-0 rounded-0 bg-secondary" style="height:40rem">
		<a href="<?php echo $linkToggleContainer ?>" class="btn bg-white position-absolute" style="z-index:1000;right:10%;top:1rem;">
			<i class="fa fa-caret-left"></i> Return to list
		</a>
		<div id="map" class="h-100"></div>
	</div>
</div>

<script js>


document.addEventListener("DOMContentLoaded", function() {
	<? foreach($hospitals as $key => $hospital): ?>
	<? if($key == 0): ?>
    var map = L.map('map').setView([<?php echo $hospital['latitude'] ?>, <?php echo $hospital['longitude'] ?>], 8);
	<? endif ?>
		var iconUrl = 'assets/images/marker-hospital.png';
		var doctorIcon = L.icon({
			iconUrl,
			iconSize: [40, 40],
		})
		var marker = L.marker([<?php echo $hospital['latitude'] ?>, <?php echo $hospital['longitude'] ?>], {
			icon: doctorIcon
		}).addTo(map).bindPopup(`
			<a href="<?php echo site_url('hospitals/'.$hospital['slug']) ?>" class="card-link">
                <div class="card shade mb-3">
                    <div class="card-group">
                        <div class="card border-0">
                            <img src="<?php echo base_url('image/'.$hospital['preview']) ?>" alt="" class="card-img-top">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-truncate text-dark"><?php echo $hospital['name'] ?></div>
                        <p class="text-muted text-truncate m-0">
						<?php echo $hospital['address'] ?>
                        </p>
						<div class="row text-muted">
							<div class="col-6">
								<i class="mr-2 fa fa-user-md"></i>
								<?php echo $hospital['doctors'] ?>
							</div>
							<div class="col-6">
								<i class="mr-2 fa fa-bed"></i>
								<?php echo $hospital['facilities'] ?>
							</div>
						</div>	
                    </div>
                </div>
            </a>
		`);
	<? endforeach ?>

	// L.marker([0.29182307909385774, 32.58888244628907], {}).addTo(map);
	// L.marker([0.3048691668455094, 32.529315948486335], {}).addTo(map);
    
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibnlhbnNpbyIsImEiOiJjanR2bjV3dTgxdDFyM3lwY3h2NGsxaHYzIn0.6hs6bxbgH6DglQiGzTi72w', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 12,
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
        console.log(position)
	});
	
	marker.on('click', function(event){
        var marker = event.target;
        var position = marker.getLatLng();
		
		console.log(position)
    });

    function onMapClick(e) {
        alert("You clicked the map at " + e.latlng);
	}

	$('#locate-me').click(function() {
		console.log('position')
		map = L.map('map', {doubleClickZoom: false}).locate({setView: true, maxZoom: 16});
	})
})
</script>