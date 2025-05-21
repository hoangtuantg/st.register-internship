@php use App\Common\Helpers @endphp
<table class="table">
    <thead>
        <tr class="table-light">
            <th>STT</th>
            <th>Nhóm</th>
            <th>Số lượng sinh viên</th>
            <th>Nhóm trưởng</th>
            <th>Họ đệm</th>
            <th>Tên</th>
            <th>Ngày sinh</th>
            <th>Mã sinh viên</th>
            <th>Lớp</th>
            <th>Mã học phần</th>
            <th>Tên học phần</th>
            <th>Đề tài thực tập</th>
            <th>Bộ môn quản lý</th>
            <th>Giáo viên hướng dẫn</th>
            <th>Mã GV</th>
            <th>Email GV</th>
            <th>Số điện thoại GV</th>
            <th>Công ty thực tập</th>
            <th>Cán bộ hướng dẫn thực tập</th>
            <th>Email Cán bộ hướng dẫn thực tập</th>
            <th>Số điện thoại Cán bộ hướng dẫn thực tập</th>
            <th>Email sinh viên</th>
            <th>Số điện thoại sinh viên</th>
            <th>Số điện thoại phụ huynh</th>
        </tr>
    </thead>
    <tbody>
        @php
            $index = 1;
        @endphp
        @foreach ($groups as $key => $group)
            @php
                $captainId = $group->captain?->id; // Lấy ID của nhóm trưởng
            @endphp
            @foreach ($group->students as $student)
                <tr>
                    <td>{{ $index }}</td>
                    <td>{{ $group->code }}</td>
                    <td>{{ $group->students->count() }}</td>
                    <td>{{ $student->id === $captainId ? '*' : '' }}</td>
                    <td>{{ Helpers::splitName($student->name)['lastName'] }}</td>
                    <td>{{ Helpers::splitName($student->name)['firstName'] }}</td>
                    <td>{{ \Carbon\Carbon::make($student->dob)->format('d/m/Y') }}</td>
                    <td>{{ $student->code }}</td>
                    <td>{{ $student->class }}</td>
                    <td>{{ $student->course->code }}</td>
                    <td>{{ $student->course->name }}</td>
                    <td>{{ $group->topic ?: 'Chưa có' }}</td>
                    <td>{{ $group->department ?: 'Chưa có' }}</td>
                    {{-- <td>{{ $group->teacher->name ?: 'Chưa có' }}</td> --}}
                    {{-- <td>{{ $group->teacher->code ?: 'Chưa có' }}</td> --}}
                    {{-- <td>{{ $group->teacher->email ?: 'Chưa có' }}</td> --}}
                    {{-- <td>{{ $group->teacher->phone ?: 'Chưa có' }}</td> --}}
                    <td>{{ $student->studentGroupOfficial->internship_company ?: 'Chưa có' }}</td>
                    <td>{{ $student->studentGroupOfficial->supervisor_company ?: 'Chưa có' }}</td>
                    <td>{{ $student->studentGroupOfficial->supervisor_company_email ?: 'Chưa có' }}</td>
                    <td>{{ $student->studentGroupOfficial->supervisor_company_phone ?: 'Chưa có' }}</td>
                    <td>{{ $student->studentGroupOfficial->email }}</td>
                    <td>{{ $student->studentGroupOfficial->phone }}</td>
                    <td>{{ $student->studentGroupOfficial->phone_family }}</td>
                </tr>
                @php
                    $index++;
                @endphp
            @endforeach
        @endforeach
    </tbody>
</table>
