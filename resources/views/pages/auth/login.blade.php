@extends('pages.layouts.app')

@section('content')
    <div class="mb-600">
        <div class="col-sm-4 col-sm-offset-1">
            <div class="login-form"><!--login form-->
                <h2>Đăng nhập</h2>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form-label lead" for="email-login">Email</label>
                        <input type="text" name="email" id="email-login" placeholder="Nhập email"/>
                    </div>

                    <div class="form-group">
                        <label class="form-label lead" for="password-login">Mật khẩu</label>
                        <input type="password" name="password" id="password-login" placeholder="Nhập mật khẩu"/>
                    </div>
                    <span>
                    <input type="checkbox" class="checkbox" name="remember" id="remember">
                        <label for="remember" class="form-label lead mt-2">Lưu đăng nhập</label>
                    </span>
                    <button type="submit" class="btn btn-default" style="font-size: 15px">Đăng nhập</button>
                </form>
            </div><!--/login form-->
        </div>
        <div class="col-sm-1">
            <h2 class="or">OR</h2>
        </div>
        @include('pages.auth.register')
    </div>
@endsection
