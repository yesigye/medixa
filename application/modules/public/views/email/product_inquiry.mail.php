<?php $this->load->view('public/email/email_header') ?>

<p>
	Hello <?php echo $product->seller->company_name ?>! <br>
	A user is inquiring about one of your item <?php echo anchor(current_url(), $product->name) ?> on our website.
	Please review the details of this inquiry and use the user's email to reply to this inquiry. <br>
</p>

<p>
	<strong>Inquiry Details</strong> <br>
	Target Price <strong><?php echo $buyer_price ?></strong> <br>
	Order Quantity <strong><?php echo $buyer_order ?></strong> <br>
	<?php echo $buyer_inquiry ?>
</p>
<p>
	<strong>User Details</strong> <br>
	<?php echo $buyer_name ?> <br>
	<?php echo mailto($buyer_email, $buyer_email) ?> <br>
	<?php echo $buyer_phone ?> <br>
	<?php echo $buyer_location ?> <br>
</p>

<p>&nbsp;</p>
<p>Thanks for your business!</p>
<p>
	Regards,<br>
	Love Lead Medic Team
</p>

<?php $this->load->view('public/email/email_footer') ?>