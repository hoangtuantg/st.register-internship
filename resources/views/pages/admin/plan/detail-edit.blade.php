<x-layouts.admin-layout>
{{--    <x-slot name="custom_js"> --}}
{{--        @vite(['resources/js/campaign/index.js']) --}}
{{--    </x-slot> --}}
<x-slot name="header">
    <div class="shadow page-header page-header-light">
        <div class="page-header-content d-lg-flex">
            <div class="d-flex">
                <h4 class="mb-0 page-title">
                    Kế hoạch chi tiết - <span class="fw-normal">Chỉnh sửa</span>
                </h4>

                <a href="#page_header"
                    class="p-0 border-transparent btn btn-light align-self-center collapsed d-lg-none rounded-pill ms-auto"
                    data-bs-toggle="collapse">
                    <i class="m-1 ph-caret-down collapsible-indicator ph-sm"></i>
                </a>
            </div>

        </div>

        <div class="page-header-content d-lg-flex border-top">
            <div class="d-flex">
                <div class="py-2 breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="ph-house"></i></a>
                    <a href="{{ route('admin.plans.show', $planTemplateId) }}" class="breadcrumb-item">Mẫu kế hoạch</a>
                    <span class="breadcrumb-item active">Chỉnh sửa </span>
                </div>

                <a href="#breadcrumb_elements"
                    class="p-0 border-transparent btn btn-light align-self-center collapsed d-lg-none rounded-pill ms-auto"
                    data-bs-toggle="collapse">
                    <i class="m-1 ph-caret-down collapsible-indicator ph-sm"></i>
                </a>
            </div>

        </div>
    </div>
</x-slot>


<div class="content">
    <livewire:admin.plan.plan-detail-update :id="$id" :planTemplateId="$planTemplateId" />
</div>

</x-layouts.admin-layout>
