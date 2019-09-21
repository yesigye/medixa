(function ( $ ) {
    $.fn.datatableInsert = function( options ) {
        // These are the defaults.
        var settings = $.extend({
            modal: null
        }, options );
        
        var form = document.getElementById(this.attr('id'));

        if (form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.stopPropagation();
                } else {
                    form.classList.add('was-validated');
                    var form_data = new FormData(form);
                    form_data.append(options.csrf_token, options.csrf_hash);
                    // fd.append('file', input.files[0]);
                    $.ajax({
                        url: options.urlCreate,
                        data: form_data,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        beforeSend: function() {
                            $('#'+form.id).find("button[type='submit']").prop('disabled',true);
                        },
                        success: function(response) {
                            console.log(response)
                            if (response.error) {
                                var el_error = $('#'+form.id).find('.error-message');
                                el_error.html(tmplAlert(response.message, 'danger'));
                                $('html, body').animate({ scrollTop: el_error.offset().top }, 1000);
                            } else {
                                options.table.ajax.reload();
                                if(settings.modal) settings.modal.modal('hide')
                                form.reset();
                                form.classList.remove('was-validated');
                                $('#'+options.alertId).html(tmplAlert(response.message));
                                setTimeout(function(){$('#'+settings.alertId).html('')}, 5500);
                                $('html, body').animate({ scrollTop: $('#'+settings.alertId).offset().top }, 1000);
                            }
                        },
                        error: function(response) {
                            console.log(response)
                        },
                        complete: function() {
                            $('#'+form.id).find("button[type='submit']").prop('disabled', false);
                        }
                    });
                }
                event.preventDefault();
            }, false);
        }
 
        function deleteSelected() {
            var selected = table.columns().checkboxes.selected()[0];
            // AJAX to delete selected item
            $.ajax({
                url: urlDelete,
                type: 'POST',
                data: {
                    ids: selected,
                    csrf_token: csrf_hash
                },
                success: function(result) {
                    table.rows('.selected').deselect().draw();
                },
            });
        };

        return this;
    };
}( jQuery ));