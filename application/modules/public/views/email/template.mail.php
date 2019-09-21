<?php $this->load->view('public/email/email_header') ?>

<p>
	Hello <?php echo $name ?>! <br>
	<?php echo $message ?> <br>
</p>

<p>&nbsp;</p>
<p>Thank you!</p>
<p>
	Regards,<br>
	<?php echo site_url(base_url(), $owner['name']) ?> <br>
	<?php echo $owner['phone'] ?>
</p>

<?php $this->load->view('public/email/email_footer') ?>