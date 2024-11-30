@extends('layouts.app')

@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<h3 class="m-subheader__title">Power Scheduling</h3>
		</div>
	</div>
</div>
<!-- END: Subheader -->

<div class="m-content">
	
	@include('layouts.partials.alert-messages')

	<!--begin::Portlet-->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						{{-- Department List --}}
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="m-portlet__nav">
					
					<li class="m-portlet__nav-item">
						<a href="{{route('schedule-report')}}" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
							<span>
								<span>Click To Download Excel Report</span>
							</span>
						</a>
					</li>
					<li class="m-portlet__nav-item">
						<a href="javascript:void(0)" data-toggle="modal" data-target="#create_schedule" class="btn btn-focus m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
							<span>
								<span>Create Power Plant</span>
							</span>
						</a>
					</li>
					<li class="m-portlet__nav-item"></li>
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			
			<!--begin: Search Form -->
			{{-- <form class="m-form m-form--fit m--margin-bottom-20">
				<div class="row m--margin-bottom-20">
					<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
						{{ Form::select('status', collect($status)->prepend('Select status', ''), null, array('class' => 'form-control m-input filter_status')) }}
					</div>
					<div class="col-lg-3 offset-md-6 m--margin-bottom-10-tablet-and-mobile">
						<button type="button" class="btn btn-brand m-btn m-btn--icon" id="submit_filters">
							<span>
								<i class="la la-search"></i>
								<span>Search</span>
							</span>
						</button>
						&nbsp;&nbsp;
						<button type="button" class="btn btn-secondary m-btn m-btn--icon" id="reset_filters">
							<span>
								<i class="la la-close"></i>
								<span>Reset</span>
							</span>
						</button>
					</div>
				</div>
			</form> --}}
			<!--end: Search Form -->
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>No</th>
						<th>Plant Name</th>
						<th>Schdule Power</th>
						<th>Date</th>
						<th>Created At</th>
						<th width="100px">Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>	
			</table>
			<!--end: Datatable -->
		</div>	
	</div>
	<!--end::Portlet-->

	<!--begin::Modal-->
	<div class="modal fade" id="create_schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Create Schedule</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					{{ Form::open(array('route' => 'schedule.store', 'id'=>'add-schedule-form', 'class' => 'm-form')) }}
					<div class="m-portlet__body">	
						<div class="m-form__section m-form__section--first">

							<div class="form-group m-form__group row">
								<label class="col-lg-3 col-form-label">Select Plan:</label>
								<div class="col-lg-6">
									<select class="form-control" name="plant_id">
										<option value="">--select--</option>
										@if(isset(($plants)))
										@foreach($plants as $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
										@endif
									</select>
									@error('plant_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>		       

							<div class="form-group m-form__group row">
								<label class="col-lg-3 col-form-label">Date:</label>
								<div class="col-lg-6">
									<input type="date" name="date" class="form-control">
									@error('date')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="form-group m-form__group row">
								<label class="col-lg-3 col-form-label">Power:</label>
								<div class="col-lg-6">
									{{ Form::text('scheduled_power', null, array('class' => 'form-control m-input', 'placeholder' => 'please enter power', 'autocomplete' => 'off', 'autofocus')) }}

									@error('slug')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>

							<div class="form-group m-form__group row">
								<label class="col-lg-3 col-form-label">Number of Blocks:</label>
								<div class="col-lg-6">
									<div class="row">
										<div class="col-lg-9">
											<input type="range" name="block_range" class="form-control-range py-3" min="1" max="96" id="block_range" value="96">
										</div>
										<div class="col-lg-3">
											<span class="input-group-text ml-3" id="block_text">96</span>
										</div>
									</div>
									@error('block_range')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<!--begin::Modal-->
	<div class="modal fade" id="edit_schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content edit-modal-data">

			</div>
		</div>
	</div>
	<!--end::Modal-->
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Frontend\PowerScheduleRequest', '#add-schedule-form'); !!}
<script type="text/javascript">
	$(document).ready(function(){

		var table = $('#m_table_1').DataTable({
			processing: true,
			serverSide: true,
			ajax:{
				url:"{{ route('schedule-ajax-listing') }}",
				data: function (d) {
					d.search = $('input[type="search"]').val()
				}
			},
			columns: [
			{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
			{data: 'plantname', name: 'plantname'},
			{data: 'scheduled_power', name: 'scheduled_power'},
			{data: 'date', name: 'date'},
			{data: 'created_at', name: 'created_at'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
			]
		});

		/* Delete record */
		$(document).on('click', '.delete-record', function (e) {
			var url = $(this).data('url');

			swal({ 
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, delete it!"
			}).then(function (e) {
				if(e.value){
					mApp.blockPage({
						overlayColor: "#000000",
						type: "loader",
						state: "success",
						message: "Please wait..."
					});

					$.ajax({
						headers: {
							'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
						},
						type: "delete",
						url: url,
						success: function (result) {
							mApp.unblockPage();
							if (result.status == 'success') {
								table.draw();
								toastr.success(result.message);
							} else {
								toastr.error(result.message);
							}
						},
						error: function (jqXHR, textStatus, errorThrown) {
							mApp.unblockPage();
						}
					});
				}
			});
		});
	
	$('#block_range').on('change', function() {
		$('#block_text').html($(this).val());
	});

		$("#add-schedule-form").on('submit',function(){

			mApp.blockPage({
				overlayColor: "#000000",
				type: "loader",
				state: "success",
				message: "Please wait..."
			});

			var url = $("#add-schedule-form").attr('action');

			$.ajax({
				headers: {
					'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
				},
				url:url,
				method:'post',
				data:$('#add-schedule-form').serialize(),
				success: function (result) {
					$("#create_schedule").modal("hide");
					mApp.unblockPage();
					if (result.status == 'success') {
						table.draw();
						toastr.success(result.message);
					} else {
						toastr.error(result.message);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					$("#create_schedule").modal("hide");
					mApp.unblockPage();
				}
			})
			return false;
		});
	

		$(document).on('click', '.edit-record', function (e) {

		var url = $(this).data('url');

		$.ajax({
		headers: {
		'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
		},
		type: "get",
		url: url,
		success: function (result) {
		mApp.unblockPage();
		if (result.status == 'success') {
		$('.edit-modal-data').html(result.data);
		$('#edit_schedule').modal('show');
		}
		},
		error: function (jqXHR, textStatus, errorThrown) {
		mApp.unblockPage();
		}
		});

		})

	});
</script>
@endsection