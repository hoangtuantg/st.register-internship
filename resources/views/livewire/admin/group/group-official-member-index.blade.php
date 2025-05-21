<div style="max-width: 880px; overflow-x: hidden;">
    <div class="mb-2">
        <h6>Thông tin sinh viên:</h6>
    </div>

    <div class="card" style="overflow-x: auto; max-width: 100%; padding: 1rem;">
        <table class="table table-striped" style="width: max-content; min-width: 100%; white-space: nowrap;">
            <thead>
                <tr class="table-light">
                    <th>Họ và tên</th>
                    <th>Mã sinh viên</th>
                    <th>Lớp</th>
                    <th>Mã học phần</th>
                    <th style="min-width: 140px;">Email</th>
                    <th style="min-width: 130px;">Số điện thoại</th>
                    <th style="min-width: 160px;">SĐT phụ huynh</th>
                    <th style="min-width: 180px;">Công ty thực tập</th>
                    <th style="min-width: 180px;">Cán bộ hướng dẫn</th>
                </tr>
            </thead>
            <tbody>
                @forelse($group->students as $student)
                    <tr>
                        <td>{{ $student->name }} @if ($student->studentGroupOfficial->is_captain)
                                <span class="text-danger">*</span>
                            @endif
                        </td>
                        <td>{{ $student->code }}</td>
                        <td>{{ $student->class }}</td>
                        <td>{{ $student->course->code }}</td>
                        <td>{{ $student->studentGroupOfficial->email }}</td>
                        <td>{{ $student->studentGroupOfficial->phone }}</td>
                        <td>{{ $student->studentGroupOfficial->phone_family }}</td>
                        <td>{{ $student->studentGroupOfficial->internship_company ?: 'Chưa có' }}</td>
                        <td>{{ $student->studentGroupOfficial->supervisor_company ?: 'Chưa có' }}</td>
                    </tr>
                @empty
                    <x-table.table-empty :colspan="9" />
                @endforelse
            </tbody>
        </table>
    </div>
</div>
