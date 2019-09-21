<?php echo $this->load->view('public/templates/header', array(
	'title' => 'Hospitals',
	'link' => 'hospitals',
)); ?>


<!-- Nav tabs -->
<div class="bg-white py-2 shadow~" data-toggle="affix">
    <div class="container">
        <div class="row">
            <div class="col-md-4 order-md-2">
                <input type="text" class="my-2 form-control form-control-lg" placeholder="Search for a hospital">
            </div>
            <div class="col-md-8 order-md-1">
                <ul class="nav horizontal-scroll mt-md-2 md-shadow" id="filter-tabs" role="tablist">
                    <li class="nav-item scroll-item">
                        <div class="media text-left pl-0">
                            <i class="fa fa-user-md mr-2 mt-2"></i>
                            <div class="media-body">
                                <div class=""><?php echo lang('menu_specialities') ?></div>
                                <a class="nav-link p-0" id="home-tab" href="#tab-filter-specialties">
                                    <div class="small"><?php echo $filter_options['speciality']['active'] ?> <i class="fa fa-caret-down float-right ml-1"></i></div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item scroll-item ml-3">
                        <div class="media text-left pl-0">
                            <i class="fa fa-h-square mr-2 mt-2"></i>
                            <div class="media-body">
                                <div class=""><?php echo lang('menu_types') ?></div>
                                <a class="nav-link p-0" id="home-tab" href="#tab-filter-types">
                                    <div class="small"><?php echo $filter_options['type']['active'] ?> <i class="fa fa-caret-down float-right ml-1"></i></div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item scroll-item ml-3">
                        <div class="media text-left pl-0">
                            <i class="fa fa-bed mr-2 mt-2"></i>
                            <div class="media-body">
                                <div class=""><?php echo lang('menu_facilities') ?></div>
                                <a class="nav-link p-0" id="home-tab" href="#tab-filter-facilities">
                                    <div class="small"><?php echo $filter_options['facilities']['active'] ?> <i class="fa fa-caret-down float-right ml-1"></i></div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item scroll-item ml-3">
                        <div class="media text-left pl-0">
                            <i class="fa fa-map-marker mr-2 mt-2"></i>
                            <div class="media-body">
                                <div class=""><?php echo lang('menu_location') ?></div>
                                <a class="nav-link p-0" id="locate-me" href="#tab-filter-location">
                                    <div class="small">
                                        <?php echo $filter_options['location']['active'] ?>
                                        <i class="fa fa-caret-down float-right ml-1"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
	</div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane bg-light py-4" role="tabpanel" id="tab-filter-specialties">
            <div class="container form-inline">
                <?php foreach ($filter_options['speciality']['options'] as $item): ?>
                <a class="card card-body mr-3 p-2 <?= $item['isActive'] ? 'bg-secondary text-white' : '' ?>" href="<?= $item['link'] ?>">
                    <?= $item['name'] ?>
                </a>
                <?php endforeach ?>
            </div>
        </div>
        <div class="tab-pane bg-light py-4" role="tabpanel" id="tab-filter-types">
            <div class="container form-inline">
                <?php foreach ($filter_options['type']['options'] as $item): ?>
                <a class="card card-body mr-3 p-2 <?= $item['isActive'] ? 'bg-secondary text-white' : '' ?>" href="<?= $item['link'] ?>">
                    <?= $item['name'] ?>
                </a>
                <?php endforeach ?>
            </div>
        </div>
        <div class="tab-pane bg-light py-4" role="tabpanel" id="tab-filter-facilities">
            <div class="container form-inline">
                <?php foreach ($filter_options['facilities']['options'] as $item): ?>
                <a class="card card-body mr-3 p-2 <?= $item['isActive'] ? 'bg-secondary text-white' : '' ?>" href="<?= $item['link'] ?>">
                    <?= $item['name'] ?>
                </a>
                <?php endforeach ?>
            </div>
        </div>
        <div class="tab-pane bg-light py-4" role="tabpanel" id="tab-filter-location">
            <div class="container mt-2">
                <div class="form-inline d-flex justify-content-center">
                    <div class="input-group">
                        <?php foreach($location_fields as $field) {
                            echo form_dropdown($field['name'], $field['options'], [], 'id="'.$field['code'].'" class="custom-select" style="width:auto"');
                        } ?>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" name="search" value="search"><?php echo lang('btn_submit') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Nav tabs -->
