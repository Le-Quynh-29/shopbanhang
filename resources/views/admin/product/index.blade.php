@extends('admin.layout.app')
@section('content')
    <div class="c-subheader px-3">
        <ol class="breadcrumb border-0 m-0">
            <li class="breadcrumb-item active">
                {{ __('Quản lý sản phẩm') }}
            </li>
        </ol>
    </div>
    <div class="container-fluid c-content">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0 float-left">{{ __('Quản lý sản phẩm') }}</h4>
                        <div class="card-title btn-create float-right">
                            <a href="{{ route('product.create') }}" class="btn-create">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('Thêm mới') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.layout.search', ['fields' =>
                                        ['id'=>'ID', 'code' => 'Mã sản phẩm', 'name' => 'Tên sản phẩm', 'description' => 'Mô tả']
                                    ])
                        <div class="box-body">
                            <div class="row">
                                <h4 class="col-12">
                                    <strong>Tổng số: </strong>{{ $products->total() }}
                                </h4>
                            </div>
                            <table class="table table-responsive-sm">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">
                                        <a data-field="products.id" class="laravel-sort">{{ __('ID') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Ảnh') }}
                                    </th>
                                    <th scope="col" class="text-center">
                                        <a data-field="products.code"
                                           class="laravel-sort">{{ __('Mã sản phẩm') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        <a data-field="products.name"
                                           class="laravel-sort">{{ __('Tên') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Danh mục') }}
                                    </th>
                                    <th scope="col" class="text-center">
                                        <a data-field="products.like"
                                           class="laravel-sort">{{ __('Lượt thích') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        <a data-field="products.buy"
                                           class="laravel-sort">{{ __('Lượt mua') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        <a data-field="products.price_from"
                                           class="laravel-sort">{{ __('Giá') }}</a>
                                    </th>
                                    <th scope="col" class="text-center">
                                        {{ __('Người tạo') }}
                                    </th>
                                    <th scope="col" class="text-center">

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <th scope="row" class="text-center width-50">
                                            <a
                                                href="{{ route('product.show', $product->id) }}"
                                                data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Chi tiết"
                                            >
                                                {{ $product->id }}
                                            </a>
                                        </th>
                                        <td class="width-170">
                                            <img class="td-img"
                                                 src="{{ asset($product->formatImage('150')) }}"
                                                 alt="{{ $product->name }}">
                                        </td>
                                        <td class="text-center width-170">
                                            <a href="{{ route('product.show', $product->id) }}" target="_blank"
                                               data-toggle="tooltip" data-placement="bottom"
                                               data-original-title="Chi tiết">
                                                {{ $product->code }}
                                            </a>
                                        </td>
                                        <td class="text-center max-width-300">
                                            <a href="{{ route('product.show', $product->id) }}" class="text-truncate"
                                               data-toggle="tooltip" data-placement="bottom"
                                               data-original-title="Chi tiết">
                                                {{ $product->name }}
                                            </a>
                                        </td>
                                        <td class="max-width-200">
                                            @if (count($product->categories) !== 0)
                                                @foreach($product->categories as $category)
                                                    <li>
                                                        <a href="{{ route('category.show', $category->id) }}" target="_blank"
                                                           data-toggle="tooltip" data-placement="bottom"
                                                           data-original-title="Chi tiết danh mục" class="text-truncate">
                                                            {{ $category->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center width-80">
                                            {{ ShopHelper::numberFormat($product->like) }}
                                        </td>
                                        <td class="text-center width-80">
                                            {{ ShopHelper::numberFormat($product->buy) }}
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
                                            <div class="edit-button float-left">
                                                <a
                                                    href="{{ route('product.edit', $product->id) }}"
                                                    data-toggle="tooltip" data-placement="bottom"
                                                    data-original-title="Cập nhật"
                                                >
                                                    <i class="far fa-edit fa-lg mr-3"></i>
                                                </a>
                                            </div>
                                            <div class="delete-button float-left">
                                                <form method="POST"
                                                      action="{{ route('product.destroy', $product->id) }}">
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
                                {!! $products->appends(request()->input())->render() !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('admin.modals.confirm')
        @slot('title_header')
            Xác nhận xóa sản phẩm
        @endslot
        @slot('title')
            Bạn có chắc chắn muốn xóa sản phẩm này không?
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
        window.localStorage.setItem('menu-selected', 'product');
    </script>
@endsection
