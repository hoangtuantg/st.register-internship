<div>
    <div class="card">
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="d-flex gap-2">
                <div>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Tìm kiếm...">
                </div>
            </div>
            <div class="d-flex gap-2">
                <div>
                    <a href="{{ route('admin.plans.create') }}" type="button" class="btn btn-primary btn-icon px-2">
                        <i class="ph-plus-circle px-1"></i><span>Thêm mới</span>
                    </a>
                </div>
                <div>
                    <button type="button" class="btn btn-light btn-icon px-2" @click="$wire.$refresh">
                        <i class="ph-arrows-clockwise px-1"></i><span>Tải lại</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table fs-table ">
                <thead>
                    <tr class="table-light">
                        <th>STT</th>
                        <th>Tên bản mẫu kế hoạch</th>
                        <th>Mô tả</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td>{{ $loop->index + 1 + $plans->perPage() * ($plans->currentPage() - 1) }}</td>
                            <td><a href="{{ route('admin.plans.show', $plan->id) }}}">{{ $plan->name }}</a></td>
                            <td>{{ $plan->description }}</td>
                            <td class="text-center">
                                <div class="dropdown ">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('admin.plans.edit', ['plan' => $plan->id]) }}"
                                            class="dropdown-item">
                                            <i class="ph-note-pencil px-1"></i>
                                            Chỉnh sửa
                                        </a>
                                        <a type="button" wire:click="openDeleteModal({{ $plan->id }})"
                                            class="dropdown-item text-danger">
                                            <i class="ph-trash px-1"></i>
                                            Xóa
                                        </a>
                                        <a type="button" wire:click="copy({{ $plan->id }})" class="dropdown-item">
                                            <i class="ph-copy px-1"></i>
                                            Sao chép
                                        </a>
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
    {{ $plans->links('vendor.pagination.theme') }}
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
                    Livewire.dispatch('deletePlan')
                }
            })
        })
    </script>
@endscript
