<div class="content login-wrapper">
    <div class="card w-100">
        <div class="card-body">
            <div class="row login-row">
                <div class="col-12">
                    <div class="mb-3 text-center">
                        <div class="gap-1 mt-2 mb-4 d-inline-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/images/FITA.png') }}" class="h-64px" alt="">
                            <img src="{{ asset('assets/images/logoST.jpg') }}" class="h-64px" alt="">
                        </div>
                        <span class="d-block text-muted">Thông tin nhóm chính thức</span>
                        <h5 class="mb-0 p-2">{{ $campaign?->name }}</h5>
                    </div>

                    <div class="mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Thông tin thành viên</h5>
                            </div>

                            <div class="card-body">
                                <div class="accordion" id="accordion_collapsed">
                                    @foreach ($students as $key => $student)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button fw-semibold" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#st{{ $student?->code }}">
                                                    {{ $student?->name }} - Mã sinh viên: {{ $student?->code }} -
                                                    Lớp: {{ $student?->class }}
                                                </button>
                                            </h2>
                                            <div id="st{{ $student?->code }}" class="accordion-collapse collapse show"
                                                wire:ignore.self>
                                                <div class="accordion-body">
                                                    <form class="form-validate-jquery" action="#">
                                                        <div class="mb-4">
                                                            <!-- Maximum number -->
                                                            <div class="row mb-3">
                                                                <label class="col-form-label col-lg-3">Email <span
                                                                        class="text-danger">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text"
                                                                        wire:model.live="dataStudent.{{ $student?->code }}.email"
                                                                        class="form-control" required>
                                                                    @error('dataStudent.' . $student?->code . '.email')
                                                                        <label id="error-{{ $student?->code }}-email"
                                                                            class="validation-error-label text-danger"
                                                                            for="email-{{ $student?->code }}">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-form-label col-lg-3">Số điện thoại
                                                                    <span class="text-danger">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text"
                                                                        wire:model.live="dataStudent.{{ $student?->code }}.phone"
                                                                        class="form-control" required>
                                                                    @error('dataStudent.' . $student?->code . '.phone')
                                                                        <label id="error-{{ $student?->code }}-phone"
                                                                            class="validation-error-label text-danger"
                                                                            for="phone-{{ $student?->code }}">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-form-label col-lg-3">Số điện thoại phụ
                                                                    huynh<span class="text-danger">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text"
                                                                        wire:model.live="dataStudent.{{ $student?->code }}.phone_family"
                                                                        class="form-control" required>
                                                                    @error('dataStudent.' . $student?->code .
                                                                        '.phone_family')
                                                                        <label
                                                                            id="error-{{ $student?->code }}-phone_family"
                                                                            class="validation-error-label text-danger"
                                                                            for="phone_family-{{ $student?->code }}">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-form-label col-lg-3">Tên công ty thực
                                                                    tập</label>
                                                                <div class="col-lg-9">
                                                                    <input type="text"
                                                                        wire:model.live="dataStudent.{{ $student?->code }}.internship_company"
                                                                        class="form-control" required>
                                                                    @error('dataStudent.' . $student?->code .
                                                                        '.internship_company')
                                                                        <label
                                                                            id="error-{{ $student?->code }}-internship_company"
                                                                            class="validation-error-label text-danger"
                                                                            for="internship_company-{{ $student?->code }}">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-form-label col-lg-3">Cán bộ hướng dẫn
                                                                    tại công ty thực tập</label>
                                                                <div class="col-lg-9">
                                                                    <input type="text"
                                                                        wire:model.live="dataStudent.{{ $student?->code }}.supervisor_company"
                                                                        class="form-control" required>
                                                                    @error('dataStudent.' . $student?->code .
                                                                        '.supervisor_company')
                                                                        <label
                                                                            id="error-{{ $student?->code }}-supervisor_company"
                                                                            class="validation-error-label text-danger"
                                                                            for="internship_company-{{ $student?->code }}">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-form-label col-lg-3">Email của cán bộ
                                                                    hướng dẫn</label>
                                                                <div class="col-lg-9">
                                                                    <input type="text"
                                                                        wire:model.live="dataStudent.{{ $student?->code }}.supervisor_company_email"
                                                                        class="form-control" required>
                                                                    @error('dataStudent.' . $student?->code .
                                                                        '.supervisor_company_email')
                                                                        <label
                                                                            id="error-{{ $student?->code }}-supervisor_company_email"
                                                                            class="validation-error-label text-danger"
                                                                            for="internship_company-{{ $student?->code }}">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-form-label col-lg-3">Số điện thoại của
                                                                    cán bộ hướng dẫn</label>
                                                                <div class="col-lg-9">
                                                                    <input type="text"
                                                                        wire:model.live="dataStudent.{{ $student?->code }}.supervisor_company_phone"
                                                                        class="form-control" required>
                                                                    @error('dataStudent.' . $student?->code .
                                                                        '.supervisor_company_phone')
                                                                        <label
                                                                            id="error-{{ $student?->code }}-supervisor_company_phone"
                                                                            class="validation-error-label text-danger"
                                                                            for="internship_company-{{ $student?->code }}">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <!-- /maximum number -->
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Thông tin đề tài và giáo viên hướng dẫn</h5>
                            </div>

                            <div class="card-body">
                                <form class="form-validate-jquery" action="#">
                                    <div class="mb-4">
                                        <!-- Maximum number -->
                                        <div class="row mb-3">
                                            <label class="col-form-label col-lg-3">Nguyện vọng đề tài </label>
                                            <div class="col-lg-9">
                                                <input type="text" wire:model.live="topic" class="form-control"
                                                    required>
                                                @error('topic')
                                                    <label id="error-topic" class="validation-error-label text-danger"
                                                        for="topic">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-form-label col-lg-3">Giáo viên đã nhận hướng dẫn
                                            </label>
                                            <div class="col-lg-9">
                                                <input type="text" wire:model.live="supervisor"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Always open -->
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <button wire:loading wire:target="submit" class="btn btn-primary">
                            <i class="ph-circle-notch spinner"></i>
                            Lưu
                        </button>
                        <button wire:click="submit" wire:loading.remove class="btn btn-primary">
                            <i class="ph-floppy-disk"></i>
                            Lưu
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
