@extends('admin.layout.auth')

@section('content')

<div class="col-lg-6">
    <div class="p-lg-5 p-4">
        <div>
            <h5 class="text-primary">Welcome Back !</h5>
            <p class="text-muted">{{ env('APP_NAME') }} Administrator Portal.</p>
        </div>

        <div class="mt-4">
            <form action="{{ url('/admin/login') }}" method="POST">
                @csrf
    
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{ old('email') }}" autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
    
                <div class="mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="float-end">
                        <a href="{{ url('/password/reset') }}" class="text-muted">Forgot password?</a>
                    </div>
                    <label class="form-label" for="password-input">Password</label>
                    <div class="position-relative auth-pass-inputgroup mb-3">
                        <input type="password" class="form-control pe-5" placeholder="Enter password" name="password" id="password-input">
                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                    </div>
    
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                </div>
    
                <div class="form-check">
                    <input class="form-check-input" name="remember" type="checkbox" value="" id="auth-remember-check">
                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                </div>
    
                <div class="mt-4">
                    <button class="btn btn-success w-100" type="submit">Sign In</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- end col -->
@endsection
