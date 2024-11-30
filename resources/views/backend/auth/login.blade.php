@extends('backend.layouts.auth')

@section('styles')
<style type="text/css">
.invalid-feedback{
    display: block;
}
.auth-logo{
    height: 80px;
}
</style>
@endsection

@section('content')
<div class="m-login__container">
    <div class="m-login__logo">
        <a href="#">
        </a>
    </div>
    <div class="m-login__signin">
        <div class="m-login__head">
            <h3 class="m-login__title">Super Admin Sign In</h3>
        </div>

        @include('backend.layouts.partials.alert-messages')
        
        {!! Form::open(['route' => 'superadmin.login', 'class' => 'm-login__form m-form', 'id' => 'login-form']) !!}
        <div class="form-group m-form__group">
            {{ Form::text('email', null, array('class' => 'form-control m-input', 'placeholder' => 'Email', 'autocomplete' => 'off', 'autofocus')) }}
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group m-form__group">
            {{ Form::password('password', array('class'=>'form-control m-input m-login__form-input--last', 'placeholder' => 'Password' , 'autocomplete'=>'off') ) }}
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="row m-login__form-sub">
            <div class="col m--align-left m-login__form-left">
                <label class="m-checkbox  m-checkbox--light">
                    {{Form::checkbox('remember', true, old('remember') ? 'checked' : '' )}} Remember me
                    <span></span>
                </label>
            </div>
        </div>
        <div class="m-login__form-action">
            <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">Sign In</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
