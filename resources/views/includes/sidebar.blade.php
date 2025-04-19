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


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                @if(Auth::user()->can('viewAny', \App\Models\Campaign::class) || Auth::user()->can('viewAny', \App\Models\Plan::class) )
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Quản lý đợt đăng ký</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                @endif

                @can('viewAny', \App\Models\Campaign::class)
                <li class="nav-item">
                    <a href="{{ route('admin.campaigns.index') }}"
                        class="nav-link {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}">
                        <i class="ph-telegram-logo"></i>
                        <span>Đợt đăng ký</span>
                    </a>
                </li>
                @endcan

                @can('viewCampaignList', \App\Models\Company::class)
                <li class="nav-item">
                    <a href="{{ route('admin.company-campaign.index') }}"
                        class="nav-link {{ request()->routeIs('admin.company-campaign.*') ? 'active' : '' }}">
                        <i class="ph-share-network"></i>
                        <span>Phân công công ty thực tập</span>
                    </a>
                </li>
                @endcan

                @can('viewAny', \App\Models\Plan::class)
                <li class="nav-item">
                    <a href="{{ route('admin.plans.index') }}"
                        class="nav-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                        <i class="ph-calendar"></i>
                        <span>Kế hoạch</span>
                    </a>
                </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}"
                        class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="ph-file-doc"></i>
                        <span>Báo cáo</span>
                    </a>
                </li>

                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Quản lý giảng viên</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                <li class="nav-item">
                    <a href=""
                        class="nav-link">
                        <i class="ph-chalkboard-teacher"></i>
                        <span>Giảng viên</span>
                    </a>
                </li>

                @if(Auth::user()->can('viewAny', \App\Models\Company::class) )
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">
                        Quản lý công ty thực tập
                    </div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                @endif

                @can('viewAny', \App\Models\Company::class)
                <li class="nav-item">
                    <a href="{{ route('admin.companies.index') }}"
                        class="nav-link {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}">
                        <i class="ph-briefcase"></i>
                        <span>Công ty thực tập</span>
                    </a>
                </li>
                @endcan

                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Quản lý người dùng</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                        class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="ph-users"></i>
                        <span>Người dùng</span>
                    </a>
                </li>

                @if(Auth::user()->can('viewAny', \App\Models\Role::class) )
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Quản lý vai trò</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                @endif

                @can('viewAny', \App\Models\Role::class)
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}"
                        class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class="ph-gear"></i>
                        <span>Vai trò</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
