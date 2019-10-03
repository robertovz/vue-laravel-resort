@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header login-header">{{ __('Login') }}</div>

                <div class="card-body form-piece">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row mt-2">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-4">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input mx-0" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label ml-1" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn-login">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


        <!-- Styles -->
        <style lang="scss">

            .login-header {
                color: #fff;
                font-size: 1rem;
                background: #3490dc!important;
                box-shadow: 0 3px 5px rgba(0, 0, 0, 0.7);
            }
      label{
          color: #2c3e50!important;
         font-size: 12px!important;
         font-weight: 600!important;
         text-transform: uppercase;
         transform: translateX(10px);
         transition: all 0.4s;
         cursor: text;
        }
        label .active {
            
            transform: translateX(120px);
            font-size: 10px;
        }

      input:not([type=submit]){
         background: none;
         outline: none;
         border: none;
         border-bottom: 1px solid #eee;
         color: #444;
         font-size: 15px;
         z-index: 1;
        }
        
        .btn-login {
            font-size: 13px;
            text-transform: uppercase;
            padding: 8px 30px;
            background: #3490dc;
            text-decoration: none;
            color: #fff;
            border-radius: 30px;
            border: none;
        }

        .btn-login:hover {
            background: #1681da;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.5);
        }

        </style>