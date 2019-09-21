</div>

<footer class="footer mb-0 py-3">
    <div class="container">
        <div class="row mt-3 mb-4">
            <div class="col-md-4 my-3">
                <h4 class="page-title page-header">Support</h4>
                <nav class="nav flex-column">
                    <a class="nav-link pl-0" href="#">Help Center</a>
                </nav>
            </div>
            <div class="col-md-4 my-3">
                <h4 class="page-title page-header">Information</h4>
                <nav class="nav flex-column">
                    <a class="nav-link pl-0" href="<?= site_url('legal/privacy-policy') ?>">Privacy Policy</a>
                    <a class="nav-link pl-0" href="<?= site_url('legal/terms-of-service') ?>">Terms of Service</a>
                </nav>
            </div>
            <div class="col-md-4 my-3">
                <h4 class="page-title page-header">Services</h4>
                <nav class="nav flex-column">
                    <a class="nav-link pl-0" href="<?= site_url('register_org') ?>">Hospital Registration</a>
                    <a class="nav-link pl-0" href="#">Advertisement</a>
                </nav>
            </div>    
        </div>
        <hr class="m-0">
        <div class="mt-4 text-right">
            <small><?= $this->app->name.' &copy '.date('Y') ?>.&nbsp All Rights Reserved</small>
        </div>
    </div>
</footer>

<script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/jquery-ui/jquery-ui.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jasny-bootstrap.min.js') ?>"></script>

<?php if (!empty($scripts)): ?>
<?php foreach ($scripts as $script) { echo $script; } ?>
<?php endif ?>

<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>