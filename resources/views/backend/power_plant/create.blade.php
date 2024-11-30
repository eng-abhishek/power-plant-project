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
			<h3 class="m-subheader__title">Power Plant</h3>
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
						Create Power Plant
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{{ Form::open(array('route' => 'superadmin.powerplant.store', 'id'=>'add-powerplant-form', 'class' => 'm-form')) }}
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
					<label class="col-lg-3 col-form-label">Plan Name:</label>
					<div class="col-lg-6">
						{{ Form::text('name', null, array('class' => 'form-control m-input', 'placeholder' => 'please enter plant name', 'autocomplete' => 'off', 'autofocus')) }}
						
						@error('slug')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Select Category:</label>
					<div class="col-lg-6">
						<select name="category" class="form-control">
							<option value="">--select--</option>
							<option value="thermal">Thermal</option>
							<option value="solar">Solar</option>
							<option value="hydro">Hydro</option>
							<option value="renewable">Renewable</option>
							<option value="non-renewable">Non-Renewable</option>
						</select>
						@error('category')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Select Technology:</label>
					<div class="col-lg-6">
						<select name="technology" class="form-control">
							<option value="">--select--</option>
							<option value="photovoltaic">Photovoltaic</option>
							<option value="coal-fired">Coal-fired</option>
						</select>
						@error('technology')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Capacity:</label>
					<div class="col-lg-6">
						{{ Form::text('capacity', null, array('class' => 'form-control m-input', 'placeholder' => 'please enter capacity', 'autocomplete' => 'off', 'autofocus')) }}
						
						@error('capacity')
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
						<a href="{{route('superadmin.powerplant.index')}}" class="btn btn-secondary">Cancel</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\PowerPlantRequest', '#add-powerplant-form'); !!}
<script type="text/javascript">

	$('input[name="title"]').keyup(function(){
		var slug = slugify($(this).val());
		$('input[name="slug"]').val(slug);
		$('.slug-text').text(slug);
	});

	$('input[name="slug"]').keyup(function(){
		$('.slug-text').text(slugify($(this).val()));
	});

</script>
@endsection