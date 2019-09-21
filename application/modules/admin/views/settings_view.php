<?php
$link = 'settings';
$this->load->view('admin/header', array(
	'title' => lang('menu_settings'),
	'link' => 'settings',
	'breadcrumb' => array(
		0 => array('name'=> lang('menu_settings'), 'link'=> false),
	),
)); ?>

<div class="row mt-3">
    <div class="col-md-3">
        <?php $this->load->view('settings_menu', ['active' => 'general']) ?>
    </div>
    <div class="col-md-9">
        <?php echo form_open() ?>
            <div class="tab-content mb-4">
                <div class="tab-pane active" role="tabpanel" id="tab-general">
                    
                    <?php $this->load->view('form_fields', ['fields' => $form_fields]); ?>

                </div>
                <div class="tab-pane" role="tabpanel" id="tab-privacy">
                    <textarea name="privacy" class="form-control" rows="12"><?php echo $settings['privacy_policy'] ?></textarea>
                </div>
                <div class="tab-pane" role="tabpanel" id="tab-terms">
                    <textarea name="terms" class="form-control" rows="12"><?php echo $settings['terms_of_service'] ?></textarea>
                </div>
            </div>
            <button type="submit" name="update" value="1" class="btn btn-success">
                <?php echo lang('btn_update') ?>
            </button>
        <?php echo form_close() ?>
    </div>
</div>


<?php $this->load->view('admin/footer') ?>