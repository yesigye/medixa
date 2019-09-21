<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewp||t">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ"
    crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jasny-bootstrap.min.css') ?>">
    <?php if (!empty($styles)) foreach ($styles as $style) echo $style ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">

    <title><?php echo lang('dash_title').(isset($title) ? ' - '.$title : '') ?></title>
</head>

<?php
// Links to show active pages
if (!isset($breadcrumb)) $breadcrumb = array();
if (!isset($active)) $active = NULL;
$link = (isset($link)) ? $link : null;
$sub_link = (isset($sub_link)) ? $sub_link : null;
?>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo site_url('admin') ?>"> <?php echo $this->app->name ?> </a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item <?php if($link=='users') echo 'active' ?>">
                    <a class="nav-link" href="<?php echo site_url('admin/users') ?>">
                        <?php echo lang('menu_users') ?>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Catalog
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-item text-muted"> <i class="fa fa-shopping-cart mr-2"></i> Products </div>
                        <a class="dropdown-item" href="#">Manage products</a>
                        <a class="dropdown-item" href="#">Add a new product</a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item text-muted"> <i class="fa fa-th-list mr-2"></i> Categories </div>
                        <a class="dropdown-item" href="#">Manage products</a>
                        <a class="dropdown-item" href="#">Add a new product</a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if($link == 'orders' || $link == 'zones' || $link == 'locations') echo 'active' ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sales
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-item text-muted"> <i class="fa fa-briefcase mr-2"></i> Orders </div>
                        <a class="dropdown-item <?php if($link == 'orders' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/orders') ?>">Manage orders</a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item text-muted"> <i class="fa fa-shipping-fast mr-2"></i> Shipping </div>
                        <a class="dropdown-item <?php if($link == 'locations' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/location_types') ?>">Manage locations</a>
                        <a class="dropdown-item <?php if($link == 'zones' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/zone') ?>">Location Zones</a>
                        <a class="dropdown-item <?php if($link == 'shipping' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/shipping') ?>">Manage shipping rules</a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item text-muted"> <i class="fa fa-money-bill mr-2"></i> Taxes </div>
                        <a class="dropdown-item <?php if($link == 'tax' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/tax') ?>">Manage taxes</a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if($link == 'discounts' || $link == 'reward_points') echo 'active' ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Promotions
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-item text-muted"> <i class="fa fa-tags mr-2"></i> Discounts </div>
                        <a class="dropdown-item <?php if($link == 'discounts' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/item_discounts') ?>">Item discounts</a>
                        <a class="dropdown-item <?php if($link == 'discounts' && $sub_link == 'groups') echo 'active' ?>" href="<?php echo site_url('admin/discount_groups') ?>">Discounts groups</a>
                        <a class="dropdown-item <?php if($link == 'discounts' && $sub_link == 'summary') echo 'active' ?>" href="<?php echo site_url('admin/summary_discounts') ?>">Summary discounts</a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item text-muted"> <i class="fa fa-gift mr-2"></i> Vouchers </div>
                        <a class="dropdown-item <?php if($link == 'reward_points' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/user_reward_points') ?>">User Reward Points</a>
                        <a class="dropdown-item <?php if($link == 'reward_points' && $sub_link == 'vouchers') echo 'active' ?>" href="<?php echo site_url('admin/vouchers') ?>">User Reward Vouchers</a>
                    </div>
                </li>
                <li class="nav-item dropdown <?php if($link == 'extras') echo 'active' ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Frontend
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item <?php if($link == 'extras' && $sub_link == 'pages') echo 'active' ?>" href="<?php echo site_url('admin/pages') ?>">Manage pages</a>
                        <a class="dropdown-item <?php if($link == 'extras' && $sub_link == 'banners') echo 'active' ?>" href="<?php echo site_url('admin/banners') ?>">Manage banners</a>
                    </div>
                </li>
            </ul>
            
            <ul class="navbar-nav ml-auto d-flex nav-icons">
                <li class="nav-item">
                    <a class="nav-link <?php if($link == 'settings') echo 'active' ?>" href="<?php echo site_url('admin/settings') ?>">
                        <i class="fa fa-cog"></i> <?php echo lang('menu_settings') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="<?php echo site_url('admin/logout') ?>">
                        <i class="fa fa-sign-out-alt"></i> <?php echo lang('menu_logout') ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container pt-1">
    <nav aria-label="breadcrumb" class="bg-none breadcrumb mb-1 px-0 d-flex justify-content-between">
        <div class="font-weight-bold text-uppercase">
            <?php echo (isset($pageTitle)) ? $pageTitle : 'Dashboard' ?>
            <?php echo (isset($pageSubTitle)) ? '<span class="text-muted small ml-2">'.$pageSubTitle.'</span>' : '' ?>
        </div>  
    
        <ol class="breadcrumb bg-none p-0 m-0">
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin') ?>"><?php echo lang('dash_title') ?></a></li>
            
            <?php if(!empty($breadcrumb)): ?>
                <?php foreach($breadcrumb as $nav): ?>
                    <li class="breadcrumb-item <?php echo $nav['link'] ? null : 'active' ?>">
                        <?php echo ($nav['link']) ? anchor($nav['link'], $nav['name']) : $nav['name'] ?>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
        </ol>
    </nav>

    <div id="app-notif">
        <?php $this->load->view('alert') ?>
    </div>
<?php // $this->load->view('headers') ?>