@extends('backend.layouts.app')
@section('styles')
<style type="text/css">
	.invalid-feedback{
		display: block;
	}
</style>
@endsection
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

	@include('backend.layouts.partials.alert-messages')

	<!--begin::Portlet-->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Create Power Scheduling
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{{ Form::open(array('route' => 'superadmin.schedule.store', 'id'=>'add-schedule-form', 'class' => 'm-form')) }}
		<div class="m-portlet__body">	
			<div class="m-form__section m-form__section--first">

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Select User:</label>
					<div class="col-lg-6">
						<select class="form-control" name="user_id">
							<option value="">--select--</option>
						    @if(isset(($users)))	
							@foreach($users as $value)
							<option value="{{$value->id}}">{{$value->name}}</option>
							@endforeach
						    @endif
						</select>
						@error('user_id')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>	

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
		<div class="m-portlet__foot m-portlet__foot--fit">
			<div class="m-form__actions m-form__actions">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<button class="btn btn-success">Submit</button>
						<a href="{{route('superadmin.schedule.index')}}" class="btn btn-secondary">Cancel</a>
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}
		<!--end::Form-->
	</div>
	<!--end::Portlet-->
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Backend\PowerScheduleRequest', '#add-schedule-form'); !!}

<script type="text/javascript">
	
	$('#block_range').on('change', function() {
		$('#block_text').html($(this).val());
	});

	// 	$('#width_range').on('change', function() {
	// 	$('#width_text').html($(this).val());
	// });

	// $('#block_range').on('change', function() {
	// 	$('#edit_widget_model #width_text').html($(this).val() + 'px');
	// });

</script>

@endsection