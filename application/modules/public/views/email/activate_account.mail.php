<?php $this->load->view('emails/email_header') ?>

<p>Hello!</p>
<p>
	Your account has been created successfully.
    <br>

    <?php if(isset($password)): ?>
    Your password is <font color="#cc0000"><?=$password?></font>
    <br>
    For security reasons, change your password the next time you log in.
    <?php endif ?>

    <br>
    <br>
    Follow this link to activate your account.
    <br>
	<a href="<?php echo site_url('activate/'.$user_id.'/'.$code) ?>" style="color:#0084b4;text-decoration:none" target="_blank"> Activate my Account. </a>
</p>

<?php $this->load->view('emails/email_footer') ?>