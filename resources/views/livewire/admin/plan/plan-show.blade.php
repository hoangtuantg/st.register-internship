<div class="mt-2">
    <div class="card">
        <div class="py-3 card-header d-flex justify-content-between align-items-center">
            <div class="gap-2 d-flex">
                <div>
                    <a>
                        <h6 class="fw-semibold text-primary">{{ $plan?->name }}</h6>
                    </a>
                </div>
            </div>
            <div class="gap-3 d-flex">
                <div>
                    @can('createDetail', $plan)
                        <a href="{{ route('admin.plans.createPlanDetail', $planId) }}" type="button"
                            class="btn btn-success btn-icon px-2">
                            <i class="ph-calendar-plus px-1"></i><span>Thêm công việc</span>
                        </a>
                    @endcan
                    <button type="button" class="px-2 btn btn-light btn-icon" wire:click="$refresh">
                        <i class="px-1 ph-arrows-clockwise"></i><span>Tải lại</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table fs-table">
                <thead>
                    <tr class="table-light">
                        <th>STT</th>
                        <th>Thời gian</th>
                        <th>Nội dung thực hiện</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($planDetails as $planDetail)
                        <tr>
                            <td>{{ $loop->index + 1 + $planDetails->perPage() * ($planDetails->currentPage() - 1) }}
                            </td>
                            <td>
                                @if ($planDetail->time)
                                    {{ \Carbon\Carbon::make($planDetail->end_date)->format('d/m/Y') }}
                                @else
                                    {{ \Carbon\Carbon::make($planDetail->start_date)->format('d/m/Y') }}
                                    -
                                    {{ \Carbon\Carbon::make($planDetail->end_date)->format('d/m/Y') }}
                                @endif
                            </td>
                            <td>{!! $planDetail->content !!}</td>
                            <td class="text-center">
                                <div class="dropdown ">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @can('editDetail', $plan)
                                            <a href="{{ route('admin.plans.editPlanDetail', $planDetail->id) }}"
                                                class="dropdown-item">
                                                <i class="ph-note-pencil px-1"></i>
                                                Chỉnh sửa
                                            </a>
                                        @endcan

                                        @can('deleteDetail', $plan)
                                        <a type="button" wire:click="openPlanDetailModal({{ $planDetail->id }})"
                                            class="dropdown-item text-danger">
                                            <i class="ph-trash px-1"></i>
                                            Xóa
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table.table-empty :colspan="4" />
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $planDetails->links('vendor.pagination.theme') }}
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
                    Livewire.dispatch('deletePlanDetail')
                }
            })
        })
    </script>
@endscript
