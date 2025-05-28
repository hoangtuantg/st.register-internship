<div xmlns:livewire="http://www.w3.org/1999/html">
    <div class="card">
        <div class="py-3 card-header d-flex justify-content-between align-items-center">
            <div class="d-flex gap-2">
                <div>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Tìm kiếm...">
                </div>
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table fs-table table-hover table-scrollable">
                <thead>
                    <tr class="table-light">
                        <th class="w-16px">Nhóm</th>
                        <th>Tên đề tài</th>
                        <th>Số lượng sinh viên</th>
                        <th>Trạng thái</th>
                        <th>File báo cáo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                        <tr class=" cursor-pointer">
                            <td data-bs-toggle="collapse" class="bold" data-bs-target="#st{{ $group->id }}">
                                {{ $group->code }}</td>
                            <td data-bs-toggle="collapse" class="bold" data-bs-target="#st{{ $group->id }}">
                                {{ $group->topic }}</td>
                            <td data-bs-toggle="collapse" class="bold" data-bs-target="#st{{ $group->id }}">
                                {{ $group->students->count() }}</td>
                            <td data-bs-toggle="collapse" class="bold" data-bs-target="#st{{ $group->id }}">
                                @if (is_null($group->report_file))
                                    <span class="badge bg-secondary bg-opacity-20 text-secondary">
                                        Chưa nộp báo cáo
                                    </span>
                                @else
                                    @if ($group->report_status === \App\Enums\ReportStatusEnum::PENDING->value)
                                        <span class="badge bg-warning bg-opacity-20 text-warning">
                                            {{ \App\Enums\ReportStatusEnum::PENDING->description() }}
                                        </span>
                                    @elseif($group->report_status === \App\Enums\ReportStatusEnum::APPROVED->value)
                                        <span class="badge bg-success bg-opacity-20 text-success">
                                            {{ \App\Enums\ReportStatusEnum::APPROVED->description() }}
                                        </span>
                                    @elseif($group->report_status === \App\Enums\ReportStatusEnum::REJECTED->value)
                                        <span class="badge bg-danger bg-opacity-20 text-danger">
                                            {{ \App\Enums\ReportStatusEnum::REJECTED->description() }}
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ($group->report_file)
                                    <button type="button" class="dropdown-item text-teal" data-bs-toggle="modal"
                                        data-bs-target="#previewModal-{{ $group->id }}"
                                        onclick="loadDocxFile('{{ asset('storage/' . $group->report_file) }}', '{{ $group->id }}')">
                                        <i class="ph-eye me-2"></i> Xem trước
                                    </button>

                                    <!-- Modal xem trước -->
                                    <div class="modal fade" id="previewModal-{{ $group->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Xem trước báo cáo</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="word-preview-{{ $group->id }}"
                                                        style="max-height: 600px; overflow-y: auto; padding: 10px; border: 1px solid #ddd;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Chưa có báo cáo</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="text-body" data-bs-toggle="dropdown">
                                        <i class="ph-list"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @if ($group->report_file)
                                            @if ($group->report_status === 'approved')
                                                <button wire:click="downloadReport({{ $group->id }})"
                                                    class="dropdown-item text-primary">
                                                    <i class="ph-download-simple me-2"></i> Tải xuống
                                                </button>
                                            @endif
                                            <button wire:click="approveReport({{ $group->id }})"
                                                class="dropdown-item text-success">
                                                <i class="ph-check-circle me-2"></i> Duyệt báo cáo
                                            </button>
                                            <button wire:click="rejectReport({{ $group->id }})"
                                                class="dropdown-item text-danger">
                                                <i class="ph-x-circle me-2"></i> Báo cáo chưa đạt
                                            </button>
                                        @else
                                            <button class="dropdown-item text-muted disabled" disabled>
                                                <i class="ph-file-x me-2"></i> Không có file
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="st{{ $group->id }}" class="accordion-collapse collapse" wire:ignore.self>
                            <td colspan="7">
                                <div style="display: flex; justify-content: center; width: 100%;">
                                    <livewire:admin.group.group-official-member-index :group="$group"
                                        wire:key="group-{{ $group->id }}" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <x-table.table-empty :colspan="6" />
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
