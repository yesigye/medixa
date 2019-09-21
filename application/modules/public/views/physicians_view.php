<?php echo $this->load->view('public/templates/header', array(
	'title' => 'Physicians',
	'link' => 'physicians',
)); ?>

<div class="py-2 bg-white border-bottom shadow-sm" data-toggle="affix">
    <div class="container">
        <div class="row">
            <div class="col-md-4 order-md-2">
                <?php echo form_open(current_url(), 'method="GET"') ?>
                    <div class="input-group border rounded my-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text border-0 bg-white pl-4 pr-0">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                        <input type="text" class="border-0 form-control" placeholder="Search Doctors" name="q" value="<?php echo $this->input->get('q') ?>">
						<input type="submit" class="d-none">
                    </div>
                <?php echo form_close() ?>
			</div>
            <div class="col-md-8 order-md-1">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item py-1 dropdown">
                                <a class="nav-link p-0 mr-md-4 dropdown-toggle" href="#" id="filter-specs" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <strong><?php echo lang('menu_specialities') ?>:</strong> <?php echo $fliterOptions['speciality']['active'] ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="filter-specs">
									<?php foreach ($fliterOptions['speciality']['options'] as $item): ?>
									<a class="dropdown-item <?= $item['isActive'] ? 'active' : '' ?>" href="<?= $item['link'] ?>">
										<?= $item['name'] ?>
									</a>
									<?php endforeach ?>
                                </div>
							</li>
						</ul>

                        <ul class="navbar-nav ml-auto">
							<li class="nav-item py-1 dropdown">
								<a class="nav-link p-0 mr-md-4 dropdown-toggle" href="#" id="filter-sort" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<strong>Sort:</strong> Newly Listed
								</a>
								<div class="dropdown-menu" aria-labelledby="filter-sort">
									<a class="dropdown-item active" href="#">Newly Listed</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#"><i class="fa fa-map-pin mr-1"></i> Nearest to me</a>
								</div>
							</li>
							<li class="nav-item py-1 dropdown">
								<a class="nav-link p-0 mr-md-4 dropdown-toggle" href="#" id="filter-view" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<strong>View:</strong> <?= ($cardsType === 'tile') ? 'Cards' : 'List' ?>
								</a>
								<div class="dropdown-menu" aria-labelledby="filter-view">
									<a class="dropdown-item <?= ($cardsType === 'tile') ? 'active' : '' ?>" href="<?= $linkToggleTile ?>">
										<i class="fa fa-th-large mr-2"></i> Cards
									</a>
									<a class="dropdown-item <?= ($cardsType === 'list') ? 'active' : '' ?>" href="<?= $linkToggleList ?>">
										<i class="fa fa-th-list mr-2"></i> List
									</a>
								</div>
							</li>
						</ul>
                    </div>
                </nav>
            </div>
		</div>
    </div>
</div>

<div class="container mt-4">
	<?php $this->load->view('alert') ?>

	<?php if (!$doctors AND $_SERVER['QUERY_STRING']): ?>
		<div class="text-muted py-5 h5">
			Your filtering options returned no results.
			<?= anchor(site_url('physicians'), 'See all doctors', 'class="alert-link"') ?>
		</div>
	<?php else: ?>
		<?php $this->load->view('public/templates/doctors_cards', ['doctors' => $doctors]) ?>
	<?php endif ?>

	<?php echo $this->pagination->create_links() ?>
</div>

<?php
$scripts = [
    '<script src="'.base_url('assets/js/affix.js').'"></script>',
];

$this->load->view('public/templates/footer', [ 'scripts' => $scripts ])
?>