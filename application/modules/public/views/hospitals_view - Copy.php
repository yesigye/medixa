<?php echo $this->load->view('public/templates/header', array(
	'title' => 'Hospitals',
	'link' => 'hospitals',
	'pageTitle' => 'Hospitals',
	'breadcrumb' => [
		['name'=>'Hospitals', 'link'=>false],
	]
)); ?>

<div class="container mb-4">
	<div class="row">
		<div class="col-md-8 mt-5">
			<h1>Medical Directory and Listing</h1>
			<p class="mt-3 lead">
				Find a profession physician or a hospital that will cater to your needs.
			</p>
		</div>
		<div class="col-md-4 mt-3">
			<div class="container">
				<div class="container">
					<img src="<?= base_url('assets/images/appointment.svg') ?>" alt="" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container mx-auto">
	<div class="mx-auto">
		<ul class="nav bg-light py-2 mb-3">
			<?php foreach ($filters as $option => $filter): ?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle text-dark" data-toggle="dropdown" href="#">
					<span class="text-uppercase">
						<?= $option ?>
					</span>	
					<?php if($filter['active']): ?>
						<span class="ml-1 text-muted"><?= $filter['active'] ?></span>
					<?php endif ?>
				</a>
				<div class="dropdown-menu">
					<?php if($filter['active']): ?>
						<a class="dropdown-item text-danger" href="<?= $filter['reset'] ?>">Remove Filter</a>
						<div class="dropdown-item divider"></div>
					<?php endif ?>
					<?php foreach ($filter['options'] as $item): ?>
					<a class="dropdown-item <?= $item['isActive'] ? 'active' : '' ?>" href="<?= $item['link'] ?>">
						<?= $item['name'] ?>
					</a>
					<?php endforeach ?>
				</div>
			</li>
			<?php endforeach ?>
			<?php if ($isFiltered): ?>
			<li class="nav-item">
				<a href="<?= site_url('hospitals') ?>" class="nav-link text-danger">Clear all Filters</a>
			</li>
			<?php endif ?>
		<ul>
	</div>
</div>


<div class="container mb-3">
	<div class="row">
		<div class="col-md-4 text-muted pt-2">
			<?= $resultStart ?> - <?= $resultEnd ?> of <?= $resultTotal ?> results
		</div>
		<div class="col-md-8">
			<ul class="nav justify-content-end">
				<li class="nav-item">
					<span class="nav-link disabled">View:</span>
				</li>
				<li class="nav-item">
					<a class="nav-link text-danger" href="#">Tile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">List</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Directory</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="container">
	<?php if (!$hospitals AND $_SERVER['QUERY_STRING']): ?>
		<hr>
		<div class="text-muted py-5 h5 border-0">
			Sorry, No results matched your filtering options.
		</div>
	<?php else: ?>
		<?php $this->load->view('public/templates/hospitals_cards', ['hospitals' => $hospitals]) ?>
	<?php endif ?>

	<?php echo $this->pagination->create_links() ?>
</div>

<?php $this->load->view('public/templates/footer') ?>