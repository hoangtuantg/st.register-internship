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
                            <div class="fs-sm opacity-75">
                                <a data-bs-toggle="collapse" href="#campaignList" role="button" aria-expanded="false"
                                    aria-controls="campaignList"
                                    class="text-white text-decoration-none d-inline-flex align-items-center">
                                    TTNN & KLTN
                                    <i class="ph-caret-down ms-2"></i>
                                </a>
                                <div class="collapse fs-sm opacity-75 {{ count($activeCampaigns) > 1 ? 'show' : '' }}"
                                    id="campaignList">
                                    @forelse ($activeCampaigns as $campaignName)
                                        <div>{{ $campaignName }}</div>
                                    @empty
                                        <div>Không có đợt đăng ký nào đang mở</div>
                                    @endforelse
                                </div>
                            </div>
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
                        <div class="progress mt-3" style="height: 15px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-white"
                                role="progressbar"
                                style="width: {{ $submittedPercent }}%; font-size: 0.5rem; font-weight: bold;"
                                aria-valuenow="{{ $submittedPercent }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $submittedPercent }}% hoàn thành
                            </div>
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
                        <div class="progress mt-3" style="height: 15px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success text-white"
                                role="progressbar"
                                style="width: {{ $approvedPercent }}%; font-size: 0.5rem; font-weight: bold;"
                                aria-valuenow="{{ $approvedPercent }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $approvedPercent }}% hoàn thành
                            </div>
                        </div>
                    </div>

                    <div class="rounded-bottom overflow-hidden" id="today-revenue"></div>
                </div>
            </div>
        </div>
        @if (count($campaignData) > 0)
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="ph-chart-pie me-2"></i>Chi tiết các đợt đăng ký đang mở</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($campaignData as $campaign)
                                    <div class="col-lg-12 col-md-6 mb-">
                                        <div class="card border">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0 text-truncate" title="{{ $campaign['name'] }}">
                                                    {{ $campaign['name'] }}
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div
                                                    class="d-flex flex-row justify-content-around align-items-start flex-wrap">
                                                    {{-- Biểu đồ sinh viên đăng ký thực tập --}}
                                                    <div class="text-center px-2" style="width: 250px;">
                                                        <h6 class="mt-2">Sinh viên đăng ký</h6>
                                                        <canvas id="studentChart{{ $campaign['id'] }}" width="250"
                                                            height="250"
                                                            style="max-width:220px; max-height:220px;"></canvas>
                                                        <small class="text-muted d-block mt-2">
                                                            Tổng sinh viên: {{ $campaign['totalStudents'] ?? 0 }}
                                                        </small>
                                                        <small class="text-muted d-block mt-2">
                                                            Hạn đăng ký: 
                                                            {{ $campaign['register_end'] ? \Carbon\Carbon::parse($campaign['register_end'])->format('d/m/Y') : 'Chưa có' }}
                                                        </small>
                                                    </div>

                                                    {{-- Biểu đồ báo cáo thực tập --}}
                                                    <div class="text-center px-2" style="width: 270px;">
                                                        <h6 class="mt-2">Báo cáo tổng kết</h6>
                                                        <canvas id="campaignChart{{ $campaign['id'] }}"
                                                            width="250" height="250"
                                                            style="max-width:250px; max-height:250px;"></canvas>
                                                        <small class="text-muted d-block">
                                                            Tổng: {{ $campaign['totalGroups'] }} nhóm
                                                        </small>
                                                        <small class="text-muted">
                                                            Hạn nộp:
                                                            {{ $campaign['report_deadline'] ? \Carbon\Carbon::parse($campaign['report_deadline'])->format('d/m/Y') : 'Chưa có' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.admin-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const campaignData = @json($campaignData);

        campaignData.forEach(function(campaign) {
            const ctx = document.getElementById(`campaignChart${campaign.id}`).getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Đã duyệt', 'Chờ duyệt', 'Đã hủy', 'Chưa nộp'],
                    datasets: [{
                        data: [
                            campaign.approvedReportCount,
                            // campaign.notApproved,
                            campaign.pendingReportCount,
                            campaign.rejectedReportCount,
                            campaign.notSubmitted
                        ],
                        backgroundColor: ['#4CAF50', '#FF9800', '#9E9E9E', '#F44336'],
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed;
                                    const total = campaign.totalGroups;
                                    const percent = total > 0 ? (value / total * 100)
                                        .toFixed(1) : 0;
                                    return `${context.label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });
            // Biểu đồ sinh viên:
            const ctx2 = document.getElementById(`studentChart${campaign.id}`);
            if (ctx2) {
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: ['Đã đăng ký', 'Chưa đăng ký'],
                        datasets: [{
                            data: [campaign.registeredStudents, campaign
                                .unregisteredStudents
                            ],
                            backgroundColor: ['#2196F3', '#B0BEC5'], // xanh & xám
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 10,
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const val = context.parsed;
                                        const total = campaign.registeredStudents + campaign
                                            .unregisteredStudents;
                                        const pct = total > 0 ? (val / total * 100).toFixed(
                                            1) : 0;
                                        return `${context.label}: ${val} (${pct}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    });
</script>
