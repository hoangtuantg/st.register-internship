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
                        <a href="{{ route('admin.topics.create') }}" class="btn btn-teal">
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
                                        <button type="button" wire:click="topicDetail({{ $topic->id }})"
                                            class="dropdown-item" data-bs-toggle="modal" data-bs-target="#topicModal">
                                            <i class="ph-eye me-2"></i>
                                            Xem chi tiết
                                        </button>
                                        @unless ($topic->campaign->isEditOfficialExpired())
                                            @can('update', $topic)
                                                <a href="{{ route('admin.topics.edit', ['topic' => $topic->id]) }}"
                                                    class="dropdown-item">
                                                    <i class="ph-pencil me-2"></i>
                                                    Chỉnh sửa
                                                </a>
                                            @endcan
                                        @endunless

                                        @unless ($topic->campaign->isEditOfficialExpired())
                                            @can('delete', $topic)
                                                <button type="button" wire:click="openDeleteModal({{ $topic->id }})"
                                                    class="dropdown-item text-danger">
                                                    <i class="ph-trash me-2"></i>
                                                    Xóa
                                                </button>
                                            @endcan
                                        @endunless

                                        @if($topic->campaign->isEditOfficialExpired())
                                        <a type="button" wire:click="copy({{ $topic->id }})" class="dropdown-item">
                                            <i class="ph-copy me-2"></i>
                                            Sao chép
                                        </a>
                                        @endif
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
        <div wire:ignore.self class="modal fade" id="topicModal" tabindex="-1" aria-labelledby="topicsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="companyModalLabel">
                            Thông tin chi tiết đề tài
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($selectedTopic)
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Tên đề tài:</div>
                                <div class="col-md-8">{{ $selectedTopic->title }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Tên đợt đăng ký:</div>
                                <span
                                    class="badge bg-primary bg-opacity-20 text-primary w-auto">{{ $selectedTopic->campaign->name }}
                                    </sp>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Mô tả:</div>
                                <div class="col-md-8">{{ $selectedTopic->description }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
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
