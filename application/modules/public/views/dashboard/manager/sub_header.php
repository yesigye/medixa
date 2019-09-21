<div class="container">
    <div class="row">
        <div class="col-md-2 pr-0">
            <div class="mt-4 text-center">
                <img src="<?= $hospital_logo ?>" alt="" style="width:35px">
                <div class="text-"><?= $hospital_name ?></div>
            </div>
            <h6 class="my-3 text-muted">Dashboard</h6>

            <ul class="nav mt-3 mb-4 text-uppercase small horizontal-scroll fluid" style="padding:1px 0;">
                <li class="nav-item scroll-item">
                    <a href="<?= site_url('dashboard') ?>"
                    class="nav-link <?= ($active === 'home') ? 'text-danger font-weight-bold' : 'text-muted' ?>">
                        Home
                    </a>
                </li>
                <li class="nav-item scroll-item">
                    <a href="<?= site_url('dashboard/physicians') ?>"
                    class="nav-link <?= ($active === 'physicians') ? 'text-danger font-weight-bold' : 'text-muted' ?>">
                        Physicians
                    </a>
                </li>
                <li class="nav-item scroll-item">
                    <a href="<?= site_url('dashboard/facilities') ?>"
                    class="nav-link <?= ($active === 'facilities') ? 'text-danger font-weight-bold' : 'text-muted' ?>">
                        Facilities
                    </a>
                </li>
                <li class="nav-item scroll-item">
                    <a href="<?= site_url('dashboard/photos') ?>"
                    class="nav-link <?= ($active === 'photos') ? 'active text-danger font-weight-bold' : 'text-muted' ?>">
                        Photos
                    </a>
                </li>
                <li class="nav-item scroll-item">
                    <a href="<?= site_url('dashboard/profile') ?>"
                    class="nav-link <?= ($active === 'about') ? 'text-danger font-weight-bold' : 'text-muted' ?>">
                        About
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 pl-4 pt-4 border-left">
            <?php if(isset($hospital['active']) && (int)$hospital['active'] !== 1): ?>
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-circle mr-2"></i>
                    This account is not active. We are still reviewing your application.
                </div>
            <?php endif ?>