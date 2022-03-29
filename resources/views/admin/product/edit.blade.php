@extends('admin.layout.app')

@section('content')
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item">
                <a href="{{ route('product.index') }}">{{ __('Quản lý sản phẩm') }}</a>
            </li>
            <li class="breadcrumb-item active">
                {{ __('Cập nhật sản phẩm') }}
            </li>
        </ol>
    </div>
    <div class="container-fluid c-content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 float-left">{{ __('Cập nhật sản phẩm') }}</h4>
                        <em class="float-left">
                            (ID: {{ $product->id }})
                        </em>
                        <div class="card-title btn-create float-right">
                            <a href="{{ route('product.show', $product->id) }}">
                                <i class="fas fa-info-circle"></i>
                                {{ __('Chi tiết') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal">
                            <div class="nav-tabs-boxed">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $tab == '1' ? 'active' : '' }}" data-toggle="tab"
                                           href="#product-general" role="tab" aria-controls="product-general"
                                           aria-selected="true">
                                            {{ __('1. Thông tin cơ bản') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $tab == '2' ? 'active' : '' }}" data-toggle="tab"
                                           href="#product-detail" role="tab" aria-controls="product-detail"
                                           aria-selected="false">
                                            {{ __('2. Các thông tin khác') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $tab == '3' ? 'active' : '' }}" data-toggle="tab"
                                           href="#product-attachment" role="tab" aria-controls="product-attachment"
                                           aria-selected="false">
                                            {{ __('3. Các tài liệu đính kèm') }}
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane {{ $tab == '1' ? 'active' : '' }}" id="product-general"
                                         role="tabpanel">
                                        <form id="form-product-update"
                                              class="form-horizontal wizard clearfix" method="post"
                                              action="{{ route('product.update', $product->id) }}"
                                              enctype="multipart/form-data"
                                        >
                                            @csrf
                                            <input type="hidden" name="_method" value="PUT"/>
                                            <div class="form-group row">
                                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                                       for="code">{{ __('Mã sản phẩm') }} <em class="required">(*)</em>
                                                    <br>
                                                    <em class="required">Nhập loại sản phẩm + thời gian tạo</em>
                                                    <em class="required">VD: "AO-211212-1155"</em>
                                                </label>
                                                <div class="col-xlg-4 col-sm-4">
                                                    <input class="form-control" type="text" id="code" name="code"
                                                           value="{{ old('code', $product->code) }}"
                                                           placeholder="Nhập mã sản phẩm">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                                       for="name">{{ __('Tên sản phẩm') }} <em class="required">(*)</em>
                                                </label>
                                                <div class="col-xlg-10 col-sm-10">
                                                    <input class="form-control" type="text" id="name" name="name"
                                                           value="{{ old('name', $product->name) }}"
                                                           placeholder="Nhập tên sản phẩm">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xlg-2 col-sm-2 col-form-label"
                                                       for="image">{{ __('Hình ảnh') }}</label>
                                                <div class="col-xlg-10 col-sm-10">
                                                    <div class="image-preview-wrapper">
                                                        <div class="image-preview" style="background-image:
                                                            url({{ URL::asset($product->formatImage('150')) }});
                                                            background-position: center center; background-size: cover">
                                                            <label for="image-input"
                                                                   class="image-label hidden">Chọn</label>
                                                            <input type="file" id="image" name="image"
                                                                   class="image-input"
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
                                                           class="form-control h-auto">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-xlg-2 col-sm-2 col-form-label" for="description">
                                                    {{ __('Mô tả') }}<em class="required">(*)</em>
                                                </label>
                                                <div class="col-xlg-10 col-sm-10 description d-none" id="cdk">
                                                        <textarea class="form-control ck-editor d-none" id="description"
                                                                  type="text"
                                                                  name="description">{!! old('description', $product->description) !!}</textarea>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn btn-primary" type="submit">
                                                    {{ __('Cập nhật') }}
                                                </button>
                                                <a href="{{ route('product.index') }}"
                                                   class="btn btn-danger ml-2"
                                                   type="reset">
                                                    {{ __('Hủy') }}
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane {{ $tab == '2' ? 'active' : '' }}" id="product-detail"
                                         role="tabpanel">
                                        <form class="form-horizontal wizard clearfix" id="form-create-detail"
                                              action="{{ route('product.update.detail', $product->id) }}"
                                              method="POST" enctype="multipart/form-data"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <div class="col-xlg-12 col-sm-12 col-form-label">
                                                    <label class="col-form-label float-left">Chi tiết sản phẩm</label>
                                                    <div class="float-left text-primary btn-add-row-details mt-1 ml-2"
                                                         data-toggle="tooltip" data-placement="bottom"
                                                         data-original-title="Thêm các thông tin chi tiết">
                                                        <i class="fas fa-plus-circle fa-2x"></i>
                                                    </div>
                                                    <table
                                                        class="table table-striped table-hover col-sm-12"
                                                        id="details-table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center max-width-200">Màu</th>
                                                            <th scope="col" class="text-center max-width-200">Kích cỡ</th>
                                                            <th scope="col" class="text-center max-width-400">Giá</th>
                                                            <th scope="col" class="text-center max-width-400">Số lượng</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tbody">
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xlg-12 col-sm-12 col-form-label">
                                                    <label class="col-form-label float-left">Các thông tin khác</label>
                                                    <div class="float-left text-primary btn-add-row-info mt-1 ml-2"
                                                         data-toggle="tooltip" data-placement="bottom"
                                                         data-original-title="Thêm các thông tin khác">
                                                        <i class="fas fa-plus-circle fa-2x"></i>
                                                    </div>
                                                    <table
                                                        class="table table-striped table-hover col-sm-12 "
                                                        id="information-table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center width-300">Tiêu đề</th>
                                                            <th scope="col" class="text-center max-width-400">Nội dung</th>
                                                            <th scope="col" class="text-center width-150"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tbody">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div>
                                                <input type="hidden" name="product_detail" id="details"/>
                                                <input type="hidden" name="details" id="info"/>

                                                <button class="btn btn-primary" type="submit"
                                                        id="submit-product-detail">
                                                    {{ __('Cập nhật') }}
                                                </button>
                                                <a href="{{ route('product.index') }}"
                                                   class="btn btn-danger ml-2"
                                                   type="reset">
                                                    {{ __('Hủy') }}
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane {{ $tab == '3' ? 'active' : '' }}" id="product-attachment"
                                         role="tabpanel">
                                        <div class="form-group row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <label for="gallery-dropzone"><i>Gallery (Cho phép tải các tài
                                                                liệu có định
                                                                dạng .jpg, .png, .bmp)</i></label>
                                                        <div class="needsclick dropzone" id="gallery-dropzone">
                                                            <div class="fallback">
                                                                <input class="form-control" type="file"
                                                                       name="gallery_doc[]"
                                                                       multiple/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-body">
                                                        <label for="media-dropzone"><i>Đa phương tiện (Cho phép tải các
                                                                tài liệu có
                                                                định dạng .mp3, .mp4, .webm, .ogg, .avi, .mov, .acc)</i></label>
                                                        <div class="needsclick dropzone" id="media-dropzone">
                                                            <div class="fallback">
                                                                <input class="form-control" type="file"
                                                                       name="media_doc[]"
                                                                       multiple/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        _product = {!! $product !!};
        _validateUniqueNameURL = "{{ route('ajax.product.validate.unique.name') }}";
        _validateUniqueCodeURL = "{{ route('ajax.product.validate.unique.code') }}";
        _autocompleteCategory = "{{ route('ajax.category.autocomplete') }}";
        _categoryTagify = {!! $categoryTagify !!};
        _productDetails = {!! $productDetails !!};
        _details = {!! json_encode($product->details) !!};
    </script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/upload-preview.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor-vi.js') }}"></script>
    <script src="{{ asset('js/tagify.min.js') }}"></script>
    <script src="{{ asset('js/product-edit.js') }}" charset="UTF-8"></script>
@endsection
