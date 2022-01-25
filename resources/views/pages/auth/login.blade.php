@extends('pages.layouts.app')

@section('content')
    <div class="mb-600">
        <div class="col-sm-4 col-sm-offset-1">
            <div class="login-form"><!--login form-->
                <h2>Đăng nhập</h2>
                <form action="#">
                    <div class="form-group">
                        <label for="email-login">Email</label>
                        <input type="text" id="email-login" placeholder="Nhập email"/>
                    </div>

                    <div class="form-group">
                        <label for="password-login">Mật khẩu</label>
                        <input type="password" id="password-login" placeholder="Nhập mật khẩu"/>
                    </div>
                    <span>
                    <input type="checkbox" class="checkbox">
                    Lưu đăng nhập
                </span>
                    <button type="submit" class="btn btn-default">Đăng nhập</button>
                </form>
            </div><!--/login form-->
        </div>
        <div class="col-sm-1">
            <h2 class="or">OR</h2>
        </div>
        @include('pages.auth.register')
    </div>
@endsection
