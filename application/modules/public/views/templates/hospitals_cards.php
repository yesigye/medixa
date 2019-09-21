<?php if($this->session->userdata('cardsType') !== 'list'): ?>
   
    <?php if (!isset($col)) $col = 'col-6'; ?>
    <div class="row">
        <?php foreach ($hospitals as $key => $hospital): ?>
        <div class="<?= $col ?>">
            <div class="card-group row m-0 mb-3">
                <div class="card col-4 p-0 border-right-0"
                style="background-position: center;background-size:cover;background-image:url('<?php echo base_url('image/'.$hospital['preview']) ?>')">
                </div>
                <div class="card col-8 p-0 border-left-0">
                    <div class="card-body">
                        <div class="media mb-2 text-truncate">
                            <img src="<?php echo base_url('image/'.$hospital['logo']) ?>" alt="" style="width:35px;margin-top:8px;">
                            <div class="media-body ml-2">
                                <a href="<?= site_url('hospitals/'.$hospital['slug']) ?>" class="card-link">
                                    <div class="text-truncate"><?= $hospital['name'] ?></div>
                                </a>
                                <i class="fa fa-map-marker text-muted mr-2"></i> <?= $hospital['address'] ?>
                            </div>
                        </div>
                        <div class="clearfix text-muted">
                            <div class="float-left my-1 mr-2">
                                <?php echo $hospital['doctors'] ? $hospital['doctors']." doctors" : 'no doctors available' ?>
                            </div>
                            <div class="float-left my-1">
                                <?php echo $hospital['facilities'] ? $hospital['facilities']." facilities" : 'no facilities available' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
<?php else: ?>

    <?php if (!isset($col)) $col = 'col-sm-6 col-md-4'; ?>
    <div class="row">
        <?php foreach ($hospitals as $key => $hospital): ?>
        <div class="<?= $col ?>">
            <a href="<?= site_url('hospitals/'.$hospital['slug']) ?>" class="card-link">
                <div class="card shade mb-3">
                    <div class="card-group">
                        <div class="card border-0">
                            <?php if($hospital['preview']): ?>
                            <img src="<?= $hospital['preview'] ?>" alt="" class="card-img-top">
                            <?php else: ?>
                            <img src="<?= base_url('assets/images/placeholder.png') ?>" alt="" class="card-img-top">
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-truncate text-dark"><?= $hospital['name'] ?></div>
                        <p class="text-muted text-truncate m-0">
                            <?= $hospital['address'] ?>
                        </p>
                        <div class="row mt-1 small text-muted">
                            <div class="col-6">
                                <span class="fa fa-users">
                                    &nbsp <?= $hospital['doctors'] ? $hospital['doctors'] : 'no' ?>
                                </span>
                                Physicians
                            </div>
                            <div class="col-6">
                                <span class="fa fa-bed">
                                    &nbsp <?= $hospital['facilities'] ? $hospital['facilities'] : 'no' ?>
                                </span>
                                Facilities
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0 border-0 bg-secondary">
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach ?>
    </div>
<?php endif ?>