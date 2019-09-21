<?php $this->load->view('admin/header', array(
	'title' => lang('dash_title'),
	'pageTitle' => lang('dash_title'),
)); ?>

<div class="row card-deck m-0">
	<a href="<?php echo site_url('admin/appointments') ?>" class="col-md-3 card card-link ml-0 mb-3 card-body border-0 bg-danger text-white">
		<div class="card-title text-white"><?php echo lang('menu_appointments') ?></div>
		<i class="fa fa-user-md back-drop"></i>
		<h4><?php echo $total_appointments ?></h4>
		<?php if($total_appointments && $booked_physicians ): ?>
		<div class="small"><?php echo $this->lang->line('dash_appointment_info', [$total_appointments, $booked_physicians]) ?></div>
		<?php endif?>
	</a>
	<a href="<?php echo site_url('admin/users') ?>" class="col-md-3 card card-link ml-0 mb-3 card-body border-0 bg-warning text-muted">
		<div class="card-title text-muted"><?php echo lang('menu_users') ?></div>
		<i class="fa fa-users back-drop"></i>
		<h4><?php echo $total_users ?></h4>
		<?php if($inactive_users): ?>
		<div class="small"><?php echo $this->lang->line('dash_doctors_count', $total_physicians) ?></div>
		<?php endif ?>
	</a>
	<a href="<?php echo site_url('admin/hospitals') ?>" class="col-md-3 card card-link ml-0 mb-3 card-body border-0 bg-success text-white">
		<div class="card-title text-white"><?php echo lang('menu_hospitals') ?></div>
		<i class="fa fa-h-square back-drop"></i>
		<h4><?php echo $total_hospitals ?></h4>
	</a>
	<a href="<?php echo site_url('admin/hospitals/specialities') ?>" class="col-md-3 card card-link mx-0 mb-3 card-body border-0  bg-info text-white">
		<div class="card-title text-white"><?php echo lang('menu_specialities') ?></div>
		<i class="fa fa-user-md back-drop"></i>
		<h4><?php echo $total_specialties ?></h4>
	</a>
</div>

<div class="row card-deck m-0">
	<?php if(!empty($latest_hospitals)): ?>
	<div class="col-md-6 card p-0 ml-0 mb-3">
		<div class="card-header bg-secondary text-white mb-1">
			<?php echo lang('dash_latest_hospitals'); echo anchor('admin/hospitals', lang('btn_view_all'), 'class="text-white-50 float-right"') ?>
		</div>
		<div class="card-body pt-0">
			<?php foreach ($latest_hospitals as $key => $user):?>
			<div class="media <?php if($key !== 0) echo 'border-top' ?> py-2">
				<img class="mr-3 align-self-center" style="width:45px" src="<?php echo base_url('image/'.$user['preview']) ?>" alt="">
				<div class="media-body">
					<strong><?php echo anchor('admin/users/edit/', $user['name']) ?></strong>
					<div class=""> <?php echo $user['address'] ?></div>
					<span class="small text-muted mr-2"><?php echo $user['doctors'].' '.lang('menu_doctors') ?></span>
					<span class="small text-muted"><?php echo $user['facilities'].' '.lang('menu_facilities') ?></span>
					<?php if( ! $user['active']): ?>
					<div class="text-muted small"><?php echo $this->lang->line('alert_account_invisible') ?></div>
					<?php endif ?>
				</div>
				
				<div class="text-<?php echo $user['active'] ? 'success' : 'danger' ?>"> <?php echo $user['active'] ? 'active' : 'inactive' ?> </div>
			</div>
			<?php endforeach ?>
		</div>
		<div class="card-footer small">
			<?php echo anchor('admin/hospitals/edit/'.$largest_hospital['id'],
			$this->lang->line('dash_hospital_most_doctors_tooltip', ['<b>'.$largest_hospital['name'].'</b>', $largest_hospital['count']])) ?>
		</div>
	</div>
	<?php endif ?>
	<?php if ($latest_users): ?>
	<div class="col-md-6 card p-0 mr-0 mb-3">
		<div class="card-header bg-secondary text-white mb-1">
			<?php echo lang('dash_latest_users'); echo anchor('admin/users', lang('btn_view_all'), 'class="text-white-50 float-right"') ?>
		</div>
		<div class="card-body pt-0">
			<?php foreach ($latest_users as $key => $user):?>
			<div class="media <?php if($key !== 0) echo 'border-top' ?> py-2">
				<img class="mr-3 align-self-center" style="width:45px" src="<?php echo base_url('image/'.$user['thumbnail']) ?>" alt="">
				<div class="media-body">
					<strong><?php echo anchor('admin/users/edit/', $user['username']) ?></strong>
					<div class=""> <i class="fa fa-users text-muted mr-1"></i> <?php echo $user['group_name'] ?></div>
					<small class="text-muted">registered on : <?php echo $user['created_on'] ?></small>
					<?php if( ! $user['active']): ?>
					<div class="text-muted small"><?php echo $this->lang->line('alert_activate_email_sent', $user['email']) ?></div>
					<?php endif ?>
				</div>
				
				<div class="text-<?php echo $user['active'] ? 'success' : 'danger' ?>"> <?php echo $user['active'] ? 'active' : 'inactive' ?> </div>
			</div>
			<?php endforeach ?>
		</div>
	</div>	
	<?php endif ?>
</div>

<?php $this->load->view('admin/footer') ?>