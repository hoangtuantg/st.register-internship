@php
    use App\Enums\StepRegisterEnum;
@endphp
<div class="content login-wrapper">
    <div class="card w-100">
        <div class="card-body">
            <div class="row login-row">
                <div class="col-xl-12">
                    @if (!$group)
                        <div class="login-image-wrapper">
                            <div class="alert alert-danger text-center" style="border-radius: 12px;">
                                Tìm đồng đội của mình nào! <br>
                                Hiện tại bạn đang không nằm trong nhóm nguyện vọng thực tập nào
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
                            <span class="text-muted d-block">Thông tin nhóm nguyện vọng</span>

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
                                        <div>Thông tin nhóm nguyện vọng TTNN/KLTN</div>
                                        <b>Học phần {{ $this->student?->course?->name }}
                                            - {{ $this->student?->course?->code }}</b>
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <div class="accordion" id="accordion_collapsed">
                                        @foreach ($group->students as $item)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button fw-semibold" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#st{{ $item->code }}">
                                                        {{ $item->name }} @if ($item->code == $isCaptain)
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
                                                            <b>{{ $item->groupStudent->email ?: 'Chưa có' }}</b>
                                                        </div>
                                                        <div>Số điện thoại:
                                                            <b>{{ $item->groupStudent->phone ?: 'Chưa có' }}</b>
                                                        </div>
                                                        <div>Số điện thoại phụ huynh:
                                                            <b>{{ $item->groupStudent->phone_family ?: 'Chưa có' }}</b>
                                                        </div>
                                                        <div>Công ty thực tập:
                                                            <b>{{ $item->groupStudent->internship_company ?: 'Chưa có' }}</b>
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
                                    <div>Tên đề tài: <b>{{ $group->topic ?: 'Chưa có' }}</b></div>
                                    <div>Tên GVHD: <b>{{ $group->supervisor ?: 'Chưa có' }}</b></div>
                                </div>
                            </div>
                            @if ($this->student->groupStudent->is_captain && $campaign->isExpired())
                                <div class="mt-2">
                                    <button wire:loading class="btn btn-primary" wire:target="editGroup">
                                        <i class="ph-circle-notch spinner"></i>
                                        &nbsp;Chỉnh sửa thông tin nhóm
                                    </button>

                                    <button wire:loading.remove class="btn btn-primary" wire:click="editGroup">
                                        <i class="ph-note-pencil"></i>
                                        &nbsp;Chỉnh sửa thông tin nhóm
                                    </button>
                                </div>
                            @endif
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
