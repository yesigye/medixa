<?php $this->load->view('admin/header', array(
	'title' => lang('menu_settings'),
	'link' => 'settings',
	'breadcrumb' => array(
		0 => array('name'=> lang('menu_settings'), 'link'=> false),
	),
)); ?>

<div class="row">
    <div class="col-md-3">
        <?php $this->load->view('settings_menu', ['active' => 'terms']) ?>
    </div>
    <div class="col-md-9">
        <?php echo form_open() ?>
            <textarea
            name="terms"
            id="privacy-txt"
            cols="30"
            rows="10"
            placeholder="<?php echo lang('form_input_placeholder') ?>"
            class="form-control"><?php echo $settings['terms_of_service'] ?></textarea>

            <button name="update" value="1" class="btn btn-success mt-1"> <?php echo lang('btn_update') ?> </button>
        <?php echo form_close() ?>
    </div>
</div>

<?php $this->load->view('admin/footer') ?>