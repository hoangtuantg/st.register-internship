<div>
    <div class="card">
        <div class="py-3 card-header">
            <div class="d-flex justify-content-between">

                <div class="flex-wrap gap-2 d-flex">
                    <div>
                        <input wire:model.live.debounce.500ms="search" type="text" class="form-control"
                            placeholder="Tìm kiếm...">
                    </div>
                </div>
                <div class="gap-2 d-flex">
                    <div>

                    </div>
                </div>
            </div>

        </div>

        <div class="table-responsive">
            <div wire:loading class="my-3 text-center w-100">
                <span class="spinner-border spinner-border-sm"></span> Đang tải dữ liệu...
            </div>

            <table class="table fs-table" wire:loading.remove>
                <thead>
                    <tr class="table-light">
                        <th width="5%">STT</th>
                        <th width="30%">Họ và tên</th>
                        <th width="15%">Trạng thái</th>
                        <th width="10%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $key =>  $item)
                        <tr>
                            <td class="text-center" width="5%">{{ $key + 1 + 10 * ($page - 1) }}</td>
                            <td width="30%">
                                <a class="fw-semibold" href="">
                                    <div class="gap-2 d-flex align-items-center">

                                        <img src="{{ Avatar::create($item['full_name'])->toBase64() }}"
                                            class="w-32px h-32px" alt="">
                                        <div class="flex-grow-1">
                                            <div>
                                                {{ $item['full_name'] }}
                                            </div>

                                            <div class="text-muted">
                                                {{ $item['email'] }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                @if ($item['local_status'] == App\Enums\TeacherStatusEnum::Accept->value)
                                    <span class="badge bg-success bg-opacity-20 text-success">
                                        {{ \App\Enums\TeacherStatusEnum::Accept->description() }}
                                    </span>
                                @elseif($item['local_status'] == App\Enums\TeacherStatusEnum::Refuse->value)
                                    <span class="badge bg-danger bg-opacity-20 text-danger">
                                        {{ \App\Enums\TeacherStatusEnum::Refuse->description() }}
                                    </span>
                                @endif
                            </td>

                            </td>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <button type="button" wire:click="accept({{ $item['id'] }})"
                                            class="dropdown-item text-success">
                                            <i class="ph-check-circle me-2"></i>
                                            Nhận hướng dẫn
                                        </button>
                                        <button type="button" wire:click="pause({{ $item['id'] }})"
                                            class="dropdown-item text-warning">
                                            <i class="ph-x-circle me-2"></i>
                                            Tạm dừng
                                        </button>
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
    <livewire:commons.pagination :currentPage="$page" :totalPages="$totalPages" />
</div>
