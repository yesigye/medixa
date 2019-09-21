<?php
$styles = [];

if($viewType == 'map') {
    array_push($styles, '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>');
}

$this->load->view('public/templates/header', ['link' => 'hospitals', 'styles' => $styles ])
?>

<div class="py-2 bg-white border-bottom shadow-sm" data-toggle="affix">
    <div class="container">
        <div class="row">
            <div class="col-md-4 order-md-2">
                <form class="">
                    <div class="input-group border rounded my-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text border-0 bg-white pl-4 pr-0">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                        <input type="text" class="border-0 form-control" placeholder="Search">
                    </div>
                </form>
            </div>
            <div class="col-md-8 order-md-1">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item py-2 dropdown">
                                <a class="nav-link p-0 mr-md-4 dropdown-toggle" href="#" id="filter-specs" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo lang('menu_specialities') ?>
                                </a>
                                <div class="small text-muted"><?php echo $filter_options['speciality']['active'] ?></div>
                                <div class="dropdown-menu" aria-labelledby="filter-specs">
                                    <?php foreach ($filter_options['speciality']['options'] as $item): ?>
                                    <a class="dropdown-item <?= $item['isActive'] ? 'active' : '' ?>" href="<?= $item['link'] ?>">
                                        <?= $item['name'] ?>
                                    </a>
                                    <?php endforeach ?>
                                </div>
                            </li>
                            <li class="nav-item py-2 dropdown">
                                <a class="nav-link p-0 mr-md-4 dropdown-toggle" href="#" id="filter-types" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo lang('menu_types') ?>
                                </a>
                                <div class="small text-muted"><?php echo $filter_options['type']['active'] ?></div>
                                <div class="dropdown-menu" aria-labelledby="filter-types">
                                    <?php foreach ($filter_options['type']['options'] as $item): ?>
                                    <a class="dropdown-item <?= $item['isActive'] ? 'active' : '' ?>" href="<?= $item['link'] ?>">
                                        <?= $item['name'] ?>
                                    </a>
                                    <?php endforeach ?>
                                </div>
                            </li>
                            <li class="nav-item py-2 dropdown">
                                <a class="nav-link p-0 mr-md-4 dropdown-toggle" href="#" id="filter-facilities" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo lang('menu_facilities') ?>
                                </a>
                                <div class="small text-muted"><?php echo $filter_options['facilities']['active'] ?></div>
                                <div class="dropdown-menu" aria-labelledby="filter-facilities">
                                    <?php foreach ($filter_options['facilities']['options'] as $item): ?>
                                    <a class="dropdown-item <?= $item['isActive'] ? 'active' : '' ?>" href="<?= $item['link'] ?>">
                                        <?= $item['name'] ?>
                                    </a>
                                    <?php endforeach ?>
                                </div>
                            </li>
                            <li class="nav-item py-2 dropdown">
                                <a class="nav-link p-0 mr-md-4 dropdown-toggle" href="#" id="filter-location" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo lang('menu_location') ?>
                                </a>
                                <div class="small text-muted"><?php echo $filter_options['location']['active'] ?></div>
                                <div class="dropdown-menu px-2" aria-labelledby="filter-location">
                                    <?php foreach($location_fields as $field) {
                                        echo form_dropdown($field['name'], $field['options'], [], 'id="'.$field['code'].'" class="custom-select mb-2"');
                                    } ?>
                                    <button class="btn btn-primary btn-block" type="button" name="search" value="search"><?php echo lang('btn_submit') ?></button>
                                    <div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#"><i class="fa fa-map-pin mr-1"></i> Nearest to me</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container"> <?php echo $content ?> </div>


<script js>
document.addEventListener("DOMContentLoaded", function() {
	// Filter tab behaviour
	$('#filter-tabs a').on('click', function (e) {
		e.preventDefault()
		var el_fLink = $(this);
		if(el_fLink.hasClass('active')) {
			el_fLink.removeClass('active')
			$(el_fLink.attr('href')).removeClass('active')
		} else {
			el_fLink.tab('show')
			$.each($('#filter-tabs a'), function(i, el){
				if( ! el_fLink.is(el)) {
					$(el).removeClass('active')
					$($(el).attr('href')).removeClass('active')
				}
			});
		}
    })
    
    $('[data-toggle="affix"]').affix({
        offset:{
            top: $('[data-toggle="affix"]').height() 
        }
    })
})
</script>

<?php
$scriptcode = '<script>';
foreach ($locationTypes as $key => $type) {
    if ($key !== 0) {
        $scriptcode .= '
        $("#'.$type['code'].'").remoteChained({
            parents : "#'.$locationTypes[$key-1]['code'].'",
            url : "'.site_url('locations/api/nodes').'"
        });';
    }
}
$scriptcode .= '</script>';
?>


<?php
$scripts = [
    '<script src="'.base_url('assets/js/affix.js').'"></script>',
    '<script src="'.base_url('assets/js/jquery.chained.remote.min.js').'"></script>',
    $scriptcode,
];

if($viewType == 'map') {
    array_push($scripts, '<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>');
}

$this->load->view('public/templates/footer', [ 'scripts' => $scripts ])
?>