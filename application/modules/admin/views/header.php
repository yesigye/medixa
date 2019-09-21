<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
	<div id="wrapper" class="">
    
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <a class="sidebar-brand" href="<?php echo site_url('admin') ?>"> <?php echo $this->app->name ?> </a>
        <ul class="accordion sidebar-nav" id="main-accordion">
            <li id="headingOne">
                <a class="" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="fa fa-user"></i> <?php echo lang('menu_users_th') ?> <span class="caret"></span>
                </a>

                <div id="collapseOne" class="collapse <?php if ($link=='users') echo 'show' ?>" aria-labelledby="headingOne" data-parent="#main-accordion">
                    <nav class="nav flex-column">
                        <a class="nav-link <?php if ($link=='users') echo 'active' ?>" href="<?php echo site_url('admin/users') ?>">
                            <i class="fa fa-user"></i> <?php echo lang('menu_users') ?>
                        </a>
                        <a class="nav-link <?php if ($link=='groups') echo 'active' ?>" href="<?php echo site_url('admin/users/groups') ?>">
                            <i class="fa fa-users"></i> <?php echo lang('menu_groups') ?>
                        </a>
                    </nav>
                </div>
            </li>

            <li id="headingTwo">
                <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-hospital"></i> <?php echo lang('menu_hospitals_th') ?> <span class="caret"></span>
                </a>

                <div id="collapseTwo" class="collapse <?php if ($link=='hospitals') echo 'show' ?>" aria-labelledby="headingTwo" data-parent="#main-accordion">
                    <nav class="nav flex-column">
                        <a class="nav-link <?php if ($link=='hospitals' && $sub_link == '') echo 'active' ?>" href="<?php echo site_url('admin/hospitals') ?>">
                            <i class="fa fa-h-square"></i> <?php echo lang('menu_hospitals') ?>
                        </a>
                        <a class="nav-link <?php if ($link=='hospitals' && $sub_link == 'specialities') echo 'active' ?>" href="<?php echo site_url('admin/hospitals/specialities') ?>">
                            <i class="fa fa-user-md"></i> <?php echo lang('menu_specialities') ?>
                        </a>
                        <a class="nav-link <?php if ($link=='hospitals'  && $sub_link == 'types') echo 'active' ?>" href="<?php echo site_url('admin/hospitals/types') ?>">
                            <i class="fa fa-th"></i> <?php echo lang('menu_types') ?>
                        </a>
                        <a class="nav-link <?php if ($link=='hospitals'  && $sub_link == 'facilities') echo 'active' ?>" href="<?php echo site_url('admin/hospitals/facilities') ?>">
                            <i class="fa fa-bed"></i> <?php echo lang('menu_facilities') ?>
                        </a>
                    </nav>
                </div>
            </li>

            <li id="heading3">
                <a class="nav-link <?php if ($link=='locations') echo 'active' ?>" href="<?php echo site_url('admin/locations') ?>">
                    <i class="fa fa-map-marker"></i> <?php echo lang('menu_locations_th') ?>
                </a>
            </li>
            <li id="heading3">
                <a class="nav-link <?php if ($link=='appointments') echo 'active' ?>" href="<?php echo site_url('admin/appointments') ?>">
                    <i class="fa fa-calendar"></i> <?php echo lang('menu_appointments') ?>
                </a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <button class="navbar-toggler d-show d-md-none mr-3" id="menu-toggle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <span class="navbar-text mr-auto">
                <?php echo $this->lang->line('dash_welcome_msg', anchor('admin/users/edit/1', $this->app->user('username'))) ?>
            </span>
            <div class="navbar-nav" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto d-flex nav-icons" style="flex-direction: row;">
                    <li class="nav-item dropdown">
                        <a class="nav-link <?php if ($link=='settings' OR $link=='languages') echo 'text-dark' ?> dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog" data-toggle="tooltip" title="<?php echo lang('menu_settings') ?>"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item <?php if($link=="profile") echo 'active' ?>" href="<?php echo site_url('admin/profile') ?>" >
                                <?php echo lang('menu_profile') ?>
                            </a>
                            <a class="dropdown-item <?php if($link=="settings") echo 'active' ?>" href="<?php echo site_url('admin/settings') ?>" >
                                <?php echo lang('menu_general') ?>
                            </a>
                            <a class="dropdown-item <?php if($link=="languages") echo 'active' ?>" href="<?php echo site_url('admin/settings/languages') ?>">
                                <?php echo lang('menu_languages') ?>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item ml-1">
                        <a class="nav-link" href="<?php echo site_url('admin/logout') ?>">
                            <i class="fa fa-sign-out-alt text-danger" data-toggle="tooltip" title="<?php echo lang('menu_logout') ?>"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <nav aria-label="breadcrumb" class="bg-none breadcrumb mb-1 px-0 d-flex justify-content-between">
                <h5 class="page-header">
                    <?php echo (isset($pageTitle)) ? $pageTitle : 'Dashboard' ?>
                    <?php echo (isset($pageSubTitle)) ? '<span class="text-muted small ml-2">'.$pageSubTitle.'</span>' : '' ?>
                </h5>  
            
                <ol class="breadcrumb bg-none pt-1 pb-2 px-0 m-0">
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