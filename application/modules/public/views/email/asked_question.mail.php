<?php $this->load->view('public/email/email_header') ?>

<p>Hello physician!</p>
<p>
	A user has asked a question you may be able to answer. <br>
	You can review question details
	<a href="<?php echo $redirect ?>" style="color:#0084b4;text-decoration:none" target="_blank"> on our website. </a>
</p>

<p>&nbsp;</p>
<p>
	Regards,<br>
	Love Lead Medic Team
</p>

<?php $this->load->view('public/email/email_footer') ?>