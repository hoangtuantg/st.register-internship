<div xmlns:livewire="http://www.w3.org/1999/html">
    <div class="card">
        <div class="py-3 card-header d-flex justify-content-between align-items-center">
            <div class="gap-2 d-flex">
                <input wire:model.live="search" type="text" name="q" class="form-control" placeholder="Tìm kiếm..."
                    id="user-search-input">
            </div>
            <div class="ms-auto">
                <a href="{{ route('admin.companies.create') }}" type="button" class="btn btn-success btn-icon px-2">
                    <i class="ph-plus-circle px-1"></i><span>Thêm mới</span>
                </a>
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table fs-table table-hover table-scrollable">
                <thead>
                    <tr class="table-light ">
                        <th>STT</th>
                        <th>Tên công ty</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Mô tả</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)
                        <tr>
                            <td>{{ $loop->index + 1 + $companies->perPage() * ($companies->currentPage() - 1) }}</td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->phone }}</td>
                            <td>{{ Str::limit(strip_tags($company->description), 50, '...') }}</td>
                            <td class="text-center">
                                @if ($company->status === \App\Enums\RecruitmentStatusEnum::Closed->value)
                                    <span class="badge bg-danger bg-opacity-20 text-danger">
                                        {{ \App\Enums\RecruitmentStatusEnum::Closed->description() }}
                                    </span>
                                @elseif($company->status === \App\Enums\RecruitmentStatusEnum::Open->value)
                                    <span class="badge bg-success bg-opacity-20 text-success">
                                        {{ \App\Enums\RecruitmentStatusEnum::Open->description() }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <button type="button" wire:click="openRecruitment({{ $company->id }})"
                                            class="dropdown-item text-success">
                                            <i class="ph-check-circle me-2"></i>
                                            Nhận thực tập
                                        </button>
                                        <button type="button" wire:click="cancelRecruitment({{ $company->id }})"
                                            class="dropdown-item text-warning">
                                            <i class="ph-x-circle me-2"></i>
                                            Tạm dừng
                                        </button>
                                        <button type="button" wire:click="showCompanyDetail({{ $company->id }})"
                                            class="dropdown-item" data-bs-toggle="modal" data-bs-target="#companyModal">
                                            <i class="ph-eye me-2"></i>
                                            Xem chi tiết
                                        </button>

                                        <a href="{{ route('admin.companies.edit', ['company' => $company->id]) }}"
                                            class="dropdown-item">
                                            <i class="ph-pencil me-2"></i>
                                            Chỉnh sửa
                                        </a>
                                        <button type="button" wire:click="openDeleteModal({{ $company->id }})"
                                            class="dropdown-item text-danger">
                                            <i class="ph-trash me-2"></i>
                                            Xóa
                                        </button>
                                    </div>
                                </div>
                            </td>

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
                                                    <div class="col-md-4 fw-bold">Email:</div>
                                                    <div class="col-md-8">{{ $selectedCompany->email }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Số điện thoại:</div>
                                                    <div class="col-md-8">{{ $selectedCompany->phone }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Địa chỉ:</div>
                                                    <div class="col-md-8">{{ $selectedCompany->address }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-bold">Mô tả:</div>
                                                    <div class="col-md-8">{{ $selectedCompany->description }}</div>
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

                    @empty
                        <x-table.table-empty :colspan="8" />
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $companies->links('vendor.pagination.groups-official') }}
</div>

@script
    <script>
        window.addEventListener('openDeleteModal', () => {
            new swal({
                title: "Bạn có chắc chắn?",
                text: "Dữ liệu sau khi xóa không thể phục hồi!",
                showCancelButton: true,
                confirmButtonColor: "#FF7043",
                confirmButtonText: "Đồng ý!",
                cancelButtonText: "Đóng!"
            }).then((value) => {
                if (value.isConfirmed) {
                    Livewire.dispatch('deleteCompany')
                }
            })
        })
    </script>
@endscript
