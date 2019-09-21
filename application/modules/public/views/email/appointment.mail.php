<?php $this->load->view('emails/email_header') ?>

<p>
	Hello <?php echo $recepient ?>!
	<br>
	<?= $this->app->user('first_name') ?> has requested for an appointment.
</p>
<p><?= $message ?></p>
You can review the appointment details
<a href="<?php echo site_url('appointments') ?>" style="color:#0084b4;text-decoration:none" target="_blank"> in your dashboard. </a>

<?php $this->load->view('emails/email_footer') ?>