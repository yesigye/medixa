<?php $this->load->view('public/templates/header', array(
    'link' => 'error',
)) ?>

<div class="container">

    <?php $this->load->view('alert') ?>

    <div class="row">
        <div class="col-md-9">
            <h1 class="page-header text-muted my-5">
                <span class="glyphicon glyphicon-ban-circle" style="margin-right:5px;position:relative;top:0.5rem;"></span> Page Not Found
            </h1>
            <h4 class="lead mb-5">
                <p>Sorry but we could not find the page your are looking for.</p>
                <p>The link to this page may be incorrect or incomplete or the page might have been removed.</p>
                Try the <?= anchor('search', 'advanced search') ?> page or use the navigation links in the header to continue browsing.
            </h4>
        </div>
        <h1 class="col-md-3">
            <img src="<?php echo base_url('assets/images/404.svg') ?>" alt="" class="img-fluid mt-5">
        </h1>
    </div>
</div>

<?php $this->load->view('public/templates/footer') ?>