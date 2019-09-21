<?php
// No Users returned and it is not a result of filtering
if ( ! $users AND ! $_SERVER['QUERY_STRING']): ?>
    <div class="text-muted my-4">You have no users yet.</div>
<?php else: ?>
    <?php echo form_open(current_url()) ?>
        <div class="card border-0 shade py-2 mb-3 text-capitalize">
            <nav class="nav text-capitalize">
                <?php foreach($filters as $filterTitle => $filter): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <?= $filterTitle ?>
                    </a>
                    <div class="dropdown-menu">
                        <?php foreach($filter as $filterName => $filterData): ?>
                        <a class="dropdown-item <?= $filterData['active'] ? 'active' : '' ?>" href="<?= $filterData['link'] ?>">
                            <?= $filterName ?>
                        </a>
                        <?php endforeach ?>
                    </div>
                </li>
                <?php endforeach ?>
            </nav>
        </div>

        <div class="card border-0 mb-4">
            <?php if($activeFilters): ?>
            <div class="card-body py-2">
                <div class="row">
                    <div class="col-md-2">
                        <h5 class="">
                            <?= $usersSubTotal ?>	
                            <small>Results</small>
                        </h5>
                    </div>
                    <div class="col-md-9">
                        <?php $filters = [] ?>
                        <?php foreach($filters as $filterTitle => $filter): ?>
                            <?php foreach($filter as $filterName => $filterData): ?>
                                <?php if($filterData['active']): ?>
                                <span class="badge chip">
                                    <b class="mr-1"><?= $filterTitle ?></b>
                                    <?= $filterName ?>
                                    <a class="close" href="<?= $filterData['removeLink'] ?>">
                                        <span aria-hidden="true">&times;</span>
                                    </a>
                                </span>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endforeach ?>
                        <a href="<?= current_url() ?>">Clear filters</a>
                    </div>
                </div>
            </div>
            <?php endif ?>

            <?php if (!$users): ?>
                <h5 class="card-body text-muted">Your filtering options returned no results.</h5>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody data-link="row" class="rowlink">
                            <?php foreach ($users as $user):?>
                                <tr id="<?= $user['id'] ?>">
                                    <td class="">
                                        <a href="<?= site_url('admin/users/edit/'.$user['id']) ?>">
                                            <img src="<?= base_url('image/'.$user['thumbnail']) ?>" alt="" class="rounded-circle mr-1"> <?= $user['username'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?= $user['email'] ?>
                                    </td>
                                    <td>
                                        <?= $user['group_name'] ?>
                                    </td>
                                    <td>
                                        <?php if($user['active']): ?>
                                            <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                            <span class="badge badge-danger">Inactive</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="rowlink-skip text-center">
                                        <button class="btn btn-sm btn-danger" type="submit" name="delete" value="submit">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>

                <?php if ($pagination): ?>
                    <div class="mt-3"><?= $pagination ?></div>
                <?php endif ?>
            <?php endif ?>
        </div>
    <?php echo form_close() ?>
<?php endif; ?>