<?php echo $this->load->view('public/templates/header', array(
	'title' => 'Hospitals',
	'link' => 'hospitals',
	'pageTitle' => $hospital['name'],
	'pageSubTitle' => $hospital['address'],
	'breadcrumb' => [
		0 => array('name'=>'Hospitals', 'link'=>'hospitals'),
		1 => array('name'=>$hospital['name'], 'link'=>false),
	],
	'styles' => array(
        '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
        integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin=""/>'
	),
)); ?>

<div class="container">
	<?php if (validation_errors() AND $this->input->post('send_message')): ?>
		<div class="alert alert-danger">
			Errors were detected in the
			<a href="#contact-me">Contant Me</a> form. review this form and try again.
			<script>$('form').focus()</script> 
		</div>
	<?php endif ?>
	<?php echo $this->load->view('alerts') ?>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="mb-3">
				<?php // Only one image, no need for a carousel ?>
				<?php if (count($images) == 1): ?>
					<?php foreach ($images as $key => $img): ?>
						<img src="<?php echo $img['url'] ?>" class="img-responsive" style="max-height:350px;display:initial">
					<?php endforeach ?>
				<?php else: // Multiple images, use bootstrap carousel ?>

					<div id="carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<?php foreach ($images as $key => $img): ?>
								<li data-target="#carousel" data-slide-to="<?php echo $key ?>" class="<?php echo ($key === 0) ? 'active' : '' ?>"></li>
							<?php endforeach ?>
						</ol>

						<div class="carousel-inner" role="listbox">
							<?php foreach ($images as $key => $img): ?>
								<div class="text-center carousel-item <?= ($key == 0) ? 'active' : null ?>">
									<img src="<?php echo base_url('image/'.$img['url']) ?>" class="card-img-top">
								</div>
							<?php endforeach ?>
						</div>

						<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				<?php endif ?>
			</div>

			<p class="mb-3"><?= $hospital['slogan'] ?></p>
			<?= $hospital['description'] ?>
			
			<hr class="mt-5">

			<div class="h6 mt-5 mb-2 text-muted text-uppercase">Additional Information</div>
			
			<?php if(!empty($facilities)): ?>
			<div class="font-weight-bold mt-3">Facilities</div>
			<?php foreach ($facilitiesList as $key => $facility): ?>
				<?php if(in_array($facility['id'], $facilities)): ?>
					<span class="mr-3"><?= $facility['name'] ?></span>
				<?php endif ?>
			<?php endforeach ?>
			<?php endif ?>

			<?php if(!empty($specialities)): ?>
			<div class="font-weight-bold mt-3">Departments</div>
			<?php foreach ($specialities as $key => $speciality): ?>
				<span class="mr-3"><?= $speciality['name'] ?></span>
			<?php endforeach ?>
			<?php endif ?>

			<div class="h6 mt-5 mb-2 text-muted text-uppercase">Location</div>
			<?php if ($hospital['latitude'] && $hospital['longitude']): ?>
			<div class="card" id="map" style="height:500px"></div>
			<?php endif ?>
		</div>
		<div class="col-md-4">
			<?= form_open(current_url()) ?>
			<div class="card mb-3">
				<div class="card-body">
					<div class="mb-2 clearfix">
						<div class="h6 text-muted float-left text-uppercase">Contact Us</div>
						<div class="text-right float-right">
							<img src="<?= base_url('image/'.$hospital['logo']) ?>" style="width:50px">
						</div>
					</div>
					
					<p class="mt-4 text-muted">For any inquiries, please send us a message</p>
					<div class="form-group <?= form_error('email') ? 'has-error' : null ?>">
						<input type="text" name="email" class="form-control" placeholder="Your email" value="<?php echo set_value('email') ?>">
						<?= form_error('email') ?>
					</div>
					<div class="form-group <?= form_error('message') ? 'has-error' : null ?>">
						<textarea rows="6" name="message" class="form-control" placeholder="Message"><?php echo set_value('message') ?></textarea>
						<?= form_error('message') ?>
					</div>
					<button type="submit" name="send_message" value="send" class="btn btn-lg btn-block btn-primary rounded-0">
						<small><i class="fa fa-envelope mr-2"></i> Send message </small>
					</button>
					<div class="my-2 text-center">OR</div>
					<div class="card card-body rounded-0">
						<small class="text-muted"><i class="fa fa-phone mr-2"></i> Talk to us </small>
						<?= $hospital['phone'] ?>
					</div>
				</div>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>

<div class="container">
	<?php if(!empty($doctors)): ?>
	<div class="h6 text-muted text-uppercase mt-5 mb-3">Our Physicians</div>
	<?php $this->load->view('public/templates/doctors_cards', ['doctors' => $doctors]) ?>
	<?php endif ?>

	<?php if(!empty($hospitals)): ?>
	<div class="h6 text-muted text-uppercase mt-5 mb-3">More Hospitals</div>
	<?php $this->load->view('public/templates/hospitals_cards', ['hospitals' => $hospitals]) ?>
	<?php endif ?>
</div>

<script>    
document.addEventListener("DOMContentLoaded", function() {
    var latitude = '<?php echo set_value("latitude") ? set_value("latitude") : $hospital["latitude"] ?>';
    var longitude = '<?php echo set_value("longitude") ? set_value("longitude") : $hospital["longitude"] ?>';
    
    var map = L.map('map').setView([latitude, longitude], 13);
        var marker = L.marker([latitude, longitude], {}).addTo(map);
    
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibnlhbnNpbyIsImEiOiJjanR2bjV3dTgxdDFyM3lwY3h2NGsxaHYzIn0.6hs6bxbgH6DglQiGzTi72w', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'your.mapbox.access.token'
    }).addTo(map);
})
</script>
<?php $this->load->view('admin/footer', [
    'scripts' => [
        '<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
        integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
        crossorigin=""></script>'
    ]
]) ?>