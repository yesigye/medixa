<!DOCTYPE html>
<html lang="en">
<head>
	<title>Dashboard <?php if (isset($title)) echo '- '.$title; ?></title>
	<meta charset="utf-8">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo base_url('vendor/bootstrap/css/bootstrap.min.css') ?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css') ?>">
	<!-- Custom CSS. -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
</head>

<?php
$app = $this->app->config();
// Links to show active pages
if (!isset($breadcrumb)) $breadcrumb = array();
if (!isset($active)) $active = NULL;
if (!isset($link)) $link = NULL;
if (!isset($sub_link)) $sub_link = NULL;
?>

<body>
	<div id="wrapper" class="">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    Start Bootstrap
                </a>
            </li>
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li>
                <a href="#">Shortcuts</a>
            </li>
            <li>
                <a href="#">Overview</a>
            </li>
            <li>
                <a href="#">Events</a>
            </li>
            <li>
                <a href="#">About</a>
            </li>
            <li>
                <a href="#">Services</a>
            </li>
            <li>
                <a href="#">Contact</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-light bg-white">
        <button class="navbar-toggler d-show d-md-none" id="menu-toggle">
          <span class="navbar-toggler-icon"></span>
        </button>
        <form class="form-inline d-none d-block-md d-md-block">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search...">
            <span class="mdi mdi-magnify"></span>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">Search</button>
            </div>
          </div>
        </form>

        <div class="navbar-nav flex-row nav-icons">
          <a class="nav-item nav-link" href="#">
            <i class="fa fa-bell"></i>
            <span class="badge badge-danger">2</span>
          </a>
          <a class="nav-item nav-link ml-4" href="#">
            <i class="fa fa-cog"></i>
          </a>
          <a class="nav-item nav-link ml-4" href="#">
            <i class="fa fa-user text-info"></i>
          </a>
        </div>
      </nav>

      <div class="container-fluid">
        <nav aria-label="breadcrumb" class="bg-none breadcrumb mb-1 px-0 d-flex justify-content-between">
          <span class="page-header">
            <?= (isset($pageTitle)) ? $pageTitle : 'Dashboard'; ?>
          </span>  
          <ol class="breadcrumb bg-none pt-2 pb-0 m-0">
              <li class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Home</a></li>
              <?php if(!empty($breadcrumb)): ?>
                <?php foreach($breadcrumb as $nav): ?>
                  <li class="breadcrumb-item <?= $nav['link'] ? null : 'active' ?>">
                    <a href="<?= $nav['link'] ?>"><?= $nav['name'] ?></a>
                  </li>
                <?php endforeach ?>
              <?php endif ?>
            </ol>
        </nav>