<div class="bg-white border-bottom py-1 shadow text-center" data-toggle="affix">
	<div class="container mt-2">
		<div class="form-inline d-flex justify-content-center">
			<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text" id="btnGroupAddon"><i class="fa fa-search"></i></div>
					</div>
					<?= form_open($page_url, 'method="GET"') ?>
					<input type="text" name="query" class="form-control rounded-0" placeholder="Type Keywords" value="<?php echo $this->input->get('q') ?>">
					<?= form_close() ?>
				<?php foreach($location_fields as $field) {
					echo form_dropdown($field['name'], $field['options'], [], 'id="'.$field['code'].'" class="custom-select" style="width:auto"');
				} ?>
				<div class="input-group-append">
					<button class="btn btn-primary" type="button" name="search" value="search"><?php echo lang('btn_submit') ?></button>
				</div>
			</div>

		</div>

		<ul class="nav horizontal-scroll" id="filter-tabs" role="tablist">
			<li class="nav-item scroll-item">
				<div class="nav-link media text-left pl-0">
					<i class="fa fa-user-md mr-3 mt-2"></i>
					<div class="media-body">
						<div class=""><?php echo lang('menu_specialities') ?></div>
						<a class="nav-link p-0" id="home-tab" href="#tab-filter-specialties">
							<div class="small"><?php echo $fliterOptions['speciality']['active'] ?> <i class="fa fa-caret-down float-right ml-1"></i></div>
						</a>
					</div>
				</div>
			</li>
			<li class="nav-item scroll-item ml-3">
				<div class="nav-link media text-left pl-0">
					<i class="fa fa-h-square mr-3 mt-2"></i>
					<div class="media-body">
						<div class=""><?php echo lang('menu_types') ?></div>
						<a class="nav-link p-0" id="home-tab" href="#tab-filter-types">
							<div class="small">dentists <i class="fa fa-caret-down float-right ml-1"></i></div>
						</a>
					</div>
				</div>
			</li>
			<li class="nav-item scroll-item ml-3">
				<div class="nav-link media text-left pl-0">
					<i class="fa fa-bed mr-3 mt-2"></i>
					<div class="media-body">
						<div class=""><?php echo lang('menu_facilities') ?></div>
						<a class="nav-link p-0" id="home-tab" href="#tab-filter-facilities">
							<div class="small">dentists <i class="fa fa-caret-down float-right ml-1"></i></div>
						</a>
					</div>
				</div>
			</li>
			<li class="nav-item scroll-item ml-3">
				<div class="nav-link media text-left pl-0">
					<i class="fa fa-map-marker mr-3 mt-2"></i>
					<div class="media-body">
						<div class=""><?php echo lang('menu_location') ?></div>
						<a class="nav-link p-0" id="locate-me" href="#tab-filter-location">
							<div class="small">Nearest to me <i class="fa fa-caret-down float-right ml-1"></i></div>
						</a>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>

<div class="container">

	<?php $this->load->view('alert') ?>
	
	<div class="row my-3">
		<div class="col-md-9 py-3">
			<?= $resultStart ?> - <?= $resultEnd ?> of <?= $resultTotal ?> results
		</div>
		<div class="col-md-3">
			<a href="<?php echo $linkToggleContainer ?>" class="card card-body p-0">
				<h1 class="text-center m-0"><i class="fa fa-map"></i></h1>
				<!-- <img src="<?php echo base_url('assets/images/map.png') ?>" class="img-fluid" style="height:50px"> -->
			</a>
		</div>
	</div>

	<?php if (!$hospitals AND $_SERVER['QUERY_STRING']): ?>
		<hr>
		<div class="text-muted py-5 h5 border-0">
			Sorry, No results matched your filtering options.
		</div>
	<?php else: ?>
		<?php $this->load->view('public/templates/hospitals_cards', ['hospitals' => $hospitals]) ?>
	<?php endif ?>

	<?php echo $this->pagination->create_links() ?>
</div>

<?php $this->load->view('public/templates/footer') ?>