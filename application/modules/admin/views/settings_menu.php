<nav class="list-group horizontal-scroll-alt flex-column mb-3">
    <div class="list-group-item list-group-item-dark text-uppercase font-weight-bold">
        <?php echo lang('menu_settings') ?>
    </div>
    <a class="list-group-item list-group-item-action scroll-item <?php if($active=="profile") echo 'active' ?>" href="<?php echo site_url('admin/profile') ?>" >
        <?php echo lang('menu_profile') ?>
    </a>
    <a class="list-group-item list-group-item-action scroll-item <?php if($active=="general") echo 'active' ?>" href="<?php echo site_url('admin/settings') ?>" >
        <?php echo lang('menu_general') ?>
    </a>
    <a class="list-group-item list-group-item-action scroll-item <?php if($active=="languages") echo 'active' ?>" href="<?php echo site_url('admin/settings/languages') ?>">
        <?php echo lang('menu_languages') ?>
    </a>
    <a class="list-group-item list-group-item-action scroll-item <?php if($active=="privacy") echo 'active' ?>" href="<?php echo site_url('admin/settings/privacy_policy') ?>">
        <?php echo lang('menu_privacy') ?>
    </a>
    <a class="list-group-item list-group-item-action scroll-item <?php if($active=="terms") echo 'active' ?>" href="<?php echo site_url('admin/settings/terms') ?>">
        <?php echo lang('menu_terms') ?>
    </a>
</nav>