<div xmlns:livewire="http://www.w3.org/1999/html">
    <div class="card">
        <div class="py-3 card-header d-flex justify-content-between align-items-center">
            <div class="gap-2 d-flex">
                <div>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Tìm kiếm...">
                </div>
            </div>
            <div class="gap-2 d-flex flex-wrap">
                <p>Số nhóm : <b> {{$groups->total()}} </b></p>
                <p>Số sinh viên đăng ký: <b> {{$studentRegister}} </b></p>
            </div>
            <div class="gap-2 d-flex">
                <div>

                    <button type="button" class="px-2 btn btn-success btn-icon" wire:click="openImportGroupModal()">
                        <i class="px-1 ph-microsoft-excel-logo"></i><span>Import danh sách</span>
                    </button>

                    @if (count($groups) > 0)
                        <button  wire:loading wire:target="export" type="button" class="px-2 btn btn-success btn-icon" >
                            <i class="px-1 ph-circle-notch spinner"></i><span>Export danh sách</span>
                        </button  >
                        <button wire:loading.remove type="button" class="px-2 btn btn-success btn-icon" wire:click="export()">
                            <i class="px-1 ph-microsoft-excel-logo"></i><span>Export danh sách</span>
                        </button>
                    @endif

                    <button type="button" class="px-2 btn btn-light btn-icon" wire:click="$refresh">
                        <i class="px-1 ph-arrows-clockwise"></i><span>Tải lại</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive-md">
            <table class="table fs-table table-hover table-scrollable">
                <thead>
                    <tr class="table-light ">
                        <th class="w-16px">Nhóm</th>
                        <th class="w-25">Tên đề tài</th>
                        <th>Bộ môn quản lý</th>
                        <th>Giảng viên hướng dẫn</th>
                        <th>Số lượng sinh viên</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                        <tr class=" cursor-pointer">

                            <td data-bs-toggle="collapse" class="bold" data-bs-target="#st{{ $group->id }}">
                                {{ $group->code }}</td>
                            <td data-bs-toggle="collapse" class="bold" data-bs-target="#st{{ $group->id }}">
                                {{ $group->topic ?: 'Chưa có' }}</td>
                            <td data-bs-toggle="collapse" class="bold" data-bs-target="#st{{ $group->id }}">
                                {{ $group->department ?: 'Chưa có' }}</td>
                            <td data-bs-toggle="collapse" class="bold" data-bs-target="#st{{ $group->id }}">
                                {{ $group->teacher?->name ?: 'Chưa có' }}</td>
                            <td data-bs-toggle="collapse" data-bs-target="#st{{ $group->id }}">
                                {{ $group->students->count() }}</td>

                            <td data-bs-toggle="collapse" data-bs-target="#st{{ $group->id }}">
                                {{ $group->created_at->format('H:i d/m/Y') }}</td>

                        </tr>
                        <tr id="st{{ $group->id }}" class="accordion-collapse collapse" wire:ignore.self>
                            <td colspan="7">
                                <livewire:admin.group.group-official-member-index :group="$group"
                                    wire:key="group-{{ $group->id }}" />
                            </td>
                        </tr>

                    @empty
                        <x-table.table-empty :colspan="7" />
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $groups->links('vendor.pagination.groups-official') }}
    <livewire:admin.group.group-official-import :campaignId="$campaignId" />

</div>

@script
    <script>
        window.addEventListener('open-import-group-modal', () => {
            $('#model-import-group').modal('show')
        })


        window.addEventListener('close-import-group-modal', () => {
            $('#model-import-group').modal('hide')
        })

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
                    Livewire.dispatch('deleteGroup')
                }
            })
        })
    </script>
@endscript
