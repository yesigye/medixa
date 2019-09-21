<?php $this->load->view('emails/email_header') ?>

<p>Hello <?php echo $recipient['username'] ?>!</p>

<p>
	Sorry, your appointment with <?php echo $sender['speciality'] ?>
	<?php echo anchor('practitioners/'.$sender['reg_no'], $sender['first_name'].' '.$sender['last_name']) ?>
	was cancelled. <br>
</p>

<?php $this->load->view('emails/email_footer') ?>