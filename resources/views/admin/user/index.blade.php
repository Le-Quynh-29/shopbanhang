@extends('admin.layout.app')
@section('content')
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item active">
                {{ __('Quản lý người dùng') }}
            </li>
        </ol>
    </div>
    <div class="container-fluid c-content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 float-left">{{ __('Quản lý người dùng') }}</h4>
                        <div class="card-title btn-create float-right">
                            <a href="{{ route('user.create') }}">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('Thêm mới') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.user.search', ['fields' => ['id'=>'ID', 'username' => 'Tên đăng nhập', 'active' => 'Trạng thái']])
                        <div class="box-body">
                            <div class="row">
                                <h4 class="col-12">
                                    <strong>Tổng số: </strong>{{ $users->total() }}
                                </h4>
                            </div>
                            <table class="table table-responsive-sm">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">
                                        <a data-field="users.id" class="laravel-sort">{{ __('ID') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        <a data-field="users.username" class="laravel-sort">{{ __('Tên đăng nhập') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Vai trò') }}
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Họ tên') }}
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Trạng thái') }}
                                    </th>
                                    <th scope="col" class="text-center">

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <th scope="row" class="text-center width-50">
                                            <a
                                                href="{{ route('user.show', $user->id) }}"
                                                data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Chi tiết"
                                            >
                                                {{ $user->id }}
                                            </a>
                                        </th>
                                        <td class="text-center min-width-100 max-width-300">
                                            <a
                                                href="{{ route('user.show', $user->id) }}"
                                                data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Chi tiết"
                                            >
                                                {{ $user->username }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ $user->formatRole() }}</strong>
                                        </td>
                                        <td class="text-center min-width-100 max-width-300">
                                            {{ $user->fullname }}
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="{!! $user->active == \App\Models\User::ACTIVE ? 'active' : 'inactive' !!}">
                                                {!! $user->formatActive() !!}
                                            </span>
                                        </td>

                                        <td class="text-center width-170">
                                            @if($user->id != '1')
                                                <div class="edit-button float-left">
                                                    <a
                                                        href="{{route('user.edit', $user->id)}}"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        data-original-title="Cập nhật"
                                                    >
                                                        <i class="far fa-edit fa-lg mr-3"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            @if(!$user->isAdmin())
                                                <div class="active-button float-left">
                                                    @if ($user->active == '0')
                                                        <form method="POST" action="{{ route('user.lock', $user->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="active" value="1">
                                                            <a
                                                                class="modal-lock"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                data-original-title="Mở khóa" data-active="0"
                                                                href="javascript:;"
                                                            >
                                                                <i class="icon-lock fas fa-user-unlock fa-lg mr-3"></i>

                                                            </a>
                                                        </form>
                                                    @else
                                                        <form method="POST" action="{{ route('user.lock', $user->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="active" value="0">
                                                            <a
                                                                class="modal-lock"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                data-original-title="Vô hiệu hóa" data-active="1"
                                                                href="javascript:;"
                                                            >
                                                                <i class="icon-user-lock fas fa-user-lock fa-lg mr-3"></i>
                                                            </a>
                                                        </form>
                                                    @endif
                                                </div>
                                            @endif
                                            @if(!$user->isAdmin())
                                                <div class="delete-button float-left">
                                                    <form method="POST" action="{{ route('user.destroy', $user->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE" />
                                                        <a
                                                            href="javascript:;"
                                                            class="modal-confirm"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            data-original-title="Xóa"
                                                        >
                                                            <i class="fas fa-trash fa-lg"></i>
                                                        </a>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">{{ __('Không có dữ liệu') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <ul class="pagination">
                                {!! $users->appends(request()->input())->render() !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('admin.modals.confirm')
        @slot('title_header')
            Xác nhận xóa người dùng
        @endslot
        @slot('title')
            Bạn có chắc chắn muốn xóa người dùng này không?
        @endslot
        @slot('title_save')
            Có
        @endslot
        @slot('title_cancel')
            Không
        @endslot
    @endcomponent
    @component('admin.modals.lock')
        @slot('title_header')
            Xác nhận vô hiệu hóa người dùng
        @endslot
        @slot('title')
            Bạn có chắc chắn muốn vô hiệu hóa người dùng này không?
        @endslot
        @slot('title_save')
            Có
        @endslot
        @slot('title_cancel')
            Không
        @endslot
    @endcomponent
@endsection
@section('javascript')
    @parent
    <script src="{{ asset('js/user.js') }}"></script>
@endsection
