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
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Đợt đăng ký</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.campaigns.index')}}"
                       class="nav-link {{ request()->routeIs('admin.campaigns.index') ? 'active' : '' }}">
                        <i class="ph-telegram-logo"></i>
                        <span>Đợt đăng ký</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
