<?php $this->load->view('emails/email_header') ?>

<p>Hello!</p>
<p>
	We received a request to reset your password.
    <br>
    Follow this link to change your account.
    <br>
	<a href="<?php echo site_url('reset-password/'.$code) ?>" style="color:#0084b4;text-decoration:none" target="_blank"> Reset my Password. </a>
    <br>
    <br>
    <a href="<?php echo site_url('contact-us') ?>">Contact us </a>
    If you did not initiate this request.
</p>

<?php $this->load->view('emails/email_footer') ?>