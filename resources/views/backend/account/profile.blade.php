@extends('backend.layouts.app')

@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<h3 class="m-subheader__title">My Profile</h3>
		</div>
	</div>
</div>
<!-- END: Subheader -->

<div class="m-content">

	@include('backend.layouts.partials.alert-messages')
	
	<!--begin::Portlet-->
	<div class="m-portlet m-portlet--mobile">

		<!--begin::Form-->
		{{ Form::model($record, array('route' => 'backend.account.profile.update', 'method' => 'post', 'id'=>'update-profile-form', 'class' => 'm-form', 'files' => true)) }}
		<div class="m-portlet__body">	
			<div class="m-form__section m-form__section--first">
				
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Name:</label>
					<div class="col-lg-6">
						{{ Form::text('name', null, array('class' => 'form-control m-input', 'placeholder' => 'Fullname', 'autocomplete' => 'off', 'autofocus')) }}
						@error('name')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Email address:</label>
					<div class="col-lg-6">
						{{ Form::text('email', null, array('class' => 'form-control m-input', 'placeholder' => 'Email', 'autocomplete' => 'off', 'disabled' => true)) }}
						@error('email')
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
						<a type="{{route('backend.account.profile.view')}}" class="btn btn-secondary">Cancel</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\UpdateProfileRequest', '#update-profile-form'); !!}
<script type="text/javascript">
	$(document).ready(function(){

		/* Preview Image */
		$('input[name="avatar"]').change(function(e) {
			var preview = $(this).data('preview');
			var file = $(this).get(0).files[0];

			if(file){
				var reader = new FileReader();

				reader.onload = function(){
					$(preview).attr("src", reader.result).show();
				}

				reader.readAsDataURL(file);
			}	
		});

		/* Remove Image */
		$('.remove-image').click(function(e){
			var this_ele = $(this);
			var url = this_ele.data('url');

			swal({ 
				title: "Are you sure?",
				text: "Are you sure you want to remove this image",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, remove it!"
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
						type: "post",
						url: url,
						success: function (result) {
							mApp.unblockPage();
							if (result.status == 'success') {
								$('#view-featured-image').attr('src', result.image);
								this_ele.remove();
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

	});

</script>
@endsection