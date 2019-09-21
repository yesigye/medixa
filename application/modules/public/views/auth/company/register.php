
<?php $this->load->view('public/templates/header', array(
	'title' => 'Register',
    'link' => 'register',
	'pageTitle' => 'Register your hospital',
	'breadcrumb' => [
		0 => array('name'=>'Hospitals', 'link'=>'hospitals'),
		1 => array('name'=>'register', 'link'=>false),
	]
)); ?>

<?php
// Icons from which to randomize
$icons = [
    base_url('assets/images/appointment.svg'),
    base_url('assets/images/workers.svg'),
    base_url('assets/images/doc.svg'),
    base_url('assets/images/notes.svg')
];
?>

<div class="container my-5">

    <?php $this->load->view('alert') ?>
    
    <p class="text-muted">Select the type that best describes your hospital</p>
	<div class="row card-group">
        <?php foreach ($types as $key => $type): ?>
		<div class="card m-3 col-md-4 p-0">
            <div class="card-body">
                <div class="text-dark">
                    <img src="<?= $icons[array_rand($icons)] ?>" class="align-self-center mb-2" style="height:135px">
                    <h5 class="media-heading"><?= $type['name'] ?></h5>
                    <p class="card-text text-muted"><?= $type['description'] ?></p>
                </div>
            </div>
            <div class="card-footer p-0 border-0">
                <a data-toggle="modal" href="#modal-reg-<?= $key ?>" class="btn btn-primary btn-block rounded-0">
                    Register
                </a>
            </div>
        </div>


        <div class="modal fade" id="modal-reg-<?= $key ?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title"><?php echo lang('form_create_head') ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php if (validation_errors() && $this->input->post('register')): ?>
                        <div class="alert alert-danger" data-trigger-modal="#modal-reg-<?= $key ?>">
                            This form has errors. Correct them and try again.
                        </div>
                        <?php endif ?>
                        
                        <?php echo form_open(current_url()) ?>
                        <?php echo form_hidden('types[]', $type['id']) ?>
                        <?php $this->load->view('form_fields', ['fields' => $form_fields]) ?>
                        <button type="submit" name="register" value="1" class="btn btn-lg btn-block btn-outline-primary">
                            <small>CONTINUE</small>
                        </button>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach ?>
	</div>
</div>

<?php $this->load->view('public/templates/footer') ?>