@extends('admin.layout.app')

@section('content')
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item">
                <a href="{{ route('category.index') }}">{{ __('Quản lý danh mục') }}</a>
            </li>
            <li class="breadcrumb-item active">
                {{ __('Chi tiết danh mục') }}
            </li>
        </ol>
    </div>
    <div class="container-fluid c-content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 d-inline float-left">{{ __('Chi tiết danh mục') }}
                        </h4>
                        <em class="float-left">(ID: {{ $category->id }})</em>

                        <a
                            href="javascript:;" class="modal-edit float-right"
                            data-toggle="tooltip" data-placement="bottom" data-id="{{ $category->id }}"
                            data-name="{{ $category->name }}"
                            data-image="{{ URL::asset($category->formatImage('150')) }}"
                            data-original-title="Cập nhật"
                        >
                            <i class="fas fa-edit"></i>
                            {{ __('Cập nhật') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row ml-1">
                            <div class="col-xlg-3 col-sm-6 col-form-label">
                                <div class="form-group row">
                                    <img class="td-img"
                                         src="{{ asset($category->formatImage('300')) }}"
                                         alt="{{ $category->name }}">
                                </div>
                            </div>
                            <div class="col-xlg-9 col-sm-6 col-form-label">
                                <div class="form-group row">
                                    <label class="col-xlg-2 col-sm-2 col-form-label">{{ __('Tên danh mục') }}</label>
                                    <div class="col-xlg-10 col-sm-10">
                                        <p class="form-control mb-0 h-auto text-justify">
                                            {{ $category->name }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xlg-2 col-sm-2 col-form-label">{{ __('Đường dẫn') }}</label>
                                    <div class="col-xlg-10 col-sm-10">
                                        <p class="form-control mb-0 h-auto text-justify">
                                            {{ $category->slug }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xlg-2 col-sm-2 col-form-label">{{ __('Tổng sản phẩm') }}</label>
                                    <div class="col-xlg-10 col-sm-10">
                                        <p class="form-control mb-0 h-auto text-justify">
                                            {{ count($category->products) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xlg-2 col-sm-2 col-form-label">{{ __('Người tạo') }}</label>
                                    <div class="col-xlg-10 col-sm-10">
                                        <p class="form-control mb-0 h-auto text-justify">
                                            {{ $category->formatUsername() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row ml-1 mr-1">
                            <table class="table table-responsive-sm">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">
                                        <a data-field="products.id" class="laravel-sort">{{ __('ID') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        <a data-field="products.code" class="laravel-sort">{{ __('Mã sản phẩm') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        <a data-field="products.name" class="laravel-sort">{{ __('Tên sản phẩm') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Giá') }}
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Người tạo') }}
                                    </th>
{{--                                    <th scope="col" class="text-center">--}}

{{--                                    </th>--}}
                                    <th scope="col" class="text-center">

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($category->products) !== 0)
                                    @foreach ($category->products as $product)
                                        <tr>
                                            <th scope="row" class="text-center width-50">
                                                <a href="{{ route('product.show', $product->id) }}" target="_blank"
                                                   data-toggle="tooltip" data-placement="bottom"
                                                   data-original-title="Chi tiết">
                                                    {{ $product->id }}
                                                </a>
                                            </th>
                                            <td class="text-center width-170">
                                                <a href="{{ route('product.show', $product->id) }}" target="_blank"
                                                   data-toggle="tooltip" data-placement="bottom"
                                                   data-original-title="Chi tiết">
                                                    {{ $product->code }}
                                                </a>
                                            </td>
                                            <td class="text-center min-width-100 max-width-400">
                                                <a href="{{ route('product.show', $product->id) }}" target="_blank"
                                                   data-toggle="tooltip" data-placement="bottom" class="text-truncate"
                                                   data-original-title="Chi tiết">
                                                    {{ $product->name }}
                                                </a>
                                            </td>
                                            <td class="text-center max-width-300">
                                                @if(!is_null($product->price_to))
                                                    {{ ShopHelper::numberFormat($product->price_from).'đ' }}
                                                    -{{ ShopHelper::numberFormat($product->price_to).'đ' }}
                                                @else
                                                    {{ ShopHelper::numberFormat($product->price_from).'đ' }}
                                                @endif
                                            </td>
                                            <td class="text-center max-width-100">
                                                <p title="{{ $product->formatUserName() }}" class="text-truncate">
                                                    {{ $product->formatUserName() }}
                                                </p>
                                            </td>
                                            <td class="text-center width-120">
                                                <div class="delete-button">
                                                    <form method="POST"
                                                          action="{{ route('category.delete.product') }}">
                                                        @csrf
                                                        <input type="hidden" name="category_id"
                                                               value="{{ $category->id }}"/>
                                                        <input type="hidden" name="product_id"
                                                               value="{{ $product->id }}"/>
                                                        <a href="javascript:;" class="modal-confirm"
                                                           data-toggle="tooltip"
                                                           data-placement="bottom" data-original-title="Xóa">
                                                            <i class="fas fa-trash fa-lg"></i>
                                                        </a>
                                                    </form>
                                                </div>
                                            </td>
{{--                                            <td class="text-center width-50">--}}
{{--                                                <input class="checkbox-form-create ml-3 mt-1 product" type="checkbox"--}}
{{--                                                       name="product[]" value="{{ $product->id }}">--}}
{{--                                            </td>--}}
                                        </tr>
                                    @endforeach
{{--                                    <tr>--}}
{{--                                        <td colspan="7">--}}
{{--                                            <button type="submit" class="float-right btn btn-outline-danger"--}}
{{--                                                    id="submit-form-delete">--}}
{{--                                                <i class="fas fa-trash"></i>--}}
{{--                                                {{ __('Xóa') }}--}}
{{--                                            </button>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
                                @else
                                    <tr>
                                        <td colspan="6">{{ __('Không có dữ liệu') }}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
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
    @component('admin.modals.confirm')
        @slot('title_header')
            Xác nhận xóa sản phẩm trong danh mục
        @endslot
        @slot('title')
            Bạn có chắc chắn muốn xóa sản phẩm này khỏi danh mục này không?
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
                    <input class="form-control" id="name-edit" type="text" name="name" value="{!! old('name') !!}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-sm-3 col-form-label"
                       for="image-edit">{{ __('Hình ảnh') }}</label>
                <div class="col-md-9 col-sm-9">
                    <div class="image-preview-wrapper">
                        <div class="image-preview" id="image-preview-edit"
                             style="background-position: center center; background-size: cover;background-repeat: no-repeat">
                            <label for="image-input" class="image-label hidden" id="image-label-edit">Chọn</label>
                            <input type="file" id="image-edit" name="image" class="image-input"
                                   accept=".png, .jpg, .jpeg, .bmp"/>
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
