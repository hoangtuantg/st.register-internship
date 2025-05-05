<x-layouts.client-layout>
    <x-slot name="header">
        <div class="page-header page-header-light shadow">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Đăng ký thực tập                    
                    </h4>

                    <a href="#page_header"
                        class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                        data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

            </div>

            <div class="page-header-content d-lg-flex border-top">
                <div class="d-flex">
                    <div class="breadcrumb py-2">
                        <a href="" class="breadcrumb-item"><i class="ph-house"></i></a>
                        <a href="" class="breadcrumb-item">Đợt đăng ký</a>
                        <span class="breadcrumb-item active">Đăng ký thực tập</span>
                    </div>

                    <a href="#breadcrumb_elements"
                        class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                        data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                    </a>
                </div>

            </div>
        </div>
    </x-slot>
    <div class="content d-flex justify-content-center align-items-center">

        <livewire:client.internship.internship-register campaignId="{{ $campaignId }}" />
        {{-- <livewire:client.teacher-modal campaignId="{{ $campaignId }}" />
        <livewire:client.company-modal /> --}}
    </div>
</x-layouts.client-layout>
