</div>

<footer class="main-footer py-5">
    <hr>
    <div class="container clearfix">
        <?php $app = $this->app->config() ?>
        <span class="float-left">
            <?= date('Y').' &copy; '.$app['site_name'] ?>
        </span>
        <span class="float-right">
            <b>Version</b> 3.0
        </span>
    </div>
</footer>

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

    <?php if (!empty($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script type="text/javascript" src="<?php echo base_url($script) ?>"></script>
        <?php endforeach ?>
    <?php endif ?>
</body>
</html>