@extends('admin.layout.app')

@section('style')
    <link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item">
                <a href="{{ route('category.index') }}">{{ __('Quản lý danh mục') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('category.show', $categoryId) }}">{{ __('Chi tiết danh mục') }}</a>
            </li>
            <li class="breadcrumb-item active">
                {{ __('Xóa sản phẩm') }}
            </li>
        </ol>
    </div>
    <div class="container-fluid c-content">
        <div class="row justify-content-center">
            <div class="col-12">
                <form
                    class="form-horizontal wizard clearfix" action="" method="post"
                    enctype="multipart/form-data" id="form-update-user"
                >
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <h4 class="card-title mb-0 float-left">{{ __('Xóa sản phẩm') }}</h4>
                                <em class="float-left">({{ $categoryId }})</em>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <ul>
                                    @foreach($products as $product)
                                        <li>
                                            <a href="{{ route('mts.show', $item->id) }}" target="_blank">
                                                [{{ $item->id }}] {{ $item->value}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card-footer d-md-flex justify-content-md-end">
                            <a href="{{ url()->previous() }}" class="btn btn-danger mr-2"
                               type="reset">{{ __('Hủy') }}</a>
                            <button class="btn btn-primary" type="submit">{{ __('Xóa') }}</button>
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
        window.localStorage.setItem('menu-selected', 'category');
    </script>
@endsection
