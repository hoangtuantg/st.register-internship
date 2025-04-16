<x-layouts.admin-layout>
<x-slot name="header">
        <div class="shadow page-header page-header-light">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="mb-0 page-title">
                       Phân công công ty thực tập - <span class="fw-normal">Danh sách công ty trong đợt đăng ký</span>
                    </h4>
                </div>

            </div>

            <div class="page-header-content d-lg-flex border-top">
                <div class="d-flex">
                    <div class="py-2 breadcrumb">
                        <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                        <a href="{{ route('admin.company-campaign.index') }}" class="breadcrumb-item">Phân công công ty thực tập</a>
                        {{-- <a href="{{ route('admin.company-campaign.show') }}" class="breadcrumb-item">Danh sách công ty trong đợt đăng ký</a> --}}
                        <span class="breadcrumb-item active">Cập nhật</span>
                    </div>

                    <a href="#breadcrumb_elements" class="p-0 border-transparent btn btn-light align-self-center collapsed d-lg-none rounded-pill ms-auto" data-bs-toggle="collapse">
                        <i class="m-1 ph-caret-down collapsible-indicator ph-sm"></i>
                    </a>
                </div>

            </div>
        </div>
    </x-slot>
    <div class="content">
        <livewire:admin.company-campaign.company-campaign-show :id="$id" />
    </div>
</x-layouts.admin-layout>
