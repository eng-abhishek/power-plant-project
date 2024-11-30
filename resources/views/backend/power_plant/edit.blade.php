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
			<h3 class="m-subheader__title">FAQ</h3>
		</div>
	</div>
</div>
<!-- END: Subheader -->

<div class="m-content">

	@include('backend.layouts.partials.alert-messages')

	@php
	$supported_languages = config('constants.supported_languages');
	@endphp

	<!--begin::Portlet-->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Edit FAQ
					</h3>
				</div>
			</div>
		</div>

		@php		
		$title = json_decode($record->getRawOriginal('title'),true);
		$description = json_decode($record->getRawOriginal('description'),true);
		@endphp
		
		<!--begin::Form-->
		{{ Form::model($record, array('route' => ['backend.faq.update', $record->id], 'id'=>'edit-faq-form', 'class' => 'm-form')) }}
		@method('PUT')
		<div class="m-portlet__body">	
			<div class="m-form__section m-form__section--first">

				@foreach($supported_languages as $key => $value)

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Title in {{$value}}:</label>
					<div class="col-lg-6">
						{{ Form::text('title['.$key.']', $title[$key] ?? '' , array('class' => 'form-control m-input', 'placeholder' => 'Title in '.$value, 'autocomplete' => 'off', 'autofocus')) }}
						@error('title')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				@endforeach

				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Slug:</label>
					<div class="col-lg-6">
						{{ Form::text('slug', null, array('class' => 'form-control m-input', 'placeholder' => 'Slug', 'autocomplete' => 'off', 'autofocus')) }}
						<span>Permalink : <a href="javascript:;">{{url('/faq')}}/{{$record->slug}}<span class="slug-text"></span></a></span>
						@error('slug')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

			   <div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Select Page Type:</label>
					<div class="col-lg-6">
						<select name="page_type" class="form-control">
						<option value="">--select--</option>
						<option {{ ($record->page_type == 'faq-page') ? 'selected' : ''}} value="faq-page">Faq Page</option>
					    <option {{ ($record->page_type == 'home-page') ? 'selected' : ''}} value="home-page">Home Page</option>
					    <option {{ ($record->page_type == 'all') ? 'selected' : ''}} value="all">All</option>
						</select>
						@error('page_type')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>

				@foreach($supported_languages as $key => $value)
				<div class="form-group m-form__group row">
					<label class="col-lg-3 col-form-label">Description in {{$value}}:</label>
					<div class="col-lg-6">
						{!! Form::textarea('description['.$key.']', ($description[$key]) ?? '', ['class'=>'form-control m-input', 'placeholder' => 'Description in '.$value, 'rows' => 3, 'cols' => 50]) !!}
						@error('description')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
						@enderror
					</div>
				</div>
				@endforeach

			</div>
		</div>
		<div class="m-portlet__foot m-portlet__foot--fit">
			<div class="m-form__actions m-form__actions">
				<div class="row">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<button class="btn btn-success">Submit</button>
						<a href="{{route('backend.faq.index')}}" class="btn btn-secondary">Cancel</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\FaqRequest', '#edit-faq-form'); !!}
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