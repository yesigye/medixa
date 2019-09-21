<?php echo form_open_multipart(site_url('admin/hospitals/types'), array('id' => '89yw2')) ?>
    <?php echo form_hidden('id', $type->id) ?>
    <div class="form-group">
        <label class="control-label" for="parent">Type Level</label>
        <select name="parent" class="form-control <?php echo ($this->input->post('update_type') AND form_error('parent')) ? 'has-error' : '' ?>">
                <option value="" <?php echo set_select('parent', '') ?>>None</option>
            <?php foreach ($types_list as $row): ?>
                <option value="<?= $row['id'] ?>" <?php echo set_select('parent', $row['id'], ($row['id'] === $type->parent_id) ? TRUE : FALSE) ?>><?= $row['name'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-group <?php echo ($this->input->post('update_type') AND form_error('name')) ? 'has-error' : '' ?>">
        <label class="control-label" for="name">Name</label>
        <input name="name" class="form-control" value="<?php echo set_value('name') ? set_value('name') : $type->name ?>" >
    </div>
    <div class="form-group <?php echo ($this->input->post('update_type') AND form_error('description')) ? 'has-error' : '' ?>">
        <label class="control-label" for="description">Description</label>
        <textarea name="description" class="form-control"><?php echo set_value('description') ? set_value('description') : $type->description ?></textarea>
    </div>
    <div class="form-group <?php echo ($this->input->post('add_type') AND form_error('facilities')) ? 'has-error' : '' ?>">
        <div><label class="control-label" for="facilities">Facilities</label></div>
        <?php foreach ($facilities as $row): ?>
            <span class="thumbnail" style="display:inline-block;margin-bottom:10px">
                <?php echo $row->name ?>
                <button type="button" class="btn btn-xs btn-info" data-toggle="popover" data-trigger="focus" title="Inherited Service"
                data-content="This service has been inherited from the level '<?php echo $row->parent->name ?>'. Go to that level to edit or deleted it.">
                    <i class="fa fa-info-circle"></i>
                </button>
            </span>
        <?php endforeach ?>
        <?php $this->load->view('admin/type_edit_thumbnails_view', array(
            'facilities' => $type->facilities,
        )) ?>
        <span class="app-89yw2-input"></span>
        <div class="form-group input-group">
            <input type="text" name="facilities" class="form-control" placeholder="e.g.  x-ray, laboratory" value="<?php echo set_value('facilities') ?>">
            <span class="input-group-btn">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-success app-89yw2-add" data-id="<?php echo $type->id ?>">
                        Add Facilities
                    </button>
                </div>
            </span>
        </div>
        <p class="help-block">Separate each value with a comma.</p>
    </div>
    <input type="submit" name="update_type" class="btn btn-lg btn-block btn-primary" >
<?php echo form_close() ?>

<script type="text/javascript">
    $(function () {
        $('[data-toggle="popover"]').popover()
        var ID = $(this).attr('data-id');
        var button = $(this);
        $.ajax({
            type: 'POST',
            data: {
                <?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                delete_type: true,
                id: ID
            },
            url: '<?php echo current_url(); ?>',
            cache: true,
            beforeSend: function(){
                button.html('<span class="fa fa-spinner"></span>')
            },
            success: function(response) {
                response = JSON.parse(response)
                if(response.type) {
                    if (response.type === 'success') {
                        button.closest('div').addClass('animated zoomOut');
                        setTimeout(function(){
                            button.closest('div').remove();
                        }, 400)
                    }else {
                        $('#ajax-alert-modal #message').html(response.message)
                        $('#ajax-alert-modal').modal('show')
                        button.html('[delete]')
                    }
                }
            },
            error: function() {
                $('#ajax-alert-modal #message').html('An error Occured')
                $('#ajax-alert-modal').modal('show')
                button.html('[delete]')
            }
        });

        $('.app-89yw2-add').click(function(){
            var ID = $(this).attr('data-id');
            var input = $(this).closest('.form-group').find('input');
            var value = input.val();
            var button = $(this);

            $.ajax({
                type: 'POST',
                data: {
                    <?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                    add_type_facilities: true,
                    id: ID,
                    facilities: value,
                },
                url: '<?php echo site_url("admin/hospitals/types"); ?>',
                cache: true,
                beforeSend: function(){
                    button.append('<span class="fa fa-spinner"></span>')
                },
                success: function(response) {
                    try {
                        response = JSON.parse(response)
                        $('#ajax-alert-modal #message').html(response.message)
                        $('#ajax-alert-modal').modal('show')
                        button.html('<i class="fa fa-plus"></i>')
                    } catch(e) {
                        $('.app-89yw2-input').append(response)
                        input.val('')
                        button.html('Add Facilities')
                    }
                },
                error: function() {
                    $('#ajax-alert-modal #message').html('An error Occured')
                    $('#ajax-alert-modal').modal('show')
                    button.html('Add Facilities')
                }
            });
        })
    })
</script>