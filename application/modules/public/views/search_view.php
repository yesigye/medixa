<?php $this->load->view('public/templates/header') ?>

<div class="container">
	<div class="row mt-5 mb-2">
		<div class="col-md-6 col-lg-5 m-auto">
			<?= form_open(current_url(), 'method="GET"') ?>
				<div class="input-group">
					<input type="text" name="q" class="form-control form-control-lg rounded-0 text-muted"
					placeholder="Type Keywords" value="<?= $this->session->userdata('search_query') ?>">
					<span class="input-group-btn">
						<div class="btn-group" role="group" aria-label="Basic example">
							<button type="submit" class="btn btn-lg btn-primary rounded-0">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</span>
				</div>
			<?= form_close() ?>
		</div>
	</div>

	<ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#docs-tab" role="tab">
				Physicians <span class="badge text-danger ml-2"><?= $doc_total ?></span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#hosp-tab" role="tab">
				Hospitals <span class="badge text-danger ml-2"><?= $hosp_total ?></span>
			</a>
		</li>
	</ul>
		
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="docs-tab" role="tabpanel">

			<?php if (!$doctors AND $_SERVER['QUERY_STRING']): ?>
				<div class="text-muted py-5 h5 border-0">Sorry, No matches were found.</div>
			<?php else: ?>
				<?php $this->load->view('public/templates/doctors_cards', ['doctors' => $doctors]) ?>
			<?php endif ?>

			<?= $docs_pagination ?>
		</div>

		<div class="tab-pane fade" id="hosp-tab" role="tabpanel">
			<?php if (!$hospitals): ?>
				<div class="text-muted py-5 h5 border-0">Sorry, No matches were found.</div>
			<?php else: ?>
				<?php $this->load->view('public/templates/hospitals_cards', ['hospitals' => $hospitals]) ?>
			<?php endif ?>

			<?php echo $this->pagination->create_links() ?>
		</div>
	</div>
</div>

<?php $this->load->view('public/templates/footer') ?>