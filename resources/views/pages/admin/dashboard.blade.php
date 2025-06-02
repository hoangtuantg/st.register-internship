@php
    $auth = app(\App\Services\SsoService::class)->getDataUser();

    $hour = now()->hour;
    if ($hour < 12) {
        $greeting = 'Chào buổi sáng';
        $icon = 'ph-sun text-warning';
    } elseif ($hour < 18) {
        $greeting = 'Chào buổi chiều';
        $icon = 'ph-cloud-sun text-primary';
    } else {
        $greeting = 'Chào buổi tối';
        $icon = 'ph-moon text-info';
    }

    $quotes = [
        'Mỗi ngày là một cơ hội mới để thành công.',
        'Hãy bắt đầu bằng những việc nhỏ, nhưng đừng bao giờ từ bỏ.',
        'Bạn giỏi hơn bạn nghĩ nhiều đấy!',
        'Thành công không đến từ may mắn, mà từ sự kiên trì.',
        'Không bao giờ là quá muộn để bắt đầu một điều mới.',
        'Thành công là kết quả của sự kiên trì mỗi ngày.',
        'Nếu bạn mệt, hãy nghỉ – đừng bỏ cuộc.',
        'Hôm nay bạn chưa giỏi, nhưng bạn đang tốt hơn ngày hôm qua.',
        'Người thành công không hơn bạn, họ chỉ bắt đầu sớm hơn.',
        'Đừng chờ cơ hội – hãy tạo ra nó.',
        'Tốc độ không quan trọng, miễn là bạn không dừng lại.',
        'Hãy là phiên bản tốt nhất của chính mình – không phải bản sao của ai khác.',
        'Chỉ cần bắt đầu. Hành động sẽ tạo ra động lực.',
        'Bạn mạnh mẽ hơn những gì bạn nghĩ.',
        'Thất bại không phải là kết thúc, nó là bài học cho lần tới.',
        'Mỗi ngày là một cơ hội để viết lại câu chuyện của bạn.',
        'Không có bí quyết nào cho thành công ngoài chăm chỉ và bền bỉ.',
    ];
    $quote = $quotes[array_rand($quotes)];
@endphp
<x-layouts.admin-layout>
    <x-slot name="header">
        <div class="page-header page-header-light shadow">
            <div class="page-header-content d-lg-flex">
                <div class="d-flex">
                    <h4 class="page-title mb-0">
                        Dashboard
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
                        <span class="breadcrumb-item active">Dashboard</span>
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


    <div class="content">
        <div class="card p-3 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="{{ $icon }} me-2" style="font-size: 24px;"></i>
                <div>
                    <h5 class="fw-bold mb-1">{{ $greeting }}!</h5>
                    <p class="mb-0">Chúc bạn có một ngày làm việc hiệu quả, {{ $auth['full_name'] }}.</p>
                </div>
            </div>
        </div>
        <div class="card shadow-sm border-0 mt-3" style="background: linear-gradient(to right, #dfe9f3, #ffffff);">
            <div class="card-body d-flex align-items-start">
                <div class="me-3">
                    <i class="ph-quotes text-primary" style="font-size: 3rem;"></i>
                </div>
                <div>
                    <blockquote class="blockquote mb-0">
                        <p class="fs-5 fst-italic text-dark">“{{ $quote }}”</p>
                        <footer class="blockquote-footer mt-2 text-muted">Lời nhắn dành cho bạn </footer>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card bg-teal text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h1 class="mb-0">{{ $campaign }}</h1>
                            </div>
                            <div>
                                <i class="ph-telegram-logo fs-1"
                                    style="transform: scale(2.9); margin-right: 20px; color: rgba(255, 255, 255, 0.5);"></i>
                            </div>
                        </div>

                        <div>
                            <h3>Đợt đăng ký đang mở</h3>
                            <div class="fs-sm opacity-75">TTNN & KLTN</div>
                        </div>
                    </div>

                    <div class="rounded-bottom overflow-hidden mx-3" id="members-online"></div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-pink text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h1 class="mb-0">{{ $submittedPercent }}% </h1>
                            </div>
                            <div>
                                <i class="ph-file-doc fs-1"
                                    style="transform: scale(2.9); margin-right: 20px; color: rgba(255, 255, 255, 0.5);"></i>
                            </div>
                        </div>

                        <div>
                            <h3>Nhóm đã nộp báo cáo</h3>
                            <div class="fs-sm opacity-75"> Đã có {{ $submittedGroupCount }} nhóm nộp báo cáo</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h1 class="mb-0">{{ $approvedPercent }}%</h1>
                            </div>
                            <div>
                                <i class="ph-circle-wavy-check fs-1"
                                    style="transform: scale(2.9); margin-right: 20px; color: rgba(255, 255, 255, 0.5);"></i>
                            </div>
                        </div>

                        <div>
                            <h3>Báo cáo đã được duyệt</h3>
                            <div class="fs-sm opacity-75">Đã duyệt {{ $approvedReportCount }} báo cáo</div>
                        </div>
                    </div>

                    <div class="rounded-bottom overflow-hidden" id="today-revenue"></div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
