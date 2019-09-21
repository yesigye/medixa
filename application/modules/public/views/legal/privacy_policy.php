
<?php $this->load->view('public/templates/header', array(
	'title' => 'Privacy Policy',
    'link' => 'privacy',
)); ?>

<div class="container">
    <div class="h3 my-5">Privacy Policy</div>
    <div class="user-html">
        <?= $privacy_policy ?>
    </div>
</div>

<?php $this->load->view('public/templates/footer') ?>
