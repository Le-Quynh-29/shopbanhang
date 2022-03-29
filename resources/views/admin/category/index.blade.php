@extends('admin.layout.app')
@section('content')
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item active">
                {{ __('Quản lý danh mục') }}
            </li>
        </ol>
    </div>
    <div class="container-fluid c-content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 float-left">{{ __('Quản lý danh mục') }}</h4>
                        <div class="card-title btn-create float-right">
                            <a href="javascript:;" class="modal-create">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('Thêm mới') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.layout.search', ['fields' => ['id'=>'ID', 'name' => 'Tên']])
                        <div class="box-body">
                            <div class="row">
                                <h4 class="col-12">
                                    <strong>Tổng số: </strong>{{ $categories->total() }}
                                </h4>
                            </div>
                            <table class="table table-responsive-sm">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">
                                        <a data-field="categories.id" class="laravel-sort">{{ __('ID') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Ảnh') }}
                                    </th>
                                    <th scope="col" class="text-center">
                                        <a data-field="categories.name"
                                           class="laravel-sort">{{ __('Tên danh mục') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Số sản phẩm') }}
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Người tạo') }}
                                    </th>
                                    <th scope="col" class="text-center">

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <th scope="row" class="text-center width-50">
                                            <a
                                                href="{{ route('category.show', $category->id) }}"
                                                data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Chi tiết"
                                            >
                                                {{ $category->id }}
                                            </a>
                                        </th>
                                        <td class="width-170">
                                            <img class="td-img"
                                                 src="{{ asset($category->formatImage('150')) }}"
                                                 alt="{{ $category->name }}">
                                        </td>
                                        <td class="text-center min-width-100 max-width-400">
                                            <a
                                                href="{{ route('category.show', $category->id) }}"
                                                data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Chi tiết" class="text-truncate"
                                            >
                                                {{ $category->name }}
                                            </a>
                                        </td>
                                        <td class="text-center max-width-300">
                                            {{ count($category->products) }}
                                        </td>
                                        <td class="text-center max-width-100">
                                            <p title="{{ $category->formatUserName() }}" class="text-truncate">
                                                {{ $category->formatUserName() }}
                                            </p>
                                        </td>
                                        <td class="text-center width-120">
                                            <div class="edit-button float-left">
                                                <a
                                                    href="javascript:;" class="modal-edit"
                                                    data-toggle="tooltip" data-placement="bottom" data-id="{{ $category->id }}"
                                                    data-name="{{ $category->name }}" data-image="{{ URL::asset($category->formatImage('150')) }}"
                                                    data-original-title="Cập nhật"
                                                >
                                                    <i class="far fa-edit fa-lg mr-3"></i>
                                                </a>
                                            </div>
                                            <div class="delete-button float-left">
                                                <form method="POST" action="{{ route('category.destroy', $category->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE"/>
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
                                {!! $categories->appends(request()->input())->render() !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('admin.modals.confirm')
        @slot('title_header')
            Xác nhận xóa danh mục
        @endslot
        @slot('title')
            Bạn có chắc chắn muốn xóa danh mục này không?
        @endslot
        @slot('title_save')
            Có
        @endslot
        @slot('title_cancel')
            Không
        @endslot
    @endcomponent
    @component('admin.modals.create-edit')
        @slot('id_modal')
            modal-create
        @endslot
        @slot('modal_lg')
            modal-lg
        @endslot
        @slot('route')
            {{ route('category.store') }}
        @endslot
        @slot('model')
            form-create-category
        @endslot
        @slot('method')
        @endslot
        @slot('title_header')
            Thêm mới danh mục
        @endslot
        @slot('data')
            <div class="form-group row">
                <label class="col-md-3 col-sm-3 col-form-label" for="name">
                    {{ __('Tên danh mục') }} <em class="required">(*)</em>
                </label>
                <div class="col-md-9 col-sm-9">
                    <input class="form-control" id="name" type="text"  name="name" value="">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-sm-3 col-form-label"
                       for="image">{{ __('Hình ảnh') }}</label>
                <div class="col-md-9 col-sm-9">
                    <div class="image-preview-wrapper">
                        <div class="image-preview">
                            <label for="image-input" class="image-label hidden">Chọn</label>
                            <input type="file" id="image" name="image" class="image-input" accept=".png, .jpg, .jpeg, .bmp"/>
                        </div>
                    </div>
                </div>
            </div>
        @endslot
        @slot('title_save')
            Có
        @endslot
        @slot('title_cancel')
            Không
        @endslot
    @endcomponent
    @component('admin.modals.create-edit')
        @slot('id_modal')
            modal-edit
        @endslot
        @slot('modal_lg')
            modal-lg
        @endslot
        @slot('route')
            {{ route('category.update.with.log') }}
        @endslot
        @slot('model')
            form-update-category
        @endslot
        @slot('method')
        @endslot
        @slot('title_header')
            Cập nhật danh mục
        @endslot
        @slot('data')
            <input type="hidden" name="id" id="id-edit">
            <div class="form-group row">
                <label class="col-md-3 col-sm-3 col-form-label" for="name-edit">
                    {{ __('Tên danh mục') }} <em class="required">(*)</em>
                </label>
                <div class="col-md-9 col-sm-9">
                    <input class="form-control" id="name-edit" type="text"  name="name" value="{!! old('name') !!}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-sm-3 col-form-label"
                       for="image-edit">{{ __('Hình ảnh') }}</label>
                <div class="col-md-9 col-sm-9">
                    <div class="image-preview-wrapper">
                        <div class="image-preview" id="image-preview-edit" style="background-position: center center; background-size: cover;background-repeat: no-repeat">
                            <label for="image-input" class="image-label hidden" id="image-label-edit">Chọn</label>
                            <input type="file" id="image-edit" name="image" class="image-input" accept=".png, .jpg, .jpeg, .bmp"/>
                        </div>
                    </div>
                </div>
            </div>
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
    <script>
        _validateUniqueNameURL = "{{ route('ajax.category.validate.unique.name') }}";
        window.localStorage.setItem('menu-selected', 'category');
    </script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/upload-preview.js') }}"></script>
    <script src="{{ asset('js/modal-create-edit.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('js/category.js') }}" charset="UTF-8"></script>
@endsection
