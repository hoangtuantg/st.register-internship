<x-layouts.admin-layout>
<x-slot name="header">
        <div class="shadow page-header page-header-light">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="mb-0 page-title">
                        Công ty thực tập - <span class="fw-normal">Tạo mới </span>
                    </h4>
                </div>

            </div>

            <div class="page-header-content d-lg-flex border-top">
                <div class="d-flex">
                    <div class="py-2 breadcrumb">
                        <a href="" class="breadcrumb-item"><i class="ph-house"></i></a>
                        <a href="{{ route('admin.companies.index') }}" class="breadcrumb-item">Công ty thực tập</a>
                        <span class="breadcrumb-item active">Tạo mới</span>
                    </div>

                    <a href="#breadcrumb_elements" class="p-0 border-transparent btn btn-light align-self-center collapsed d-lg-none rounded-pill ms-auto" data-bs-toggle="collapse">
                        <i class="m-1 ph-caret-down collapsible-indicator ph-sm"></i>
                    </a>
                </div>

            </div>
        </div>
    </x-slot>
    <div class="content">
        <livewire:admin.company.company-create />
    </div>
</x-layouts.admin-layout>
