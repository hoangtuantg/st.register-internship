<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9 col-12">
                    <h6 class="fw-semibold">{{ $campaign?->name }}</h6>
                    <p class="mb-3"><b>Thời gian</b>: {{ \Carbon\Carbon::make($campaign->start)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::make($campaign->end)->format('d/m/Y') }}</a></p>
                    <p class="mb-3"><b>Thời gian chỉnh sửa chính thức</b>:
                        {{ $campaign->official_end ? \Carbon\Carbon::make($campaign->official_end)->format('d/m/Y') : '' }}</a>
                    </p>
                    <p class="mb-3"><b>Số thành viên tối đa mỗi nhóm</b>: {{ $campaign->max_student_group }}</p>
                    {{-- <p class="mb-3"><b>Link đăng ký</b>: <a href="{{route('internship.register', $campaign->id)}}" target="_blank">{{ route('internship.register', $campaign->id) }}</a></p> --}}
                </div>
                <div class="col-md-3 col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" type="button"
                        class="btn btn-primary d-block" style="height: max-content"><i class="ph-note-pencil"></i> Chỉnh
                        sửa</a>

                    <a href="{{ route('admin.campaigns.index') }}" type="button" class="btn btn-warning d-block"
                        style="height: max-content"><i class="ph-arrow-counter-clockwise"></i> Trở lại</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#js-tab1" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                        Danh sách sinh viên đủ điều kiện
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="#js-tab2" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                        tabindex="-1">
                        Nhóm nguyện vọng
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="#js-tab3" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                        tabindex="-1">
                        Nhóm chính thức
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade active show" id="js-tab1" role="tabpanel">
                    <div class="tab-pane fade active show" id="js-tab1" role="tabpanel">
                        <livewire:admin.student.student-index :campaignId="$campaignId" />
                    </div>
                </div>

                <div class="tab-pane fade" id="js-tab2" role="tabpanel">
                    <livewire:admin.company.company-index />
                </div>
                <div class="tab-pane fade" id="js-tab3" role="tabpanel">
                    <livewire:admin.campaign.campaign-index />
                </div>
            </div>
        </div>
    </div>
</div>
