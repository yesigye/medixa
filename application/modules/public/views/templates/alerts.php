<?php
// Alert users to changes and notifications
$alert = $this->app->getAlert();
?>

<?php if (isset($alert['type'])): ?>
    <?php
    if ($alert['type'] === 'success')
        $icon = '<span class="fa fa-check-circle" style="margin-right:10px"></span>';
    else if($alert['type'] === "warning")
        $icon = '<span class="fa fa-exclamation-circle" style="margin-right:10px"></span>';
    else if($alert['type'] === "danger")
        $icon = '<span class="fa fa-exclamation-circle" style="margin-right:10px"></span>';
    else
        $icon = '<span class="fa fa-info-circle" style="margin-right:10px"></span>';
    ?>

    <div class="notify alert alert-<?= ($alert['type'] === 'info' ) ? 'secondary' : $alert['type']  ?>">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <?= $icon.$alert['message'] ?>
    </div>

    <?php if ($alert['type'] === 'success' || $alert['type'] === 'warning'): ?>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", alertFade);
            
            function alertFade() {
                setTimeout(function(){
                    $('.alert.notify').addClass('fadeOutUp');
                }, 5000)
                setTimeout(function(){
                    $('.alert.notify').remove();
                }, 5500)
            };
        </script>
    <?php endif ?>
<?php endif ?>