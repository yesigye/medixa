<?php $this->load->view('admin/header', array(
	'title' => lang('menu_appointments'),
	'link' => 'appointments',
	'pageTitle' => anchor('admin/appointments', '<i class="fa fa-arrow-left"></i>'),
	'breadcrumb' => array(
        ['name' => lang('menu_appointments'), 'link'=> 'appointments'],
        ['name' => lang('menu_details'), 'link'=> false],
    )
)); ?>

<?php if( ! $appointment['approved']): ?>
    <div class="alert alert-warning">
        <?php echo lang('alert_appointment_unapproved') ?>
    </div>
<?php endif; ?>

<p>
    <?php echo $appointment['title'] ?>
    <div class="text-muted"><?php echo $appointment['start_date'] ?></div>
</p>

<div class="card card-body">
    <?php echo $appointment['message'] ?>
</div>

<div class="row mt-3">
    <div class="col-6">
        <div class="media">
            <img class="mr-3" style="width:45px" src="<?php echo base_url('image/'.$appointment['user_avatar']) ?>" alt="">
            <div class="media-body">
                <h5 class="mt-0"><?php echo anchor('admin/users/edit/'.$appointment['user_id'], $appointment['username']) ?></h5>
            </div>
        </div>        
    </div>
    <div class="col-6">
        <div class="media">
            <img class="mr-3 align-self-center" style="width:45px" src="<?php echo base_url('image/'.$appointment['doctor_avatar']) ?>" alt="">
            <div class="media-body">
                <strong>Doctor</strong>
                <div class=""><?php echo anchor('admin/users/edit/'.$appointment['doctor_id'], $appointment['doctor_username']) ?></div>
                <small class="text-muted"><?php echo $appointment['doctor_speciality'] ?></small>
            </div>
        </div>        
    </div>
</div>
<?php $this->load->view('admin/footer') ?>