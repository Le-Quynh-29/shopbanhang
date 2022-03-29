@extends('admin.layout.app')

@section('content')
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item">
                <a href="{{ route('product.index') }}">{{ __('Quản lý sản phẩm') }}</a>
            </li>
            <li class="breadcrumb-item active">
                {{ __('Thêm mới sản phẩm') }}
            </li>
        </ol>
    </div>
    <div class="container-fluid c-content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">{{ __('Thêm mới sản phẩm') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                        href="#product-general" role="tab"
                                                        aria-controls="product-general"
                                                        aria-selected="true">1. Thông tin cơ bản</a></li>
                                <li class="nav-item"><a class="nav-link" href="javascript:;" role="tab"
                                                        aria-controls="product-detail"
                                                        aria-selected="false">2. Các thông tin khác</a></li>
                                <li class="nav-item"><a class="nav-link" href="javascript:;" role="tab"
                                                        aria-controls="product-attachment"
                                                        aria-selected="false">3. Ảnh và video đính kèm</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="product-general" role="tabpanel">
                                    <form class="form-horizontal wizard clearfix" method="POST"
                                          action="{{ route('product.store') }}" enctype="multipart/form-data"
                                          id="form-product-create">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-xlg-2 col-sm-2 col-form-label"
                                                   for="code">{{ __('Mã sản phẩm') }} <em class="required">(*)</em>
                                                <br>
                                                <em class="required">Nhập loại sản phẩm + thời gian tạo</em>
                                                <em class="required">VD: "AO-211212-1155"</em>
                                            </label>
                                            <div class="col-xlg-4 col-sm-4">
                                                <input class="form-control" type="text" id="code" name="code"
                                                       value="{{ old('code') }}"
                                                       placeholder="Nhập mã sản phẩm">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xlg-2 col-sm-2 col-form-label"
                                                   for="name">{{ __('Tên sản phẩm') }} <em class="required">(*)</em>
                                            </label>
                                            <div class="col-xlg-10 col-sm-10">
                                                <input class="form-control" type="text" id="name" name="name"
                                                       value="{{ old('name') }}"
                                                       placeholder="Nhập tên sản phẩm">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xlg-2 col-sm-2 col-form-label"
                                                   for="image">{{ __('Hình ảnh') }}</label>
                                            <div class="col-xlg-10 col-sm-10">
                                                <div class="image-preview-wrapper">
                                                    <div class="image-preview">
                                                        <label for="image-input" class="image-label hidden">Chọn</label>
                                                        <input type="file" id="image" name="image" class="image-input"
                                                               accept=".png, .jpg, .jpeg, .bmp"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col col-xlg-2 col-sm-2 col-form-label"
                                                   for="category">{{ __('Danh mục') }}</label>
                                            <div class="col col-xlg-10 col-sm-10">
                                                <input type="text" id="category" name="category"
                                                       class="form-control h-auto" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xlg-2 col-sm-2 col-form-label" for="description">
                                                {{ __('Mô tả') }}<em class="required">(*)</em>
                                            </label>
                                            <div class="col-xlg-10 col-sm-10 description d-none" id="cdk">
                                                        <textarea class="form-control ck-editor d-none" id="description"
                                                                  type="text"
                                                                  name="description">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-primary" type="submit">
                                                {{ __('Thêm mới') }}
                                            </button>
                                            <a href="{{ route('product.index') }}" class="btn btn-danger ml-2"
                                               type="reset">
                                                {{ __('Hủy') }}
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script>
        window.localStorage.setItem('menu-selected', 'product');
        _validateUniqueNameURL = "{{ route('ajax.product.validate.unique.name') }}";
        _validateUniqueCodeURL = "{{ route('ajax.product.validate.unique.code') }}";
        _autocompleteCategory = "{{ route('ajax.category.autocomplete') }}";
        _categoryTagify = {!! $categoryTagify !!};
    </script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/upload-preview.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor-vi.js') }}"></script>
    <script src="{{ asset('js/tagify.min.js') }}"></script>
    <script src="{{ asset('js/product-create.js') }}" charset="UTF-8"></script>
@endsection
