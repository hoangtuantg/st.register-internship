@php
    use App\Enums\StepRegisterEnum;
@endphp
<div class="content login-wrapper">
    <div class="card w-100">
        <div class="card-body">
            <div class="row login-row">
                <div class="col-xl-12">
                    @if (!$groupOfficial)
                        <div class="login-image-wrapper">
                            <div class="alert alert-danger text-center" style="border-radius: 12px;">
                                Tìm đồng đội của mình nào! <br>
                                Hiện tại bạn đang không nằm trong nhóm chính thức nào
                            </div>
                            <img class="login-image" src="{{ asset('assets/images/search.jpg') }}" alt="login">
                            <div class="line"></div>
                        </div>
                    @else
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center gap-2">
                                <img src="{{ asset('assets/images/FITA.png') }}" class="h-64px" alt="">
                                <img src="{{ asset('assets/images/logoST.jpg') }}" class="h-64px" alt="">
                            </div>
                            <h5 class="fw-bold text-primary mt-3">{{ $campaign->name }}</h5>
                            <span class="text-muted d-block">Thông tin nhóm chính thức</span>

                            <a class="d-inline-block mt-2 tooltip-container" wire:click="openPlanModal"
                                style="cursor: pointer;">
                                <i class="ph-calendar" style="font-size: 30px;"></i>
                                <span class="tooltip-text">{{ $planName }}</span>
                            </a>
                        </div>

                        <div class="group-info">
                            <div class="card">
                                <div class="card-header d-flex gap-2">
                                    <div>
                                        <div>Thông tin nhóm chính thức TTNN/KLTN</div>
                                        <b>Học phần {{ $this->student?->course?->name }}
                                            - {{ $this->student?->course?->code }}</b>
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <div class="accordion" id="accordion_collapsed">
                                        @foreach ($groupOfficial->students as $item)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button fw-semibold" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#st{{ $item->code }}">
                                                        {{ $item->name }} @if ($item->studentGroupOfficial->is_captain)
                                                            <span class="text-danger">*</span>
                                                        @endif - Mã sinh viên: {{ $item->code }}
                                                        -
                                                        Lớp: {{ $item->class }}
                                                    </button>
                                                </h2>
                                                <div id="st{{ $item->code }}"
                                                    class="accordion-collapse collapse show" wire:ignore.self>
                                                    <div class="accordion-body">
                                                        <div>Email:
                                                            <b>{{ $item->studentGroupOfficial->email ?: 'Chưa có' }}</b>
                                                        </div>
                                                        <div>Số điện thoại:
                                                            <b>{{ $item->studentGroupOfficial->phone ?: 'Chưa có' }}</b>
                                                        </div>
                                                        <div>Số điện thoại phụ huynh:
                                                            <b>{{ $item->studentGroupOfficial->phone_family ?: 'Chưa có' }}</b>
                                                        </div>
                                                        <div>Công ty thực tập:
                                                            <b>{{ $item->studentGroupOfficial->internship_company ?: 'Chưa có' }}</b>
                                                        </div>
                                                        <div>Cán bộ hướng dẫn thực tập:
                                                            <b>{{ $item->studentGroupOfficial?->supervisor_company ?? 'Chưa có' }}</b>
                                                        </div>
                                                        <div>Email Cán bộ hướng dẫn thực tập:
                                                            <b>{{ $item->studentGroupOfficial?->supervisor_company_email ?? 'Chưa có' }}</b>
                                                        </div>
                                                        <div>SĐT Cán bộ hướng dẫn thực tập:
                                                            <b>{{ $item->studentGroupOfficial?->supervisor_company_phone ?? 'Chưa có' }}</b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    Thông tin đề tài và GVHD
                                </div>
                                <div class="card-body p-2">
                                    <div>Tên đề tài: <b>{{ $groupOfficial->topic ?: 'Chưa có' }}</b></div>
                                    <div>Tên GVHD: <b>{{ $groupOfficial->supervisor ?: 'Chưa có' }}</b></div>
                                </div>
                            </div>

                            {{-- <div class="card">
                                <div class="card-header">
                                    Trạng thái báo cáo tổng kết
                                </div>
                                <div class="card-body p-2">
                                    @if (is_null($groupOfficial->report_file))
                                        <span class="badge bg-secondary bg-opacity-20 text-secondary">
                                            Chưa nộp báo cáo
                                        </span>
                                    @else
                                        @if ($groupOfficial->report_status === \App\Enums\ReportStatusEnum::PENDING->value)
                                            <span class="badge bg-warning bg-opacity-20 text-warning">
                                                Báo cáo đã được nộp. Vui lòng chờ duyệt ...
                                            </span>
                                        @elseif($groupOfficial->report_status === \App\Enums\ReportStatusEnum::APPROVED->value)
                                            <span class="badge bg-success bg-opacity-20 text-success">
                                                Tuyệt vời!!! Báo cáo đã được duyệt
                                            </span>
                                        @elseif($groupOfficial->report_status === \App\Enums\ReportStatusEnum::REJECTED->value)
                                            <span class="badge bg-danger bg-opacity-20 text-danger">
                                                Báo cáo chưa đáp ứng yêu cầu. Vui lòng chỉnh sửa và nộp lại !!!
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div> --}}
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-file-alt me-1 text-primary"></i> Trạng thái báo cáo tổng kết
                                    </h6>

                                    @if (!is_null($groupOfficial->report_file))
                                        <button data-bs-toggle="modal"
                                            data-bs-target="#previewModal-{{ $groupOfficial->id }}"
                                            onclick="loadDocxFile('{{ asset('storage/' . $groupOfficial->report_file) }}', '{{ $groupOfficial->id }}')"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="ph-eye"></i> &nbsp;Xem báo cáo
                                        </button>
                                        <!-- Modal xem trước -->
                                        <div class="modal fade" id="previewModal-{{ $groupOfficial->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Xem trước báo cáo</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="word-preview-{{ $groupOfficial->id }}"
                                                            style="max-height: 600px; overflow-y: auto; padding: 10px; border: 1px solid #ddd;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body py-3 px-4">
                                    @if (is_null($groupOfficial->report_file))
                                        <div class="alert alert-secondary d-flex align-items-center mb-0"
                                            role="alert">
                                            <i class="ph-x-circle me-2"></i>
                                            Chưa nộp báo cáo. Đừng quên hạn nộp là ngày
                                            <strong class="ms-1">{{ $reportDeadline }}</strong>
                                            &nbsp;nhé !!!
                                        </div>
                                    @else
                                        @if ($groupOfficial->report_status === \App\Enums\ReportStatusEnum::PENDING->value)
                                            <div class="alert alert-warning d-flex align-items-center mb-0"
                                                role="alert">
                                                <i class="ph-hourglass-high me-2"></i>
                                                Báo cáo đã được nộp. Vui lòng chờ duyệt ...
                                            </div>
                                        @elseif ($groupOfficial->report_status === \App\Enums\ReportStatusEnum::APPROVED->value)
                                            <div class="alert alert-success d-flex align-items-center mb-0"
                                                role="alert">
                                                <i class="ph-check-circle me-2"></i>
                                                Tuyệt vời!!! Báo cáo đã được duyệt
                                            </div>
                                        @elseif ($groupOfficial->report_status === \App\Enums\ReportStatusEnum::REJECTED->value)
                                            <div class="alert alert-danger d-flex align-items-center mb-0"
                                                role="alert">
                                                <i class="ph-warning me-2"></i>
                                                Báo cáo chưa đáp ứng yêu cầu. Vui lòng chỉnh sửa và nộp lại !!!
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="mt-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                @if ($this->student->studentGroupOfficial->is_captain && !$campaign->isEditOfficialExpired())
                                    <div class="mt-2">
                                        <button wire:loading class="btn btn-primary" wire:target="editGroupOfficial">
                                            <i class="ph-circle-notch spinner"></i>
                                            &nbsp;Chỉnh sửa thông tin nhóm
                                        </button>

                                        <button wire:loading.remove class="btn btn-primary"
                                            wire:click="editGroupOfficial">
                                            <i class="ph-note-pencil"></i>
                                            &nbsp;Chỉnh sửa thông tin nhóm
                                        </button>
                                    </div>
                                @endif
                                @if (!$campaign->isReportDeadlineExpired() && $this->student->studentGroupOfficial->is_captain)
                                    <div class="mt-2">
                                        <button wire:loading class="btn btn-teal" wire:target="sendReport">
                                            <i class="ph-circle-notch spinner"></i>
                                            &nbsp;Nộp báo cáo
                                        </button>

                                        <button wire:loading.remove class="btn btn-teal" wire:click="sendReport">
                                            <i class="ph-file-doc"></i>
                                            &nbsp;Nộp báo cáo
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div id="modal-plan" wire:ignore.self class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"> {{ $planName }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive table-scrollable border-top">
                        <table class="table fs-table">
                            <thead>
                                <tr class="table-light">
                                    <th>STT</th>
                                    <th>Thời gian</th>
                                    <th>Nội dung thực hiện</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($plans as $plan)
                                    <tr>
                                        <td>{{ $loop->index + 1 + $plans->perPage() * ($plans->currentPage() - 1) }}
                                        </td>
                                        <td>
                                            @if ($plan->time)
                                                {{ \Carbon\Carbon::make($plan->end_date)->format('d/m/Y') }}
                                            @else
                                                {{ \Carbon\Carbon::make($plan->start_date)->format('d/m/Y') }} -
                                                {{ \Carbon\Carbon::make($plan->end_date)->format('d/m/Y') }}
                                            @endif
                                        </td>
                                        <td>{!! $plan->content !!}</td>
                                    </tr>
                                @empty
                                    <x-table.table-empty :colspan="3" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        window.addEventListener('open-plan-modal', () => {
            $('#modal-plan').modal('show')
        })
    </script>
@endscript
