@extends('admin.layout.app')

@section('style')
    <link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item">
                <a href="{{ route('user.index') }}">{{ __('Quản lý người dùng') }}</a>
            </li>
            <li class="breadcrumb-item active">
                {{ __('Cập nhật người dùng') }}
            </li>
        </ol>
    </div>
    <div class="container-fluid c-content">
        <div class="row justify-content-center">
            <div class="col-12">
                <form
                    class="form-horizontal wizard clearfix"
                    enctype="multipart/form-data" id="form-update-user"
                >
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <h4 class="card-title mb-0 float-left">{{ __('Cập nhật người dùng') }}</h4>
                                <em class="float-left">(ID: {{ $user->id }})</em>
                            </div>
                            <div class="card-title btn-create float-right">
                                <a href="{{ route('user.show', $user->id) }}">
                                    <i class="far fa-info"></i>
                                    {{ __('Chi tiết') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                       for="fullname">{{ __('Họ tên') }} <em class="required">(*)</em></label>
                                <div class="col-xlg-10 col-sm-10">
                                    <input class="form-control {!! $errors->has('fullname') ? 'is-invalid' : '' !!}"
                                           type="text" id="fullname" name="fullname"
                                           value="{{ old('fullname', $user->fullname) }}"
                                           placeholder="Nhập họ tên">
                                    {!! $errors->first('fullname', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                       for="username">{{ __('Tên đăng nhập') }} <em class="required">(*)</em></label>
                                <div class="col-xlg-10 col-sm-10">
                                    <input class="form-control {!! $errors->has('username') ? 'is-invalid' : '' !!}"
                                           type="text" id="username" name="username"
                                           value="{{ old('username', $user->username) }}"
                                           placeholder="Nhập tên đăng nhập">
                                    {!! $errors->first('username', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                       for="gender">{{ __('Giới tính') }}</label>
                                <div class="col-xlg-3 col-sm-3">
                                    <select class="form-control {!! $errors->has('gender') ? 'is-invalid' : '' !!}"
                                            id="gender" name="gender">
                                        @foreach (\App\Models\User::SEXES as $key => $data)
                                            <option
                                                value="{{ $key }}" {!! old('gender', $user->gender) == $key ? 'selected="selected"' : '' !!}>
                                                {{ $data }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('gender', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                       for="number_phone">{{ __('SĐT') }}</label>
                                <div class="col-xlg-3 col-sm-3">
                                    <input class="form-control {!! $errors->has('number_phone') ? 'is-invalid' : '' !!}"
                                           type="text" id="number_phone" name="number_phone"
                                           value="{{ old('number_phone', $user->number_phone) }}"
                                           placeholder="Nhập SĐT">
                                    {!! $errors->first('number_phone', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                       for="birthday">{{ __('Ngày sinh') }}</label>
                                <div class="col-xlg-10 col-sm-10">
                                    <div class="col-month">
                                        <div class="input-group date">
                                            <input
                                                type="text"
                                                class="month {!! $errors->has('birthday') ? 'is-invalid' : '' !!}"
                                                id="birthday" name="birthday"
                                                value="{{ old('birthday') }}" autocomplete="off"
                                                readonly
                                            >
                                            <div class="input-group-addon">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            {!! $errors->first('birthday', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xlg-2 col-sm-2 col-form-label" for="role">{{ __('Vai trò') }}</label>
                                <div class="col-xlg-3 col-sm-3">
                                    <select class="form-control {!! $errors->has('role') ? 'is-invalid' : '' !!}"
                                            id="role" name="role">
                                        @foreach (\App\Models\User::ROLES as $key => $role)
                                            <option
                                                value="{{ $key }}" {!! old('role', $user->role) == $key ? 'selected="selected"' : '' !!}>
                                                {{ $role }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('role', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                       for="email">{{ __('Email') }} <em class="required">(*)</em></label>
                                <div class="col-xlg-10 col-sm-10">
                                    <input class="form-control {!! $errors->has('email') ? 'is-invalid' : '' !!}"
                                           type="text" id="email" name="email" value="{{ old('email', $user->email) }}"
                                           placeholder="Nhập email">
                                    {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                       for="active">{{ __('Kích hoạt') }}</label>
                                <div class="col-xlg-10 col-sm-10 d-flex align-items-center ">
                                    <input class="checkbox-form-create" type="checkbox" value="{{$user->active}}"
                                           name="active" {{ $user->active == 1 ? 'checked' : '' }} id="active">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col col-xlg-2 col-sm-2 col-form-label"
                                       for="password">{{ __('Mật khẩu') }}
                                    <em class="required">(*)</em>
                                </label>
                                <div class="col col-xlg-10 col-sm-10">
                                    <input class="form-control {!! $errors->has('password') ? 'is-invalid' : '' !!}"
                                           type="password" id="password" name="password" value="{{ old('password') }}"
                                           placeholder="Nhập mật khẩu nếu muốn thay đổi">
                                    {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-md-flex justify-content-md-end">
                            <a href="{{ route('user.index') }}" class="btn btn-danger mr-2"
                               type="reset">{{ __('Hủy') }}</a>
                            <button class="btn btn-primary" type="submit">{{ __('Cập nhật') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script>
        _userId = {!! $user->id !!};
        _updateUser = "{{ route('ajax.user.update') }}";
        _validateUniqueNameURL = "{{ route('ajax.user.validate.unique.name') }}";
        _validateUniqueEmailURL = "{{ route('ajax.user.validate.unique.email') }}";
        window.localStorage.setItem('menu-selected', 'user');
    </script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.vi.min.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('js/user.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('js/user-edit.js') }}" charset="UTF-8"></script>
@endsection
