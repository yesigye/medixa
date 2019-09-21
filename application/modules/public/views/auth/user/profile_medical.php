<?php echo $this->load->view('public/templates/header', array(
	'title' => 'My Dashboard',
    'link' => 'profile',
)); ?>

<div class="container">
    <?php $this->load->view('sub_header', ['active' => 'prof']) ?>
    
    <?= form_open(current_url(), 'class="mt-4"') ?>
        <?php $this->doctors->updateForm($user_id); ?>

        <button type="submit" name="save" value="save" class="btn btn-lg btn-primary my-5">
            <small>UPDATE</small>
        </button>
    <?= form_close() ?>
</div>


<script>
document.addEventListener("DOMContentLoaded", initLocale);

function initLocale() {
    <?php foreach ($locationTypes as $key => $type): if ($key == 0) continue; ?>
    $("#<?= $type['code'] ?>").remoteChained({
        parents : "#<?= $locationTypes[$key-1]['code'] ?>",
        url : "<?= site_url('api/locations/') ?>"
    });
    <?php endforeach ?>
    
    <?php foreach ($selectedLocationTypes as $key => $loc): ?>
    $('#<?= $locationTypes[$key]['code'] ?>').val('<?= $loc['code'] ?>').change();
    <?php endforeach ?>
}
</script>

<?php echo $this->load->view('public/templates/footer', [
    'scripts' => [
        '<script src="'.base_url('assets/js/jquery.chained.remote.min.js').'"></script>',
    ],
]) ?>   