<?php
$action_button = '<button type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#user-create-modal">'.lang('btn_create').'</button>';

$this->load->view('admin/header', array(
	'title' => $this->lang->line('menu_users'),
	'pageTitle' => $this->lang->line('menu_users').$action_button,
	'link' => 'users',
	'breadcrumb' => array(
		0 => array('name'=> $this->lang->line('menu_users'), 'link'=>FALSE),
	),
	'styles' => array(
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/datatables.min.css').'">',
		'<link rel="stylesheet" href="'.base_url('assets/vendor/datatables/dataTables.checkboxes.css').'">',
	)
)); ?>

<div class="table-responsive mt-3">
	<table class="table" id="table">
		<thead>
			<tr>
				<th>Id</th>
				<th> <i class="fa fa-image"></i> </th>
				<th><?php echo lang('form_users_email') ?></th>
				<th><?php echo lang('form_group_name') ?></th>
				<th><?php echo lang('form_users_status') ?></th>
				<th><?php echo lang('table_action') ?></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

<form method="POST" class="needs-validation" id="user-create" novalidate>
	<div class="modal fade" id="user-create-modal" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content border-0">
				<div class="modal-header">
					<b><?php echo lang('title_create_user') ?></b>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="text-muted">
						<?php echo lang('subtitle_create_user') ?>
					</p>
					<div class="error-message"></div>

					<?php echo $this->load->view('form_fields', ['fields' => $form_fields]) ?>
					
					<button type="submit" name="add_user" value="ADD" class="btn btn-block btn-success mt-2">
						<?php echo lang('btn_create') ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
	// Define new create item modal
	var create_modal = $('#user-create-modal');
	
	// Define datatable
	const table = $('#table').DataTable({
		"processing": true,
		"serverSide": true,
		"rowId": 'id',
		"pageLength": <?php echo $this->app->pageLimit ?>,
		"ajax": "<?php echo site_url('users/api') ?>",
		dom: 'Bfrtip',
		buttons: [
			{
				extend: "colvis",
				className: "btn-sm btn-secondary",
				titleAttr: 'Toggle visible columns',
				text: 'Columns'
			},
			{
				extend: "copy",
				className: "btn-sm btn-secondary",
				titleAttr: 'Copy to clipboard',
				text: 'Copy'
			},
			{
				extend: "excel",
				className: "btn-sm btn-secondary",
				titleAttr: 'Export in Excel',
				text: 'Excel'
			},
			{
				extend: "pdf",
				className: "btn-sm btn-secondary",
				titleAttr: 'Export in PDF',
				text: 'PDF'
			},
			{
				extend: 'selected',
				text: '<?php echo lang('btn_delete_selected') ?>',
				className: "btn-sm btn-danger",
				action: function ( e, dt, button, config ) {
					// Delete multiple selected items
					$.ajax({
						url: '<?php echo base_url('users/api/delete') ?>',
						type: 'POST',
						data: {
							ids: table.columns().checkboxes.selected()[0],
							'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>'
						},
						success: function(result) {
							table.rows('.selected').deselect().draw();
						},
					});
				}
			}
		],
		columns: [
            { data: "id" },
            {
				data: "thumbnail",
                className: "text-center",
                render: function (data, type, row) {
					return '<img src="'+data+'" style="width:30px">';
				}
			},
            { data: "email" },
            { data: "group" },
            {
				data: "active",
                className: "text-center",
                render: function (data, type, row) {
					return '<i class="fa '+((data == 1) ? 'fa-check-circle text-success' : 'fa-times-circle text-danger')+'"></span>';
				}
			},
            { 
				data: "action",
                className: "text-center"
			},
        ],
		columnDefs: [{
			targets: 0,
			checkboxes: {
				selectRow: true,
			}
		}],
		select: {
			style: 'multi'
		},
		order: [[1, 'asc']],
		"drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-sm');
        }
	});

	// Insert item to datatable
	$("#user-create").datatableInsert({
		table: table,
		formId: "user-create",
		alertId: 'app-notif',
		modal: create_modal,
		urlCreate: '<?php echo site_url('users/api/create') ?>',
		csrf_token: '<?php echo $this->security->get_csrf_token_name() ?>',
		csrf_hash: '<?php echo $this->security->get_csrf_hash() ?>',
	});

	// Delete item from datatable
	$('#table').on('click', '.delete-row', function() {
		var row = $(this).parents('tr');
		// AJAX to delete item
		$.ajax({
			url: '<?php echo base_url('users/api/delete/') ?>'+row.attr('id'),
			type: 'DELETE',
			success: function(result) {
				table.row(row).deselect().remove().draw();
			},
		});
	});

	create_modal.on('shown.bs.modal', function (e) {
		$(this).first('input').focus();
	})
});
</script>

