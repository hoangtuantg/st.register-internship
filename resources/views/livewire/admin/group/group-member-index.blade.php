<div>
    <div class="mb-2">
        <h6>Thông tin sinh viên:</h6>
    </div>
    <div class="card">
        <table class="table table-striped table-scrollable">
            <thead>
            <tr class="table-light">
                <th>Họ và tên</th>
                <th>Mã sinh viên</th>
                <th>Lớp</th>
                <th>Mã học phần</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Số điện thoại phụ huynh</th>
                <th>Công ty thực tập</th>
            </tr>
            </thead>
            <tbody>
            @forelse($group->students as $student)
                <tr>
                    <td>{{ $student->name }} @if($student->groupStudent->is_captain) <span class="text-danger">*</span>@endif</td>
                    <td>{{ $student->code }}</td>
                    <td>{{ $student->class }}</td>
                    <td>{{ $student->course->code }}</td>
                    <td>{{ $student->groupStudent->email }}</td>
                    <td>{{ $student->groupStudent->phone }}</td>
                    <td>{{ $student->groupStudent->phone_family }}</td>
                    <td>{{ $student->groupStudent->internship_company ?: "Chưa có"}}</td>
                </tr>
            @empty
                <x-table.table-empty :colspan="9" />
            @endforelse
            </tbody>
        </table>
    </div>

</div>
