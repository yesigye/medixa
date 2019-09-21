<?php echo $this->load->view('public/templates/header', array(
	'title' => 'My Dashboard',
    'link' => 'dashboard',
)); ?>

<?php $this->load->view('sub_header', ['active' => 'physicians']) ?>

    <?php $this->load->view('templates/alerts') ?>
    
    <div class="row">
        <p class="col-6 text-muted mb-3">
            <b id="user-card-count"><?= $users_total ?></b> registered physicians
        </p>

        <div class="col-6 text-right">
            <button type="button" class="btn btn-outline-secondary mb-3" data-toggle="modal" data-target="#add-modal">
                <small>REGISTER A PHYSICIAN</small>
            </button>
        </div>
    </div>

    <?php
    // No Users returned and it is not a result of filtering
    if ( ! $users && ! $_SERVER['QUERY_STRING']): ?>
        <div class="my-3 text-muted">You have not registered any physicians</div>
    <?php else: ?>
        <?php if (!$users): ?>
            <div class="my-3 text-muted">
                Your filtering options returned no results.
                <?= anchor(current_url(), 'Reset filter') ?>
            </div>
        <?php else: ?>
            <ul class="list-group list-group-flush user-card-container mb-3">
            <?php foreach ($users as $user):?>
                <li class="list-group-item user-card" id="<?= $user['id'] ?>">
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                            <img src="<?= base_url('image/'.$user['avatar']) ?>" class="img-fluid">
                        </div>
                        <div class="col-12 col-sm-8 col-md-9 col-lg-10">
                            <b> <?= $user['first_name'] ?> </b> : <?= $user['speciality'] ?>
                            <div><?= $user['email'] ?></div>
                            <div class="mt-2 text-muted">
                                <span class="mr-2">registered on : <?= $user['created_on'] ?> </span>
                                <?php if($user['active']): ?>
                                    <b class="text-success">Active</b>
                                <?php else: ?>
                                    <b class="text-danger">Inactive</b>
                                    <div class="text-muted small">
                                        An email with account activation instructions was set to
                                        <?= $user['first_name'] ? $user['first_name'] : 'this user' ?>
                                    </div>
                                <?php endif ?>
                            </div>
                            <a href="<?= site_url('physicians/'.$user['reg_no'].'/'.$user['first_name'].'-'.$user['last_name']) ?>"
                            target="_blank" class="mt-2 btn btn-sm btn-outline-primary">Profile</a>
                            <?php if($user['active']): ?>
                            <button class="mt-2 btn btn-sm btn-outline-secondary user-card-deactivate">Suspend</button>
                            <?php else: ?>
                            <button class="mt-2 btn btn-sm btn-outline-danger user-card-activate">Activate</button>
                            <?php endif ?>
                            <button class="mt-2 btn btn-sm btn-outline-danger user-card-remove">Remove</button>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
            </ul>

            <?php if ($pagination) echo $pagination ?>
        <?php endif ?>
    <?php endif; ?>

</div>
</div>

<?php echo form_open_multipart(current_url()) ?>
<div class="modal fade" id="add-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Register a Physician</h5>
                <button type="reset" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php if (validation_errors() && $this->input->post('assign')): ?>
					<div class="alert alert-danger" data-trigger-modal="#add-modal">Correct the errors in the form and try again</div>
				<?php endif ?>
                <p class="text-muted">
                    The physician must activate their account to confirm registration.
                    Activation steps will be sent to the physician via email
                </p>

                <?php $this->load->view('form_fields', ['fields' => $form_fields]) ?>

                <?= $location_form ?>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" name="assign" value="submit">
                    <small>REGISTER</small>
                </button>
                <button class="btn btn-outline-danger" type="reset" data-dismiss="modal" aria-label="Close">
                    <small>CANCEL</small>
                </button>
            </div>    
        </div>
    </div>
</div>
<?php echo form_close() ?>

<script>
document.addEventListener("DOMContentLoaded", initActions);

function initActions() {
	$(".user-card-container").on('click', '.user-card-remove', function() {
        var card = $(this).closest('.user-card');
        var id = card.attr('id');
        $.ajax({
            url: "<?= base_url('hospitals/api/remove_user/'.$hospital_id.'/') ?>"+id,
            type: "DELETE",
            beforeSend: function() {
                card.addClass('el-wait')
            },
            success: function(response) {
                console.log(response)
                if (! response.error) {
                    card.remove()
                    $("#user-card-count").html($(".user-card").length)
                }
            },
            error: function(jxhr, status, text) {
                console.log(text)
            },
            complete: function(response) {
                card.removeClass('el-wait')
            },
        });
    })
    $(".user-card-container").on('click', '.user-card-deactivate', function() {
        var card = $(this).closest('.user-card');
        var id = card.attr('id');
        $.ajax({
            url: "<?= base_url('hospitals/api/deactivate_user/') ?>"+id,
            type: "DELETE",
            beforeSend: function() {
                card.addClass('el-wait')
            },
            success: function(response) {
                if (response.deleted) {
                    card.remove()
                    $("#user-card-count").html($(".user-card").length)
                }
                console.log(response)
            },
            error: function(jxhr, status, text) {
                console.log(text)
            },
            complete: function(response) {
                card.removeClass('el-wait')
                console.log(response)
            },
        });
    })
    $(".user-card-container").on('click', '.user-card-activate', function() {
        var card = $(this).closest('.user-card');
        var id = card.attr('id');
        $.ajax({
            url: "<?= base_url('hospitals/api/activate_user/') ?>"+id,
            type: "DELETE",
            beforeSend: function() {
                card.addClass('el-wait')
            },
            success: function(response) {
                if (response.deleted) {
                    card.remove()
                    $("#user-card-count").html($(".user-card").length)
                }
            },
            error: function(jxhr, status, text) {
                console.log(text)
            },
            complete: function(response) {
                card.removeClass('el-wait')
            },
        });
    })
}
</script>


<?php
$scriptCode = '<script>';
foreach ($locationTypes as $key => $type) {
    if ($key == 0) continue;
    $scriptCode .= '
    $("#'.$type['code'].'").remoteChained({
        parents : "#'.$locationTypes[$key-1]['code'].'",
        url : "'.site_url('api/locations/').'"
    });';
}
$scriptCode .= '</script>';

$this->load->view('public/templates/footer', [
    'scripts' => [
        '<script src="'.base_url('assets/js/jquery.chained.remote.min.js').'"></script>',
        $scriptCode
    ],
])
?>