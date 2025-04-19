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
                    @can('create', \App\Models\Campaign::class)
                    <a href="{{route('admin.campaigns.create')}}" type="button" class="btn btn-primary btn-icon px-2">
                        <i class="ph-plus-circle px-1"></i><span>Thêm mới</span>
                    </a>
                    @endcan
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
                        <th>Tên đợt đăng ký</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td>{{ $loop->index + 1 + $campaigns->perPage() * ($campaigns->currentPage() - 1) }}</td>
                            <td><a href="{{route('admin.campaigns.show', $campaign->id)}}">{{ $campaign->name }}</a>
                            </td>
                            <td>{{ \Carbon\Carbon::make($campaign->start)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::make($campaign->end)->format('d/m/Y') }}</td>
                            <td>{{ $campaign->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="dropdown ">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @can('update',$campaign)
                                        <a href="{{ route('admin.campaigns.edit', $campaign->id) }}"
                                            class="dropdown-item">
                                            <i class="ph-note-pencil px-1"></i>
                                            Chỉnh sửa
                                        </a>
                                        @endcan

                                        @can('delete',$campaign)
                                        <a type="button" wire:click="openDeleteModal({{ $campaign->id }})"
                                            class="dropdown-item">
                                            <i class="ph-trash px-1"></i>
                                            Xóa
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table.table-empty :colspan="6" />

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $campaigns->links('vendor.pagination.theme') }}
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
                    Livewire.dispatch('deleteCampaign')
                }
            })
        })
    </script>
@endscript
