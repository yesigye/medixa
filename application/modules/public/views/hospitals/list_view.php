<div class="text-right text-muted py-3">
	<?php echo "$resultStart - $resultEnd of $resultTotal results" ?>
</div>

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