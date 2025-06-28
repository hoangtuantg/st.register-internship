<div>
    <div class="card accordion_collapsed">
        <div class="card-body">
            <div class="row d-flex justify-content-between">
                <div class="col-md-9 col-12">
                    <h6 class="fw-semibold text-primary">{{ $campaign?->name }}</h6>
                    <p class="mb-3"><b class="text-muted">Thời gian</b>:
                        {{ \Carbon\Carbon::make($campaign->start)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::make($campaign->end)->format('d/m/Y') }}</a></p>
                    <p class="mb-3"><b class="text-muted">Số công ty trong đợt</b>: {{ $campaign->companies->count() }}
                    </p>
                </div>
                <div class="col-md-3 col-12 d-flex justify-content-end">
                    @can('modifyCompanyCampaign',\App\Models\Company::class)
                    <button type="button" class="btn btn-success collapsed" style="height: max-content"
                        data-bs-toggle="collapse" data-bs-target="#collapsed_item1">
                        <i class="px-1 ph-plus-minus"></i><span>Thay đổi</span>
                    </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>  
    <div wire:ignore.self class="card collapse" id="collapsed_item1" data-bs-parent="#accordion_collapsed">
        <div class="card-body">
            <h6 class="fw-bold">Danh sách công ty:</h6>
            <form>
                <div class="border p-3 rounded">
                    @foreach ($companies as $company)
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input"
                                wire:click="toggleCompany({{ $company->id }})"
                                {{ in_array($company->id, $selectedCompanies) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $company->name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" wire:click="openConfirmModal({{ $campaign->id }})">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="py-3 card-header align-items-center">
            <div class="gap-2 d-flex justify-content-between">
                {{-- <div>
                    <p>Chi tiết các công ty trong đợt :</p>
                </div>
                <div>
                    <button type="button" class="px-2 btn btn-light btn-icon" wire:click="$refresh">
                        <i class="px-1 ph-arrows-clockwise"></i><span>Tải lại</span>
                    </button>
                </div> --}}
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table fs-table table-hover table-scrollable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên công ty</th>
                        <th>Số lượng nhận thực tập sinh</th>
                        <th>Xem chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($campaign->companies as $company)
                        <tr>
                            <td width="5%">{{ $loop->index + 1 }}</td>
                            <td width="40%">
                                <a href="
                                @can('updateCompanyCampaign',$company)
                                {{ route('admin.company-campaign.edit', ['campaign' => $campaign->id, 'company' => $company->id]) }}
                                @endcan
                                ">
                                    {{ $company->name }}
                                </a>
                            </td>
                            <td width="20%">{{ $company->pivot->amount }}</td>
                            <td width="15%">
                                <button type="button" wire:click="showCompanyDetail({{ $company->id }})"
                                    class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#companyModal">
                                    <i class="ph-eye text-primary fs-5"></i>
                                </button>
                            </td>
                            {{-- Modal --}}                            
                            <div wire:ignore.self class="modal fade" id="companyModal" tabindex="-1"
                                aria-labelledby="companiesModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="companyModalLabel">
                                                Thông tin chi tiết công ty
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($selectedCompany)
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Tên công ty:</div>
                                                    <div class="col-md-8">{{ $selectedCompany->name }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Số lượng thực tập sinh:</div>
                                                    <div class="col-md-8">{{ $selectedCompany->pivot->amount }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Mô tả công việc:</div>
                                                    <div class="col-md-8">{!! $selectedCompany->pivot->job_description !!}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@script
    <script>
        window.addEventListener('open-confirm-modal', () => {
            new swal({
                title: "Bạn có chắc chắn?",
                text: "Dữ liệu sau khi thay đổi không thể phục hồi!",
                showCancelButton: true,
                confirmButtonColor: "#FF7043",
                confirmButtonText: "Đồng ý!",
                cancelButtonText: "Đóng!"
            }).then((value) => {
                if (value.isConfirmed) {
                    Livewire.dispatch('saveCompany')
                }
            })
        })
    </script>
@endscript
