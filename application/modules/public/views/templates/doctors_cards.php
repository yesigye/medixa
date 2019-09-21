<?php
if (!$this->session->userdata('docCardsType')) {
    // Set default view type to 'list'
    $this->session->set_userdata('docCardsType', 'list');
}
if($this->session->userdata('docCardsType') === 'list'): ?>

<?php if (!isset($row)) $row = 'row'; ?>
<?php if (!isset($col)) $col = 'col-md-12'; ?>

<div class="<?php echo $row ?>">
<?php foreach ($doctors as $key => $doctor): ?>
    <?php $docName = $doctor['first_name'].' '.$doctor['last_name'].'&nbsp' ?>
    <div class="<?php echo $col ?>">
        <div class="row card-group mx-0 mb-4">
            <div class="col-md-2 card p-0">
                <div class="card-body p-0">
                    <img src="<?= base_url('image/'.$doctor['avatar']) ?>" alt="" class="h-100 w-100">
                </div>
            </div>
            <div class="col-md-6 card">
                <div class="card-body px-1">
                    <a href="<?php echo site_url('physicians/'.$doctor['reg_no'].'/'.url_title($docName)) ?>" class="h5"><?= $docName ?></a>
                    <div class="text-muted"><?= $doctor['speciality'] ?></div>
                    <p class="mt-2 text-truncate small">
                        <i class="fa fa-map-marker text-muted mr-2"></i> <?php echo $doctor['location'] ?>
                        <?php if($doctor['is_mobile']): ?>
                        <div class="text-success">Physician is mobile</div>
                        <?php endif ?>
                    </p>
                </div>
            </div>
            <div class="col-md-2 card p-0">
                <div class="card-footr p-1 text-center">
                    <div class="list-group list-group-flush" style="max-height:100%;overflow-y:auto;">
                        <a href="#" class="list-group-item text-muted py-2">Mon</a>
                        <a href="#" class="list-group-item text-muted py-2">Tue</a>
                        <a href="#" class="list-group-item text-muted py-2">Fri</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 card p-0">
                <div class="card-body text-center">
                    <a href="skype:echo123?call" class="text">
                        Consult online <br>
                        20,000 UGX
                    </a>
                    <div class="text-muted mt-3">OR</div>
                </div>
                <div class="card-footer border-0 p-0">
                    <button class="rounded-0 btn btn-block btn-secondary">Set Appointment</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>
 
<?php else: ?>

<?php if (!isset($col)) $col = 'col-sm-6 col-md-6 col-lg-3'; ?>

<div class="row">
    <?php foreach ($doctors as $key => $doctor): ?>
        <?php $docName = $doctor['first_name'].' '.$doctor['last_name'].'&nbsp' ?>
        <div class="<?php echo $col ?>">
            <!-- <a href="<?php echo site_url('physicians/'.$doctor['reg_no'].'/'.url_title($docName)) ?>"> -->
            <div class="card shade mb-3">
                <a class="card-link text-dark" href="<?= site_url('physicians/'.$doctor['reg_no'].'/'.url_title($docName)) ?>">
                    <img src="<?= base_url('image/'.$doctor['avatar']) ?>" alt="" class="card-img-top mb-2">
                    <div class="card-body pt-1 pb-0">
                        <div class=""><?= $docName ?></div>
                        <div class="text-muted small"><?= $doctor['speciality'] ?></div>
                        <p class="small text-truncate">
                            <?= $doctor['educ'] ?>
                            <br>
                        </p>
                        <div class="row">
                            <div class="col-6 small">
                                <?php echo $doctor['location'] ?>
                            </div>
                            <div class="col-6 text-right">
                                <i
                                <?php if(!$doctor['is_mobile']): ?>
                                style="visibility: hidden;"
                                <?php endif ?>
                                class="fa fa-ambulance text-muted mb-2"
                                data-toggle="tooltip" title="offers mobile services"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach ?>
</div>
<?php endif ?>