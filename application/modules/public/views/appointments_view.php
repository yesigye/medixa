<?php
$breadcrumb = [];

if($this->ion_auth->in_group('manager')) array_push($breadcrumb, ['name'=>'Dashboard', 'link'=>'dashboard']);

array_push($breadcrumb, ['name'=>'Appointments', 'link'=>false]);

echo $this->load->view('public/templates/header', array(
	'title' => 'Appointments',
	'link' => 'appointments',
	'pageTitle' => 'My Appointments',
	'breadcrumb' => $breadcrumb,
	'styles' => [
		0 => '<link rel="stylesheet" href="'.base_url('assets/vendor/fullcalendar/fullcalendar.min.css').'" />',
	]
)); ?>

<div class="container">

	<?php $this->load->view('alert') ?>

    <?php if ( ! $appointments): ?>
        <h4 class="py-2 text-muted">
            <strong>You have no appointments scheduled</strong>
        </h4>	
    <?php endif ?>
    <div class="row">
		<div class="col-md-8">
			<div id="calendar" class="mb-5"></div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-header bg-secondary text-white">Upcoming appointments</div>
				<div class="card-body pb-0">
					<?php foreach($unread as $event): ?>
					<div class="row mb-3">
                        <div class="col-4 col-sm-4 col-md-3 col-lg-2 pr-0">
							<?php if($this->ion_auth->in_group('users')): ?>
                            <img src="<?= base_url('image/'.$event['doc_avatar']) ?>" class="img-fluid" data-toggle="tooltip" title="<?= $event['doc_username'] ?>">
							<?php else: ?>
                            <img src="<?= base_url('image/'.$event['avatar']) ?>" class="img-fluid" data-toggle="tooltip" title="<?= $event['username'] ?>">
							<?php endif ?>
                        </div>
                        <div class="col-12 col-sm-8 col-md-9 col-lg-10">
                            <b> <?= $event['title'] ?> </b>
							<div class="small text-truncate"><?= $event['message'] ?></div>
							<div class="text-muted">
								<span class="mr-2">due date : <?= nice_date($event['start_date'], 'D, d M Y') ?> </span>
							</div>
							<?php if(!$event['approved']): ?>
							<span class="text-warning mr-2">pending approval</span>
							<?php endif ?>
						</div>
                    </div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="editModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content border-0">
			<div class="modal-header bg-primary text-white">
				<h5 class="modal-title">Appointment details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?= form_open(current_url()) ?>
			<div class="modal-body">
				<p id="name"></p>
				<p id="description"></p>
				<div class="form-group form-inline">
					<label class="mr-2" for="start_date"><b>Date</b></label>
					<span id="editModalDate"></span>
                </div>
				<input type="hidden" name="eventid" id="event_id" value="0" />
			</div>
			<div class="modal-footer" id="editModalBtns">
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>

<script>

document.addEventListener("DOMContentLoaded", initCalendar);

function initCalendar() {
	$("#calendar").fullCalendar({
		themeSystem: "bootstrap4",
		header: {
			left: "prev,next today",
			center: "title",
			right: "month,agendaWeek,agendaDay,listMonth"
		},
		eventSources: [
			{
				color: "#18b9e6", 
				textColor: "#000000",
				events: function(start, end, timezone, callback) {
					$.ajax({
						url: "<?= base_url('appointments/api/events/'.$_SESSION['user_id']) ?>",
						dataType: "json",
						data: {
							start: start.unix(),
							end: end.unix()
						},
						success: function(msg) {
							var events = msg.events;
							callback(events);
						}
					});
				}
			}
		],
		eventClick: function(event, jsEvent, view) {
			$("#name").html(event.title);
			$("#description").html(event.message);
			
			var dateHtml = '';
			var	btnsHtml = '<input type="hidden" name="id" value="'+event.id+'" >';
			
			if(event.editable) {
				if (!event.approved) {
					dateHtml = `
						<input type="text" class="form-control" name="start_date" id="start_date" value="`+moment(event.start).format("MM/DD/YYYY")+`">
						`;
					dateHtml += '<div class="small text-muted mt-1">Update the date to change the date of the appointment</div>';

					btnsHtml += '<button type="submit" name="approve" value="approve" class="btn btn-primary">Approve</button>';
					btnsHtml += '<input type="hidden" name="user_id" value="'+event.user_id+'" >';
				} else {
					dateHtml = moment(event.start).format("MM/DD/YYYY");
					dateHtml += ' <span class="badge badge-success">Approved</span>';
				}
				btnsHtml += '<button type="submit" name="delete" value="delete" class="btn btn-danger">Remove</button>';
				$("#editModalBtns").html(btnsHtml);
			} else {
				dateHtml = moment(event.start).format("MM/DD/YYYY");
				btnsHtml += '<button type="submit" name="delete" value="delete" class="btn btn-danger">Cancel</button>';
			}
			$("#editModalBtns").html(btnsHtml);
			$("#editModalDate").html(dateHtml);
			$("#event_id").val(event.id);
			$("#editModal").modal();
		},
	})
}

</script>

<?php $this->load->view('public/templates/footer', [
	'scripts' => [
		'<script src="'.base_url('assets/vendor/fullcalendar/moment.min.js').'"></script>',
		'<script src="'.base_url('assets/vendor/fullcalendar/fullcalendar.min.js').'"></script>',
		'<script src="'.base_url('assets/vendor/fullcalendar/gcal.min.js').'"></script>',
	]
]) ?>