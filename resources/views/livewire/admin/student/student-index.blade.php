<div style="max-width: 100%; overflow-x: hidden;">
    <div class="card" style="overflow-x: auto; max-width: 100%; padding: 1rem;">
        <div class="py-3 card-header d-flex justify-content-between align-items-center">
            <div class="gap-2 d-flex">
                <div>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Tìm kiếm...">
                </div>
            </div>
            <div class="gap-2 d-flex">
                <div>
                    <button type="button" class="px-2 btn btn-success btn-icon" wire:click="openImportModal()">
                        <i class="px-1 ph-microsoft-excel-logo"></i><span>Import Sinh viên</span>
                    </button>
                    <button type="button" class="px-2 btn btn-light btn-icon" wire:click="$refresh">
                        <i class="px-1 ph-arrows-clockwise"></i><span>Tải lại</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive-md" style="width: max-content; min-width: 100%; white-space: nowrap;">
            <table class="table fs-table">
                <thead>
                <tr class="table-light">
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Ngày sinh</th>
                    <th>Mã sinh viên</th>
                    <th>Lớp</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Mã học phần</th>
                    <th>Tên học phần</th>
                    <th class="text-center">Số tín chỉ</th>

                </tr>
                </thead>
                <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $loop->index + 1 + $students->perPage() * ($students->currentPage() - 1) }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->dob ? \Carbon\Carbon::make($student->dob)->format('d/m/Y') : '' }}</td>

                        <td>{{ $student->code }}</td>
                        <td>{{ $student->class }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->course->code ?? ''}}</td>
                        <td>{{ $student->course->name ?? ''}}</td>
                        <td class="text-center">{{ $student->credit }}</td>
                    </tr>
                @empty
                    <x-table.table-empty :colspan="10" />
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $students->links('vendor.pagination.theme') }}
    <livewire:admin.student.student-import :campaignId="$campaignId"/>

</div>

@script
<script>
    window.addEventListener('open-import-modal', () => {
        $('#model-import').modal('show')
    })

    window.addEventListener('close-import-modal', () => {
        $('#model-import').modal('hide')
    })

</script>
@endscript