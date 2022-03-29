@extends('admin.layout.app')

@section('content')
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item">
                <a href="{{ route('user.index') }}">{{ __('Quản lý người dùng') }}</a>
            </li>
            <li class="breadcrumb-item active">
                {{ __('Thông tin chi tiết người dùng') }}
            </li>
        </ol>
    </div>
    <div class="container-fluid c-content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 d-inline">{{ __('Thông tin chi tiết người dùng') }}
                        </h4>
                        <em>(ID: {{ $user->id }})</em>
                        @if ($user->id != '1')
                            <a
                                class="nav-link d-inline"
                                href="{{ route('user.edit', $user->id) }}"
                                data-toggle="tooltip" data-placement="top" title="Sửa thông tin người dùng"
                            >
                                <i class="far fa-user-edit fa-lg"></i>
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-xxl-6 mb-4">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        <strong>{{ __('ID') }}</strong>
                                    </label>
                                    <div class="col-md-9">
                                        <label class="col-md col-form-label">{{ $user->id }}</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        <strong>{{ __('Họ tên') }}</strong>
                                    </label>
                                    <div class="col-md-9">
                                        <label class="col-md col-form-label">{{ $user->fullname }}</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        <strong>{{ __('Tên đăng nhập') }}</strong>
                                    </label>
                                    <div class="col-md-9">
                                        <label class="col-md col-form-label">{{ $user->username }}</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        <strong>{{ __('Giới tính') }}</strong>
                                    </label>
                                    <div class="col-md-9">
                                        <label class="col-md col-form-label">{{ $user->formatGender() }}</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        <strong>{{ __('Ngày sinh') }}</strong>
                                    </label>
                                    <div class="col-md-9">
                                        <label class="col-md col-form-label">{{ $user->birthday }}</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        <strong>{{ __('Vai trò') }}</strong>
                                    </label>
                                    <div class="col-md-9">
                                        <label class="col-md col-form-label">
                                            <strong>{{ $user->formatRole() }}</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xxl-6 mb-4">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        <strong>{{ __('Trạng thái') }}</strong>
                                    </label>
                                    <div class="col-md-9">
                                        <label class="col-md col-form-label">
                                            <span class="{!! $user->active == \App\Models\User::ACTIVE ? 'active' : 'inactive' !!}">
                                                {!! $user->formatActive() !!}
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        <strong>{{ __('Ngày tạo') }}</strong>
                                    </label>
                                    <div class="col-md-9">
                                        <label class="col-md col-form-label">
                                            {!! \ShopHelper::formatTime($user->created_at) !!}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        <strong>{{ __('Ngày cập nhật') }}</strong>
                                    </label>
                                    <div class="col-md-9">
                                        <label class="col-md col-form-label">
                                            {!! ShopHelper::formatTime($user->updated_at) !!}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-primary" type="reset">
                            {{ __('Quay lại') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script>
        window.localStorage.setItem('menu-selected', 'user');
    </script>
@endsection
