<div class="w-100 px-0">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg rounded-4 p-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center gap-2">
                            <img src="{{ asset('assets/images/FITA.png') }}" class="h-64px" alt="">
                            <img src="{{ asset('assets/images/logoST.jpg') }}" class="h-64px" alt="">
                        </div>
                        <h5 class="fw-bold text-primary mt-3">{{ $campaign->name }}</h5>
                        <span class="text-muted">Đăng ký thông tin nhóm</span>
                    </div>

                    {{-- Thông tin từng thành viên --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light rounded-top-3">
                            <h6 class="mb-0 fw-semibold">Thông tin thành viên</h6>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="accordionMembers">
                                @foreach ($students as $student)
                                    <div class="accordion-item mb-2 rounded">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-semibold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#st{{ $student->code }}">
                                                {{ $student->name }} - MSV: {{ $student->code }} - Lớp:
                                                {{ $student->class }}
                                            </button>
                                        </h2>
                                        <div id="st{{ $student->code }}" class="accordion-collapse collapse"
                                            wire:ignore.self>
                                            <div class="accordion-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Email <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            wire:model.live="dataStudent.{{ $student->code }}.email">
                                                        @error('dataStudent.' . $student->code . '.email')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Số điện thoại <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            wire:model.live="dataStudent.{{ $student->code }}.phone">
                                                        @error('dataStudent.' . $student->code . '.phone')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">SĐT phụ huynh <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            wire:model.live="dataStudent.{{ $student->code }}.phone_family">
                                                        @error('dataStudent.' . $student->code . '.phone_family')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Tên công ty thực tập</label>
                                                        <input type="text" class="form-control"
                                                            wire:model.live="dataStudent.{{ $student->code }}.internship_company">
                                                        @error('dataStudent.' . $student->code . '.internship_company')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Thông tin đề tài & giáo viên --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light d-flex flex-wrap justify-content-between align-items-center">
                            <h6 class="mb-2 fw-semibold w-100 w-sm-auto">Đề tài & giáo viên hướng dẫn</h6>

                            {{-- Dropdown hiển thị ở màn hình lớn --}}
                            <div class="dropdown d-none d-sm-block">
                                <button class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="ph-list-checks me-1"></i> GVHD & Công ty
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#teachersModal">
                                            <i class="ph-chalkboard-teacher me-1"></i> Danh sách giảng viên
                                        </button></li>
                                    <li><button type="button" class="dropdown-item text-primary" data-bs-toggle="modal"
                                            data-bs-target="#companiesModal">
                                            <i class="ph-briefcase me-1"></i> Danh sách công ty
                                        </button></li>
                                </ul>
                            </div>

                            {{-- Dropdown hiển thị ở màn hình nhỏ --}}
                            <div class="dropdown d-block d-sm-none mt-2 w-100">
                                <button class="btn btn-success w-100 dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="ph-list-checks me-1"></i> GVHD & Công ty
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li><button type="button" class="dropdown-item text-success" data-bs-toggle="modal"
                                            data-bs-target="#teachersModal">
                                            <i class="ph-chalkboard-teacher me-1"></i> Danh sách giảng viên
                                        </button></li>
                                    <li><button type="button" class="dropdown-item text-primary" data-bs-toggle="modal"
                                            data-bs-target="#companiesModal">
                                            <i class="ph-briefcase me-1"></i> Danh sách công ty
                                        </button></li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Nguyện vọng đề tài</label>
                                    <input type="text" wire:model.live="topic" class="form-control">
                                    @error('topic')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12" wire:ignore>
                                    <label class="form-label">Giáo viên hướng dẫn</label>
                                    <div class="container-teacher">
                                    <select wire:model="supervisor" class="form-select" id="teacher">
                                        <option value=""></option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->code }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supervisor')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Nút điều hướng --}}
                    <div class="d-flex justify-content-between mt-4">
                        <button wire:click="preStep" class="btn btn-warning">
                            <i class="ph-arrow-circle-left me-1"></i> Quay lại
                        </button>
                        <div>
                            <button wire:loading wire:target="nextStepFinish" class="btn btn-primary" disabled>
                                <i class="ph-circle-notch spinner me-1"></i> Đang xử lý...
                            </button>
                            <button wire:loading.remove wire:click="nextStepFinish" class="btn btn-primary">
                                <i class="ph-arrow-circle-right me-1"></i> Đăng ký
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $('#teacher').select2({
            placeholder: 'Chọn giảng viên hướng dẫn đã nhận',
            allowClear: true,
            dropdownParent: $('.container-teacher')
        }).change(function(e) {
            Livewire.dispatch('updateSupervisor', [$(this).val()]);
        });
    </script>
@endscript
