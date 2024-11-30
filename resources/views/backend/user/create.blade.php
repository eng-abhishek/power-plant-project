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
			<h3 class="m-subheader__title">User Management</h3>
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
						Create User
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{{ Form::open(array('route' => 'superadmin.user.store', 'id'=>'add-user-form', 'class' => 'm-form')) }}
		<div class="m-portlet__body">	
			<div class="m-form__section m-form__section--first">

	            <div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">User Name:</label>
					<div class="col-lg-6">
						{{ Form::text('name', null, array('class' => 'form-control m-input', 'placeholder' => 'please enter user name', 'autocomplete' => 'off', 'autofocus')) }}
						
						@error('slug')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

	            <div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">User Email:</label>
					<div class="col-lg-6">
						{{ Form::text('email', null, array('class' => 'form-control m-input', 'placeholder' => 'please enter user email', 'autocomplete' => 'off', 'autofocus')) }}

						@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Password:</label>
					<div class="col-lg-6">
						{{ Form::text('password', null, array('class' => 'form-control m-input', 'placeholder' => 'please enter user password', 'autocomplete' => 'off', 'autofocus')) }}

						@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Select Role:</label>
					<div class="col-lg-6">
						<select class="form-control" name="role">
							<option value="">--select--</option>
							<option value="admin">Admin</option>
							<option value="user">User</option>
						</select>
						@error('role')
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
						<a href="{{route('superadmin.user.index')}}" class="btn btn-secondary">Cancel</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\UserRequest', '#add-user-form'); !!}
@endsection