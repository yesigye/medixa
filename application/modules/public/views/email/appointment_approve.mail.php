<?php $this->load->view('emails/email_header') ?>

<p>Hello <?php echo $recipient->first_name ?>!</p>

<p>
	Your appointment with <?php echo $sender['speciality'] ?>
	<?php echo anchor('practitioners/'.$sender['reg_no'], $sender['first_name'].' '.$sender['last_name']) ?>
	was approved. <br>
	You can review appointment details
	<a href="<?php $redirect ?>" style="color:#0084b4;text-decoration:none" target="_blank"> on our website. </a>
</p>

<?php $this->load->view('emails/email_footer') ?>