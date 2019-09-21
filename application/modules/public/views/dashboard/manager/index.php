<?php echo $this->load->view('public/templates/header', array(
	'title' => 'My Dashboard',
    'link' => 'dashboard',
)); ?>

<?php $this->load->view('sub_header', ['active' => 'home']) ?>
    <div class="row">
        <div class="col-md-8">
            <?php $this->load->view('templates/alerts') ?>
            <div class="card-group">
                <div class="card">
                    <a href="<?= site_url('dashboard/physicians') ?>" class="card-link text-dark">
                        <div class="card-body">
                            <h4 class="text-right text-success"><i class="fa fa-user"></i></h4>
                            <div>
                                <strong class="mr-1"><?= $doctors_count ?></strong> Physicians
                            </div>
                        </div>
                        <div class="card-footer">
                            <small><?= $inactive_doctors_count ?> are inactive</small>
                        </div>
                    </a>
                </div>
                <div class="card card-body">
                    <a href="<?= site_url('dashboard/facilities') ?>" class="card-link text-dark">
                        <h4 class="text-right text-success"><i class="fa fa-medkit"></i></h4>
                        <div class="mb-5">
                            <strong class="mr-1"><?= $hospital_facilities_count ?></strong> Facilities
                        </div>
                    </a>
                </div>
                <div class="card card-body">
                    <a href="<?= site_url('dashboard/photos') ?>" class="card-link text-dark">
                        <h4 class="text-right text-success"><i class="fa fa-images"></i></h4>
                        <div>
                            <strong class="mr-1"><?= $images_count ?></strong> Photos
                        </div>
                        <?php $perc = ($images_count/$upload_limit)*100 ?>
                        <div class="progress <?= ($perc < 80) ? 'progress-primary' : 'progress-danger' ?> mt-4">
                            <div class="progress-bar" style="width:<?= $perc ?>%"></div>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="text-muted my-3">Recent Physicians</div>
            <div class="list-group list-group-flush">
                <?php foreach ($doctors as $key => $doctor): ?>
                <?php $docName = $doctor['first_name'].' '.$doctor['last_name'].'&nbsp' ?>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-3 col-md-2 p-0">
                                <a href="<?php echo site_url('physicians/'.$doctor['reg_no'].'/'.url_title($docName)) ?>">
                                    <img src="<?= base_url('image/'.$doctor['avatar']) ?>" alt="" class="img-fluid">
                                </a>
                            </div>
                            <div class="col-9 col-md-10 py-1 pr-1">
                                <a href="<?php echo site_url('physicians/'.$doctor['reg_no'].'/'.url_title($docName)) ?>">
                                    <?= $docName ?>
                                </a>
                                <div class="text-muted small"><?= $doctor['speciality'] ?></div>
                                <div class="text-muted small"><?= $doctor['location'] ?></div>
                                <div class="text-muted mt-1 small">
                                    <span class="badge badge-secondary"><?= $doctor['appointments'] ?></span> Appointments
                                </div>
                                <?php if($doctor['is_mobile']): ?>
                                <div class="text-right text-muted small mt-2 mt-md-0">Offers mobile services</div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    About
                    <a href="<?= site_url('dashboard/profile') ?>" class="btn btn-sm btn-outline-primary float-right">Edit</a>
                </div>
                <?php if (1 == 0): ?>
                <div class="border">
                    <div id="map" style="height: 200px"></div>
                    <script>
                        function initMap() {
                            // Location geo-codes
                            var myLatLng = <?= json_encode(array(
                                'lat' => intval($hospital['latitude']),
                                'lng' => intval($hospital['longitude']),
                                )) ?>;
                            // Create a map object and specify the DOM element for display.
                            var map = new google.maps.Map(document.getElementById('map'), {
                                center: myLatLng,
                                zoom: 5
                            });
                            // Marker to indicate location on the map.
                            var marker = new google.maps.Marker({
                                position: myLatLng,
                                map: map,
                                title: "<?= $hospital['name'] ?>"
                            });
                        }
                    </script>
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZaE9sXlm3yQvvXb8giZF6tRQ1VpQqDaI&callback=initMap" async defer></script>
                </div>
                <?php endif ?>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td style="max-width:50px"><i class="mt-2 text-muted fa fa-map"></i></td>
                            <td>
                                <div class=""><?= $hospital['address'] ?></div>
                                <div class="text-muted"><?= $hospital['location_name'] ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="max-width:50px"><i class="mt-1 text-muted fa fa-envelope"></i></td>
                            <td>
                                <div class=""><?= $hospital['email'] ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="max-width:50px"><i class="mt-1 text-muted fa fa-phone"></i></td>
                            <td>
                                <div class=""><?= $hospital['phone'] ?></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php $this->load->view('public/templates/footer') ?>