<?php $this->load->view('admin/footer', [
	'scripts' => [
		'<script type="text/javascript" src="'.base_url('assets/vendor/datatables/datatables.min.js').'"></script>',
		'<script type="text/javascript" src="'.base_url('assets/vendor/datatables/dataTables.checkboxes.min.js').'"></script>',
		'<script type="text/javascript" src="'.base_url('assets/js/app.datatables.js').'"></script>'
	]
]) ?>



@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Destination Banks')
{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-users.css')}}">
@endsection
@section('content')
<!-- banks list start -->
<section class="banks-list-wrapper">
    <h4>Destination Banks</h4>
    <hr>
    <div class="banks-list-table">
        <div class="card">
        <div class="card-body">
            <!-- datatable start -->
            <div class="table-responsive">
                <table id="banks-list-datatable" class="table">
                    <thead>
                    <tr>
                        <th>Bank Name</th>
                        <th>Destination</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- datatable ends -->
        </div>
        </div>
    </div>
</section>
<!-- banks list ends -->
@foreach ($banks as $bank)
{{-- Edit user roles modal --}}
<div class="modal fade" id="edit-modal{{ $bank->id }}" tabindex="-1" aria-labelledby="edit-modalTitle{{ $bank->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modalTitle{{ $bank->id }}">Edit Destination Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="bx bx-x"></i>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ url('config/banks') }}">
          @csrf
          @method('put')
          <input type="hidden" name="id" value="{{ $bank->id }}">
          <div class="form-group">
            <label for="destination">Destination</label>
            <select class="form-control" name="destination" id="field-edit-destination">
              @foreach ($destinations as $destination)
                <option value="{{ $destination->id }}">{{ $destination->country->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="name">Bank name</label>
            <input
            type="text"
            name="bank"
            id="field-edit-bank"
            class="form-control"
            placeholder="Enter bank name"
            value="{{$bank->name}}">
          </div>
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Save</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
    <script src="{{asset('assets/js/global.js')}}"></script>
    <script src="{{asset('js/scripts/pages/app-users.js')}}"></script>
    @error('description')
        <script>$('#create-modal').modal("show")</script>
    @enderror
    <script>

        function editBank(data) {
            console.log(data)
        }
    document.addEventListener("DOMContentLoaded", function() {

        // Define new create item modal
        var create_modal = $('#user-create-modal');
        
        // Define datatable
        const table = $('#banks-list-datatable').DataTable({
            "rowId": 'id',
            data: JSON.parse(`<?= $banks->toJson() ?>`),
            columns: [
                { data: "name" },
                {
                    data: "destination",
                    className: "text-center",
                    render: function (destination, type, row) {
                        return destination.country.name
                    }
                }
            ],
            columnDefs: [{
                targets: 2,
                className: "text-center",
                render: function(data, type, row, meta) {
                    let template = '';

                    if(type === 'display') {
                        template = `
                            <a href="#" onclick="editBank(this)">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                        `;
                    }

                    return template;
                }
            }],
            select: {
                style: 'multi'
            },
            order: [[1, 'asc']],
            "drawCallback": function () {
                $('.dataTables_paginate > .pagination').addClass('pagination-sm');
            }
        });

        // Delete item from datatable
        $('#table').on('click', '.delete-row', function() {
            var row = $(this).parents('tr');
            // AJAX to delete item
            $.ajax({
                url: '' + row.attr('id'),
                type: 'DELETE',
                success: function(result) {
                    table.row(row).deselect().remove().draw();
                },
            });
        });

        create_modal.on('shown.bs.modal', function (e) {
            $(this).first('input').focus();
        })
    });
    </script>
@endsection
