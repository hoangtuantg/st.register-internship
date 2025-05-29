<div>
    <div class="card">
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="d-flex gap-2">
                <div>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Tìm kiếm...">
                </div>
            </div>
            <div class="d-flex gap-1">
                <div>
                    @can('create', \App\Models\Topic::class)
                    <a href="{{route('admin.topics.create')}}" class="btn btn-teal">
                        <i class="ph-plus-circle me-1">
                            </i> Tạo mới
                    </a>
                    @endcan                
                </div>
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table fs-table ">
                <thead>
                    <tr class="table-light">
                        <th>STT</th>
                        <th>Tên đề tài</th>
                        <th>Tên đợt đăng ký</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topics as $topic)
                        <tr>
                            <td>{{ $loop->index + 1 + $topics->perPage() * ($topics->currentPage() - 1) }}</td>
                            <td>{{ $topic->title }}</td>
                            <td>{{ $topic->campaign->name }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @can('update', $topic)
                                        <a href="{{route('admin.topics.edit',  ['topic' => $topic->id])}}" class="dropdown-item">
                                            <i class="ph-pencil me-2"></i>
                                            Chỉnh sửa
                                        </a>
                                        @endcan

                                        @can('delete', $topic)
                                        <button type="button" wire:click="openDeleteModal({{ $topic->id }})" class="dropdown-item text-danger">
                                            <i class="ph-trash me-2"></i>
                                            Xóa
                                        </button>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table.table-empty :colspan="5" />
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $topics->links('vendor.pagination.theme') }}
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
                Livewire.dispatch('deleteTopic')
            }
        })
    })


</script>
@endscript
