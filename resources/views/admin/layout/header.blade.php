<div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
            <span class="c-header-toggler-icon"></span>
        </button>

        <a class="c-header-brand d-sm-none" href="#">
            <img src="{{ asset('images/logo-mini.png') }}" alt="{{ getenv('APP_NAME') }}"></img>
        </a>
        <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>

        <ul class="c-header-nav ml-auto mr-4">
            <li class="c-header-nav-item dropdown">
                <a
                    class="c-header-nav-link" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="true" aria-expanded="false"
                >
                    <span class="mr-2"> {{ Auth()->user() ? Auth()->user()->username : '' }}</span>
                    <div class="c-avatar">
                        <i class="fal fa-user-circle fa-2x" alt="Ảnh đại diện"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0 pb-0">
                    <div class="dropdown-header bg-light py-2">
                        <strong>{{ Auth()->user() ? Auth()->user()->fullname : '' }}</strong>
                    </div>

{{--                    <a class="dropdown-item" href="{{ route('profile.show') }}">--}}
{{--                        <i class="far fa-user-cog mr-2"></i>--}}
{{--                        {{ __('Thông tin cá nhân') }}--}}
{{--                    </a>--}}

{{--                    <a class="dropdown-item" href="#">--}}
{{--                        <i class="far fa-key mr-2"></i>--}}
{{--                        {{ __('Đổi mật khẩu') }}--}}
{{--                    </a>--}}

                    <a class="dropdown-item btn-logout" href="{{ route('admin.logout') }}">
                        <i class="fas fa-sign-out fa-flip-horizontal mr-2"></i>
                        {{ __('Đăng xuất') }}
                    </a>

                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </header>
