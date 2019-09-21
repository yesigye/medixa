
<?php $this->load->view('public/templates/header', array(
	'title' => 'Terms of Service',
    'link' => 'terms',
)); ?>

<div class="container">
    <div class="h3 my-5">Terms of Service</div>
    <div class="user-html">
        <?= $terms_of_service ?>
    </div>
</div>

<?php $this->load->view('public/templates/footer') ?>
