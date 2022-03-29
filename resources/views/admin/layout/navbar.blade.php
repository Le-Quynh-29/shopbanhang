<a href="{{ route('dashboard') }}" class="c-sidebar-brand">
    <img src="{{ asset('images/logo-mini.png') }}" class="c-sidebar-brand-full" alt="{{getenv('APP_NAME')}}"></img>
    <img src="{{ asset('images/logo-mini.png') }}" class="c-sidebar-brand-minimized" alt="{{getenv('APP_NAME')}}"></img>
</a>
<ul class="c-sidebar-nav" id="menu-nav">
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" data-id="9999" href="{{ route('dashboard') }}">
            <i class="far fa-home c-sidebar-nav-icon"></i>
            {{ __('Trang chủ') }}
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" data-id="user" href="{{ route('user.index') }}">
            <i class="far fa-users-cog c-sidebar-nav-icon"></i>
            {{ __('Quản lý người dùng') }}
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" data-id="category" href="{{ route('category.index') }}">
            <i class="fas fa-folders c-sidebar-nav-icon"></i>
            {{ __('Quản lý danh mục') }}
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" data-id="product" href="{{ route('product.index') }}">
            <i class="fab fa-product-hunt c-sidebar-nav-icon"></i>
            {{ __('Quản lý sản phẩm') }}
        </a>
    </li>
</ul>
<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
