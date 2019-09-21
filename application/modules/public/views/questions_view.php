
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

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <ul class="nav nav-pills">
                <li>
                   <div class="lead">Questions Asked</div>
                </li>

                <li role="presentation" class="pull-right <?= ($this->input->get('elapsed') === 'month') ? 'active' : '' ?>">
                    <?= anchor(current_url().'?'.($this->input->get('elapsed') ? preg_replace('/(^|&)elapsed=[^&]*/', '&elapsed=month', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&elapsed=month'), 'Month', 'data-ci-pagination-page' ) ?>
                </li>

                <li role="presentation" class="pull-right <?= ($this->input->get('elapsed') === 'week') ? 'active' : '' ?>">
                    <?= anchor(current_url().'?'.($this->input->get('elapsed') ? preg_replace('/(^|&)elapsed=[^&]*/', '&elapsed=week', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&elapsed=week'), 'Week', 'data-ci-pagination-page' ) ?>
                </li>

                <li role="presentation" class="pull-right <?= (preg_replace('/(^|&)per_page=[^&]*/', '', $_SERVER['QUERY_STRING'])) ? '' : 'active' ?>">
                    <?= anchor(current_url(), 'Featured') ?>
                </li>

                <li class="clearfix"></li>
            </ul>

            <?php if (! $questions): ?>
                <?php if ($_SERVER['QUERY_STRING']): ?>
                    <?php if ($this->input->get('elapsed')): ?>
                        <div class="lead text-muted" style="margin:5rem 0">There are no questions posted this <?php echo $this->input->get('elapsed') ?></div>
                    <?php endif ?>
                <?php endif ?>
            <?php else: ?>
                <?php foreach ($questions as $key => $row): ?>
                    <div class="well well-sm">
                        <div class="lead">
                            <?php echo anchor('questions/'.$row->slug, $row->title) ?>
                        </div>
                        <span class="label label-default">to <?php echo $row->speciality ?></span>

                        <span style="margin-left:1rem">
                            <?php echo $row->answersCount.(($row->answersCount !== 1) ? ' answers' : ' answer') ?>
                        </span>
                        <span style="margin-left:1rem">
                            <?php echo $row->votesCount.(($row->votesCount)  !== 1? ' votes' : ' vote') ?>
                        </span>

                        <span class="pull-right" data-toggle="tooltip" data-placement="bottom" title="<?php echo $row->date_created ?>">
                            <small>asked <?php echo $row->time_elapsed ?></small>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                <?php endforeach ?>

                <?php if ($this->pagination->create_links()): ?>
                    <?php echo $this->pagination->create_links() ?>
                <?php endif ?>
            <?php endif ?>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <a href="<?php echo site_url('question/ask') ?>" class="btn btn-block btn-success">
                    Ask a Question
                </a>
            </div>
            <div class="well well sm">
                <?php if ($unanswered): ?>
                    <div class="lead">Unanswered questions</div>
                    <?php foreach ($unanswered as $key => $row): ?>
                        <p>
                            <a href="<?php echo site_url('questions/'.$row->slug) ?>">
                                <?php echo $row->title ?>
                            </a>
                        </p>
                    <?php endforeach ?>
                    <hr>
                    *<small class="text-muted">Only registered physicians can answer questions</small>*
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php echo Modules::run('public/templates/footer') ?>