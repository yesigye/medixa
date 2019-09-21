<div class="card-header">
	<ul class="nav nav-tabs card-header-tabs">
		<li class="nav-item">
			<a class="nav-link <?= ($active == 'hospitals') ? 'active' : '' ?>" href="<?php echo site_url('admin/hospitals') ?>">
				Hospitals <span class="text-muted">(<?php echo $hospitalsCount ?>)</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link <?= ($active == 'types') ? 'active' : '' ?>" href="<?php echo site_url('admin/hospitals/types') ?>">
				Types <span class="text-muted">(<?php echo $typesCount ?>)</span>
			</a>
		</li>
		
		<li class="nav-item">
			<a class="nav-link <?= ($active == 'specialities') ? 'active' : '' ?>" href="<?php echo site_url('admin/hospitals/specialities') ?>">
				Specialities <span class="text-muted">(<?php echo $specialitiesCount ?>)</span>
			</a>
		</li>
	</ul>
</div>