<?php

if(!isset($title)) $title = '';
if(!isset($link)) $link = '';

?>
<!DOCTYPE html>
<html class="h-100">
<head>
    <title><?= $this->app->name.($title ? ' - '.$title : null) ?></title>
    <link rel="shortcut icon" href="<?= base_url($this->app->logo) ?>" type="image/png" />
    <link rel="shortcut icon" href="<?= base_url($this->app->logo) ?>" type="image/png" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/jquery-ui/jquery-ui.structure.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/jquery-ui/jquery-ui.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/jquery-ui/jquery-ui.theme.min.css') ?>">
    <!-- Font awesome icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ"
    crossorigin="anonymous">
    <!-- Custom CSS. -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jasny-bootstrap.min.css') ?>">
    <!-- Google Roboto Font Style -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400" rel="stylesheet">

    <?php if (!empty($styles)): ?>
    <?php foreach ($styles as $style) { echo $style; } ?>
    <?php endif ?>

    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
</head>

<body class="bg-white h-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-2 border-bottom">
        <div class="container">
            <button class="navbar-toggler mr-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <a class="navbar-brand mr-auto" href="<?php echo site_url() ?>">
                <img class="mr-2" alt="Brand" src="<?php echo base_url($this->app->logo) ?>">
                <?php echo $this->app->name ?>
            </a>

            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url().'#how-it-works' ?>">How it works</a>
                    </li>
                    <li class="nav-item <?php if($link == 'physicians') echo 'active' ?>">
                        <a class="nav-link" href="<?php echo site_url('doctors') ?>"><?php echo lang('menu_doctors') ?></a>
                    </li>
                    <li class="nav-item <?php if($link == 'hospitals') echo 'active' ?>">
                        <a class="nav-link" href="<?php echo site_url('hospitals') ?>"><?php echo lang('menu_hospitals') ?></a>
                    </li>
                    <?php if ($this->app->user()): ?>
                    <?php $this->load->library('public/notifications') ?>
                    <?php $notifications = $this->notifications->appointments() ?>
                    <li role="presentation" class="nav-item dropdown <?php echo ($notifications) ? 'open' : '' ?>">
                        <a class="nav-link" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                            <span style="position: relative;top: -6px;left: -4px;"
                            class="badge badge-<?=($notifications) ? 'success' : 'secondary' ?>"><?= count($notifications) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right mt-2 notification">
                            <?php if ($notifications): ?>
                                <?php foreach ($notifications as $notification): ?>
                                    <a class="dropdown-item" href="<?= site_url($notification['link']) ?>">
                                        <?= $notification['message'] ?>
                                    </a>
                                <?php endforeach ?>
                                <div role="separator" class="divider"></div>
                                <a class="dropdown-item text-center text-danger" href="">Clear</a>
                            <?php else: ?>
                                <li class="alert text-center text-muted m-0">
                                    No notifications
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                    
                    <li role="presentation" class="nav-item dropdown <?php echo ($link === 'account') ? 'active' : '' ?>">
                        <a class="nav-link" data-toggle="dropdown">
                            <?php if($this->app->user('thumbnail')): ?>
                                <img src="<?= base_url('image/'.$this->app->user('thumbnail')) ?>" class="rounded-circle" width="24">
                            <?php else: ?>
                                <i class="fa fa-user text-info"></i>
                            <?php endif ?>
                            <?= $this->app->user('first_name') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right mt-2">
                            <?php if ($this->ion_auth->in_group('manager')): // User links for managers ?>
                            <a href="<?= site_url('dashboard') ?>" class="dropdown-item <?= ($link === 'dashboard') ? 'active' : null ?>">
                                Dashboard
                            </a>
                            <?php endif ?>
                            <a href="<?= site_url('profile') ?>" class="dropdown-item <?= ($link === 'profile') ? 'active' : null ?>">
                                <i class="fa fa-user text-muted mr-1"></i> Profile
                            </a>
                            <a href="<?= site_url('appointments') ?>" class="dropdown-item <?= ($link === 'appointments') ? 'active' : null ?>">
                                <i class="fa fa-calendar text-muted mr-1"></i> Appointments
                            </a>
                            <li role="separator" class="divider"></li>
                            <a href="<?= site_url('logout') ?>" class="dropdown-item text-danger">
                                <i class="fa fa-sign-out-alt text-danger mr-1"></i> Logout
                            </a>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item <?php if($link == 'login') echo 'active' ?>">
                        <a class="nav-link" href="<?php echo site_url('login') ?>">Login</a>
                    </li>
                    <li class="nav-item <?php if($link == 'register') echo 'active' ?>">
                        <a href="<?= site_url('register') ?>" class="btn btn-block btn-outline-primary">
                            Register
                        </a>
                    </li>
                    <?php endif ?>
                </ul>
            </div>
            
        </div>
    </nav>

    <?php
    if (empty($pageTitle)) $pageTitle = [];
    if (empty($breadcrumb)) $breadcrumb = [];
    
    if($pageTitle || isset($pageSubTitle) || $breadcrumb):
    ?>
    <div class="container mt-2">
        <nav aria-label="breadcrumb" class="bg-none breadcrumb px-0 d-flex justify-content-between">
            <span class="page-header d-none d-sm-block">
            <?= (isset($pageTitle)) ? $pageTitle : ''; ?>
            <?= (isset($pageSubTitle)) ? '<span class="text-muted small ml-2">'.$pageSubTitle.'</span>' : ''; ?>
            </span>
            <?php // Breadcrumbs for pages ?>
            <?php if (!empty($breadcrumb)): ?>
                <ol class="breadcrumb bg-none pt-2 pb-0 m-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Home</a></li>
                    <?php foreach($breadcrumb as $nav): ?>
                    <li class="breadcrumb-item <?= $nav['link'] ? null : 'active' ?>">
                        <?php if($nav['link']): ?>
                            <a href="<?= site_url($nav['link']) ?>"><?= $nav['name'] ?></a>
                        <?php else: ?>
                            <?= $nav['name'] ?>
                        <?php endif ?>
                    </li>
                    <?php endforeach ?>
                </ol>
            <?php endif ?>
        </nav>
    </div>
    <?php endif; ?>

    <?php if ( isset($page['title']) ): ?>
        <div class="container">
            <div class="lead page-header">
                <?= isset($page['title']) ? $page['title'] : '' ?>
                <?= isset($page['sub_title']) ? '<h4><small>'.$page['sub_title'].'</small></h4>' : '' ?>
                <?= isset($page['sub_title_right']) ? '<h4 class="pull-right"><small>'.$page['sub_title_right'].'</small></h4>' : '' ?>
            </div>
        </div>
    <?php endif ?>

    <div class="body" style="min-height:80%">