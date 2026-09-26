@extends('layout.master')
{{-- Metadata --}}
@section('title', config('app.name'))
@section('description', 'Iniciar-sesion.')
@section('canonical', config('app.url'))
@section('class', 'home')
@section('content')
<section class="section">
    
    <div class="container">
        <div class="login-form flex-col">            
            <form class="form-boxed" method="POST" action="{{ route('login') }}">
                @csrf
                <h1 class="h3 text-center">Iniciar Sesión</h1>
                <hr></hr>
                <div class="form-control mb-2">
                    <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('User name') }}</label>
                    <input id="username" type="text" class="form-field form-input @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-control mb-2">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input id="password" type="password" class="form-field form-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="padding-right: 40px;">

                        <button type="button" id="togglePassword" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer;">
                            <img style="filter:invert(1);" id="eyeClosedIcon" src="{{ asset('img/svg/eye-closed.svg') }}" width="24" height="24" alt="Cerrar ojo">
                            <img id="eyeOpenIcon" src="{{ asset('img/svg/eye-open.svg') }}" width="24" height="24" alt="Abrir ojo" style="display: none;">
                        </button>
                    </div>




                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row mb-4 justify-between items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label text_remember" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    
                </div>
                <div class="text-center">

                    <button type="submit" class="hero-btn w-100">

                        <span>

                            <i class="fa-solid fa-right-to-bracket"></i>

                            Iniciar Sesión

                        </span>

                    </button>

                </div>
            
            </form>
        </div>
                
          
    </div>
</section>
@endsection
@section('scripts')
    <script>

        document.getElementById('togglePassword').addEventListener('click', function () {
            let passwordField = document.getElementById('password');
            let eyeClosed = document.getElementById('eyeClosedIcon');
            let eyeOpen = document.getElementById('eyeOpenIcon');

            

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeClosed.style.display = "none";
                eyeOpen.style.filter = "invert(1)";

                eyeOpen.style.display = "block";
            } else {
                passwordField.type = "password";
                eyeClosed.style.display = "block";
                eyeClosed.style.filter = "invert(1)";
                eyeOpen.style.display = "none";
            }
        });
    </script>




@endsection
