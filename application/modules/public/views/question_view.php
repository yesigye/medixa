<?php echo Modules::run('public/templates/header', array(
    'title' => 'Questions',
    'link' => 'questions',
    )) ?>

<div class="container page-header b-0">
    <div class="text-right">
        <?php echo anchor('questions/ask', 'Ask Question', 'class="btn btn-success"') ?>
    </div>
</div>

<div class="container">
    <div class="lead"><?php echo $question->title ?></div>
    <p><?php echo $question->question ?></p>
    <div class="media">
        <?php if ($question->asker): ?>
            <div class="media-left">
                <img class="media-object" src="<?php echo base_url('image/'.$question->asker['avatar']) ?>" alt="..." style="width:35px">
            </div>
        <?php endif ?>
        <div class="media-body" style="position:relative;top:-4px">
            <span class="label label-default">to <?php echo $question->speciality ?></span>
            <span style="margin-left:10px">
                asked <?php echo nice_date($question->date_created, 'M d y').' at '.nice_date($question->date_created, 'h:i') ?>
            </span>
            <?php if ($question->asker): ?>
                <div class="media-heading"><?php echo $question->asker['username'] ?></div>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="container">
    <?php if ($question->answers): ?>
        <ul class="nav nav-pills" style="margin-bottom:20px">
            <li role="presentation" class="<?= (preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING'])) ? '' : 'active' ?>">
                <?= anchor(current_url(), 'Votes') ?>
            </li>
            <li role="presentation" class="<?= ($this->input->get('sort') === 'new') ? 'active' : '' ?>">
                <?= anchor(current_url(), 'Newest') ?>
            </li>
            <li role="presentation" class="<?= ($this->input->get('sort') === 'old') ? 'active' : '' ?>">
                <?= anchor(current_url(), 'oldest') ?>
            </li>
        </ul>
    <?php endif ?>

    <?php if ($question->answers): ?>
        <?php foreach ($question->answers as $key => $row): ?>            
            <div class="well well-sm">
                <div class="lead"><?php echo $row->answer ?></div>
                <div class="pull-left form-group">
                    <?php if ($this->ion_auth->in_group('doctors')): ?>
                        <?php if ($row->user->id !== $user->id): ?>
                        <?php echo form_open(current_url()) ?>
                            <?php echo form_hidden('user_id', $user->id) ?>
                            <?php echo form_hidden('answer_id', $row->id) ?>
                            <?php echo form_hidden('voting', TRUE) ?>
                        <?php endif ?>
                    <?php endif ?>

                        <button class="btn btn-default" name="vote" value="1">
                            <span class="text-success">
                                <i class="fa fa-thumbs-up"></i> <?php echo $row->u_votes ?>
                            </span>
                        </button>

                        <button class="btn btn-default" name="vote" value="0">
                            <span class="text-danger">
                                <i class="fa fa-thumbs-down"></i> <?php echo $row->d_votes ?>
                            </span>
                        </button>
                        
                    <?php if ($this->ion_auth->in_group('doctors')): ?>
                        <?php if ($row->user->id !== $user->id): ?>
                            <?php echo form_close() ?>
                        <?php endif ?>
                    <?php endif ?>
                </div>




                <div class="media pull-right" style="margin:0;width:250px">
                    <?php if ($row->user): ?>
                        <div class="media-left">
                            <img class="media-object" src="<?php echo base_url('image/'.$row->user['avatar']) ?>" alt="..." style="width:35px">
                        </div>
                    <?php endif ?>
                    <div class="media-body">
                        <div class="media-heading">
                            <?php if (isset($row->user['reg_no'])): ?>
                                <?php echo anchor('physicians/'.$row->user['reg_no'].'/'.url_title($row->user['first_name'].' '.$row->user['last_name']), $row->user['username']) ?>
                            <?php else: ?>
                                <?php if ($row->user): ?>
                                    <?php echo $row->user['username'] ?>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <small>answered <?php echo nice_date($row->date_created, 'M d y').' at '.nice_date($row->date_created, 'h:i') ?></small>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        <?php endforeach ?>
    <?php endif ?>

    <?php if ($this->ion_auth->in_group('physicians')): ?>
        <?php echo form_open() ?>
            <?php echo form_hidden('q_id', $question->id) ?>
            <?php echo form_hidden('user_id', $user->user_id) ?>
            <div class="lead">Can you help?</div>
            <h4>
                We depends on everyone sharing their knowledge. If you're able to answer this question, please do!
            </h4>
            <?php if (validation_errors()): ?>
                <div class="alert alert-danger animated fadeInDown" id="message">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    The form was submitted with errors, please check the form and try again.
                </div>
            <?php endif ?>
            <div class="form-group <?= form_error('answer') ? 'has-error' : '' ?>">
                <label class="control-label" for="answer"></label>
                <div class="alert alert-info">
                    Please be sure to answer the question.
                    Provide details and share your research!
                    But avoid asking for help, clarification,
                    and making statements based on opinion;
                    back your answer up with references or personal experience.
                </div>
                <textarea class="form-control" name="answer" rows="8"><?= set_value('answer') ? set_value('answer') : '' ?></textarea>
                <small class="text-muted">A name or a short description of the item</small>
                <div class="text-danger"><?= form_error('answer') ? form_error('answer') : '&nbsp' ?></div>
            </div>
            <div class="form-group">
                <input type="submit" name="answer_question" value="Post your answer" class="btn btn-lg btn-block btn-primary" />
            </div>
        <?php echo form_close() ?>

        <script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
    <?php else: ?>
        <div class="lead text-muted" style="margin:5rem 0">
            Only registered physicians can answer questions.
            <a href="<?php echo site_url('login') ?>">Login</a>
            to answer this question.
        </div>
    <?php endif ?>
</div>

<?php echo Modules::run('public/templates/footer') ?>