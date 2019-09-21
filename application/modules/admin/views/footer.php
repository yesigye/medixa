        </div>

        <footer class="main-footer py-5">
            <hr>
            <div class="container clearfix">
                <span class="float-left">
                    <?= date('Y').' &copy; '.$this->app->name ?>
                </span>
                <span class="float-right">
                    <b>Version</b> 3.0
                </span>
            </div>
        </footer>
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jasny-bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <?php if (!empty($scripts)): ?>
        <?php foreach ($scripts as $script) { echo $script; } ?>
    <?php endif ?>
</body>
</html>