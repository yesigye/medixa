<?php echo $this->load->view('public/templates/header', array(
	'title' => 'My Dashboard',
    'link' => 'dashboard',
)); ?>

<?php $this->load->view('sub_header', ['active' => 'facilities']) ?>

    <?php $this->load->view('templates/alerts') ?>

    <?= form_open_multipart(current_url()) ?>
    
    <h5 class="mb-4">From the list, check the facilities that you provide</h5>

    <?php foreach ($all_facilities as $facility): ?>
    <div class="custom-control custom-checkbox form-group">
        <input class="custom-control-input" id="check_<?= $facility['id'] ?>"
        type="checkbox" name="facilities[]" value="<?= $facility['id'] ?>"
        <?= (in_array($facility['id'], $facilities)) ? 'checked="checked"' : '' ?>>
        <label for="check_<?= $facility['id'] ?>" class="custom-control-label">
            <?= $facility['name'] ?>
            <small class="form-text text-muted mt-0 mb-1">
                <?= $facility['description'] ?>
            </small>
        </label>
    </div>
    <?php endforeach ?>

    <button type="submit" name="update" value="update" class="btn btn-lg btn-primary my-3">
        <small>SAVE CHANGES</small>
    </button>
    <?= form_close() ?>
</div>
</div>

<?php $this->load->view('public/templates/footer') ?>