<?php echo Modules::run('public/templates/header', array(
    'title' => 'Questions',
    'link' => 'questions',
    )) ?>

<div class="bg-image">
    <div class="container">
        <div class="lead">Questions</div>
        <p>Ask our community of experts. In this information era, millions of people are constantly seeking the right sources of information to make critical and informed decisions daily.</p>
    </div>
</div>

<?php echo form_open(current_url()) ?>
	<div class="container">
		<?php $this->load->view('public/templates/alerts') ?>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-5" style="float: right">
				<div class="well">
					<div class="lead">Tips on asking questions</div>
					<h4 class="text-muted">Be on-topic</h4>
					<p>
						Our community is that of healthcare professionals in the help center. please stick to medical and healthcare topics and avoid asking for opinions or open-ended discussion. If your question is about the site itself,
						<?php echo anchor('contact_us', 'Contact Us Here') ?>
					</p>
					<h4 class="text-muted">Be specific</h4>
					<p>
						If you ask a vague question, you’ll get a vague answer. But if you give us details and context, we can provide a useful, relevant answer.
					</p>
					<h4 class="text-muted">Make it relevant to others</h4>
					<p>
						We like to help as many people at a time as we can. Make your question relevant to more people than just you, and more of us will be interested in your question and willing to look into it.
					</p>
					<h4 class="text-muted">Keep an open mind</h4>
					<p>
						The answer to your question may not always be the one you wanted, but that doesn’t mean it is wrong. A conclusive answer isn’t always possible. When in doubt, ask people to cite their sources, or to explain how/where they learned something. Even if we don’t agree with you, or tell you exactly what you wanted to hear, remember: we’re just trying to help.
					</p>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-7" style="float: right">
				<div class="lead">Ask a Question</div>
				<?php if (empty($user)): ?>
					<div class="alert alert-danger">
						Please <?php echo anchor('login', 'Login') ?> to ask a question.
					</div>
				<?php endif ?>
				<?php if (validation_errors()): ?>
					<div class="alert alert-danger animated fadeInDown" id="message">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						The form was submitted with errors, please check the form and try again.
					</div>
				<?php endif ?>
				<div class="form-group <?= form_error('title') ? 'has-error' : '' ?>">
					<label class="control-label" for="title">Title</label>
					<input class="form-control" type="text" name="title" value="<?= set_value('title') ?>" />
					<div class="text-danger"><?= form_error('title') ? form_error('title') : null ?></div>
				</div>
				<div class="form-group <?= form_error('speciality') ? 'has-error' : '' ?>">
					<label class="control-label" for="speciality">Select a specialist</label>
					<select name="speciality" class="form-control">
						<option value="" class="text-muted">ANY</option>
						<?php foreach ($specialities as $key => $speciality): ?>
							<option value="<?php echo $speciality['id'] ?>">
								<?php echo $speciality['name'] ?>
							</option>
						<?php endforeach ?>
					</select>
					<p class="help-block">Direct your question to a specialist physician for better answers.</p>
					<div class="text-danger"><?= form_error('speciality') ? form_error('speciality') : null ?></div>
				</div>
				<div class="form-group <?= form_error('question') ? 'has-error' : '' ?>">
					<label class="control-label" for="question">Your Question</label>
					<textarea class="form-control" rows="8" name="question"><?= set_value('question') ?></textarea>
					<div class="text-danger"><?= form_error('question') ? form_error('question') : null ?></div>
				</div>
				<div class="form-group <?= form_error('question') ? 'has-error' : '' ?>">
					<?php if (empty($this->data['user'])): ?>
						<button type="button" data-toggle="modal" data-target="#login-modal" class="btn btn-primary">Post Question</button>
					<?php else: ?>
						<input type="submit" name="ask" value="Post Question" class="btn btn-primary"/>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view('public/login_express_view', array(
		'login_info' => 'Please sign in to ask a question'
		)) ?>
<?php echo form_close() ?>


<?php echo Modules::run('public/templates/footer') ?>