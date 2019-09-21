<?php
// Alert users to changes and notifications
$alert = $this->app->getAlert();
?>

<?php if (!empty($alert)): ?>
	
    <?php
    // Define the icon for the alert message.
    // This template assumes you use bootstrap and font awesome icons
	if ($alert['type'] === 'success') {
        // icon for success alerts
		$icon = '<i class="fa fa-check-circle mr-2"></i>';
    }
	else if($alert['type'] === "warning") {
        // icon for warning alerts
		$icon = '<i class="fa fa-warning mr-2"></i>';
    }
	else if($alert['type'] === "danger") {
        // icon for danger alerts
		$icon = '<i class="fa fa-exclamation-circle mr-2"></i>';
    }
	else {
        // default icon for alerts
		$icon = '<i class="fa fa-info-circle mr-2"></i>';
    }
	?>

	<div class="alert alert-<?= $alert['type'] ?> alert-msg text-left">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only">Close</span>
		</button>
		<?= $icon.$alert['message'] ?>
        
        <?php
        // for alerts that are not warnings or danger,
        // Use javascript to remove alert after a few seconds
        if ($alert['type'] != 'warning' && $alert['type'] != 'danger'):
        ?>
            <script type="text/javascript">
                setTimeout(function(){
                    $('.alert-msg').addClass('fadeOutUp');
                }, 5000)
                setTimeout(function(){
                    $('.alert-msg').remove();
                }, 5500)
            </script>
        <?php endif ?>
	</div>

<?php endif ?>
<?php // End of alerts ?>