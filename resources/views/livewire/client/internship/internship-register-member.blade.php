<div class="row login-row justify-content-center">
    <div class="col-12 col-xxl-11">
        <div class="card shadow-lg rounded-4 p-4">
            <div class="card-body">
                <div class="row">
                    <div>
                        <div class="mb-1 text-center">
                            <div class="gap-1 mt-2 mb-4 d-inline-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/FITA.png') }}" class="h-64px" alt="">
                                <img src="{{ asset('assets/images/logoST.jpg') }}" class="h-64px" alt="">
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="fw-bold text-primary">Đăng ký thành viên nhóm</h5>
                            <p class="mb-1">
                                <span class="fw-semibold">Nhóm trưởng:</span> {{ $student->name ?? '(Chưa có)' }}
                                <span class="fw-semibold">MSV:</span> {{ $student->code ?? '(Chưa có)' }}
                                <span class="fw-semibold">Lớp:</span> {{ $student->class ?? '(Chưa có)' }}
                            </p>
                            <p class="mb-1">
                                <span class="fw-semibold">Học phần:</span>
                                <span class="text-success">{{ $student->course?->name ?? '(Chưa có)' }}</span> -
                                <span class="text-muted">{{ $student->course?->code ?? '' }}</span>
                            </p>
                            <p>
                                <span class="fw-semibold">Thành viên nhóm:</span>
                                {{ count($studentChecked) + 1 }} / {{ $countMember }}
                            </p>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div
                            class="card-header d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                            <h6 class="mb-2 mb-md-0">Tìm và chọn thành viên vào nhóm</h6>
                            <input wire:model.live="search" type="text" class="form-control w-100 w-md-auto"
                                placeholder="Tìm theo tên, mã SV...">
                        </div>

                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>Họ và tên</th>
                                        <th>Mã sinh viên</th>
                                        <th>Lớp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                        <tr class="@if (in_array($student->code, $studentChecked)) table-success @endif">
                                            <td>
                                                <input type="checkbox" @if ($countMember == count($studentChecked) + 1 && !in_array($student->code, $studentChecked)) disabled @endif
                                                    :key="{{ $student->id }}"
                                                    wire:click="clickCheckBox('{{ $student->code }}')"
                                                    @if (in_array($student->code, $studentChecked)) checked @endif
                                                    class="form-check-input">
                                            </td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->code }}</td>
                                            <td>{{ $student->class }}</td>
                                        </tr>
                                    @empty
                                        <x-table.table-empty :colspan="5" />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Nút điều hướng --}}
                        <div class="d-flex justify-content-between mt-4">
                            <button wire:click="preStep" class="btn btn-warning">
                                <i class="ph-arrow-circle-left"></i> 
                                &nbsp;
                                Quay lại
                            </button>

                            <div>
                                <button wire:loading wire:target="nextStep" class="btn btn-primary" disabled>
                                    Đang xử lý... &nbsp;
                                    <i class="ph-circle-notch spinner me-1"></i>
                                </button>
                                <button wire:loading.remove wire:click="nextStep" class="btn btn-primary">
                                    Tiếp tục &nbsp;
                                    <i class="ph-arrow-circle-right me-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
