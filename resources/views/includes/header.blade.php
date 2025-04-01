@php
    $auth = app(\App\Services\SsoService::class)->getDataUser();
@endphp
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">

        </div>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2 align-items-center">
            @if (auth()->check())
                @if ($auth['role'] == \App\Enums\UserRoleEnum::SuperAdmin->value)
                    <li class="ms-lg-2">
                        <livewire:commons.faculty-selected />
                    </li>
                @endif
                <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                    <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                        data-bs-toggle="dropdown">
                        <div class="status-indicator-container">
                            <img src="{{ Avatar::create($auth['full_name'])->toBase64() }}"
                                class="w-32px h-32px rounded-pill" alt="">
                            <span class="status-indicator bg-success"></span>
                        </div>
                        <span class="d-none d-lg-inline-block mx-lg-2"></span>
                        <span class="d-none d-lg-inline-block mx-lg-2">{{ $auth['full_name'] }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{ config('auth.sso.uri') }}/profile" target="_blank" class="dropdown-item">
                            <i class="ph-gear me-2"></i>
                            Tài khoản
                        </a>
                        <div class="dropdown-divider"></div>

                        <form action="{{ route('handleLogout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="ph-sign-out me-2"></i>
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>
