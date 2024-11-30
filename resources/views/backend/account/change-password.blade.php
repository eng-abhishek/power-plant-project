@extends('backend.layouts.app')

@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<h3 class="m-subheader__title">Change Password</h3>
		</div>
	</div>
</div>
<!-- END: Subheader -->

<div class="m-content">

	@include('backend.layouts.partials.alert-messages')
	
	<!--begin::Portlet-->
	<div class="m-portlet m-portlet--mobile">

		<!--begin::Form-->
		{{ Form::open(array('route' => 'backend.account.change-password.update', 'method' => 'post', 'id'=>'change-password-form', 'class' => 'm-form')) }}
		<div class="m-portlet__body">	
			<div class="m-form__section m-form__section--first">
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Current Password:</label>
					<div class="col-lg-6">
						{{ Form::password('current_password', array('class'=>'form-control m-input', 'placeholder' => 'Current Password' , 'autocomplete'=>'off', 'autofocus') ) }}
						@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">New Password:</label>
					<div class="col-lg-6">
						{{ Form::password('password', array('class'=>'form-control m-input', 'placeholder' => 'New Password' , 'autocomplete'=>'off') ) }}
						@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Confirm Password:</label>
					<div class="col-lg-6">
						{{ Form::password('password_confirmation', array('class'=>'form-control m-input m-login__form-input--last', 'placeholder' => 'Confirm Password' , 'autocomplete'=>'off') ) }}
						@error('password_confirmation')
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
						<a type="{{'/'}}" class="btn btn-secondary">Cancel</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\ChangePasswordRequest', '#change-password-form'); !!}
@endsection