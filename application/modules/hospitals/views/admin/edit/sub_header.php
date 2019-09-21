<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link <?= ($active == 'details') ? 'active' : '' ?>" href="<?= site_url('admin/hospitals/edit/'.$hospital_id) ?>">
            <?php echo lang('menu_details') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($active == 'location') ? 'active' : '' ?>" href="<?= site_url('admin/hospitals/edit_location/'.$hospital_id) ?>">
            <?php echo lang('form_location') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($active == 'images') ? 'active' : '' ?>" href="<?= site_url('admin/hospitals/edit_images/'.$hospital_id) ?>">
            <?php echo lang('menu_images') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= ($active == 'users') ? 'active' : '' ?>" href="<?= site_url('admin/hospitals/edit_doctors/'.$hospital_id) ?>">
            <?php echo lang('menu_doctors') ?>
        </a>
    </li>
</ul>