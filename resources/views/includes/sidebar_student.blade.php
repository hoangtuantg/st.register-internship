@php
    use App\Enums\UserRoleEnum;
    use App\Services\SsoService;
    $userData = app(SsoService::class)->getDataUser();
@endphp
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="my-auto sidebar-resize-hide flex-grow-1">ST Internship Group</h5>
                <div>
                    <button type="button"
                        class="border-transparent btn btn-flat-white btn-icon btn-sm rounded-pill sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="border-transparent btn btn-flat-white btn-icon btn-sm rounded-pill sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /sidebar header -->

        @if ($userData['role'] === UserRoleEnum::Student->value)
        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Đăng ký thực tập</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                <li class="nav-item">
                    <a href="{{ route('client.campaigns.index') }}"
                        class="nav-link {{ request()->routeIs('client.campaigns.*') ? 'active' : '' }}">
                        <i class="ph-calendar-check"></i>
                        <span>Đợt đăng ký</span>
                    </a>
                </li>

                {{-- <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Báo cáo tổng kết</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="ph-file-doc"></i>
                        <span>Nộp báo cáo</span>
                    </a>
                </li> --}}
            </ul>
        </div>
        <!-- /main navigation -->
        @endif

    </div>
    <!-- /sidebar content -->

</div>
