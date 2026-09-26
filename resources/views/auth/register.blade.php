@extends('layout.master')
@section('title', config('app.name'))
@section('description', 'Registro.')
@section('canonical', config('app.url'))
@section('class', 'home')
@section('content')
<div class="section" style="height:auto;">
    <div class="container">
        <div class="login-form flex-col"> 
            <img class="login-image" src="{{ url('img/advantage-logo.png') }}" alt="">       
            <form class="form-boxed" method="POST" action="{{ route('register') }}">
                @csrf
                <h1 class="h3 text-center">Registro</h1>
                <hr></hr>
                <div class="form-control mb-2">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-field form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-control mb-2">
                    <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Apellidos') }}</label>
                    <input id="last_name" type="text" class="form-field form-input @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-control mb-2">
                    <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Nombre de usuario') }}</label>
                    <input id="username" type="text" class="form-field form-input @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-control mb-2">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo electrónico') }}</label>
                    <input id="email" type="mail" class="form-field form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-control mb-2">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-field form-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-control mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-field form-input" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="text-center">

                    <button type="submit" class="hero-btn w-100">

                        <span>

                            <i class="fa-solid fa-right-to-bracket"></i>

                            {{ __('Register') }}

                        </span>

                    </button>

                </div>
            </form>
        </div>
    </div>
</div>

@endsection
