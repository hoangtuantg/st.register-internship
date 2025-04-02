<div class="row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header bold">
                <i class="ph-info"></i>
                Thông tin chung
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label for="name" class="col-form-label">
                            Tên <span class="required">*</span>
                        </label>
                        <input wire:model.live="name" type="text" id="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bold">
                <i class="ph-clock"></i>
                Thời gian
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="title" class="col-form-label">
                            Ngày bắt đầu <span class="required">*</span>
                        </label>
                        <div class="input-group">
                           <span class="input-group-text">
												<i class="ph-calendar"></i>
											</span>
                            <input wire:model="start" type="text" id="startDate" value="{{ $this->start }}"
                                   class="form-control datepicker-basic datepicker-input">
                        </div>
                        @error('startDate')
                        <label id="error-username" class="validation-error-label text-danger"
                               for="username">{{ $message }}</label>
                        @enderror

                    </div>
                    <div class="col-12 col-md-6 ">
                        <label for="title" class="col-form-label">
                            Ngày kết kúc <span class="required">*</span>
                        </label>
                        <div class="input-group">
                           <span class="input-group-text">
												<i class="ph-calendar"></i>
											</span>
                            <input wire:model="end" type="text" id="endDate" value="{{ $this->end }}"
                                   class="form-control datepicker-basic datepicker-input ">
                        </div>
                        @error('endDate')
                        <label id="error-username" class="validation-error-label text-danger"
                               for="username">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bold">
                <i class="ph-user"></i>
                Thành viên nhóm
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label for="max_student_group" class="col-form-label">
                            Số lượng thành viên tối đa <span class="required">*</span>
                        </label>
                        <input wire:model.live="max_student_group" type="number" id="max_student_group" class="form-control @error('max_student_group') is-invalid @enderror">
                        @error('max_student_group')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card container-plan-template" wire:ignore>
            <div class="card-header bold">
                <i class="ph-calendar"></i>
                Mẫu kế hoạch
            </div>
            <div class="card-body">
                <select id="planTemplate" class="form-select">
                    <option value=""></option>
                    @foreach($planTemplates as $planTemplate)
                        <option value="{{ $planTemplate->id }}">{{ $planTemplate->name }}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}

    </div>
    <div class="col-md-3 col-12">
        <div class="card">
            <div class="card-header bold">
                <i class="ph-gear-six"></i>
                Hành động
            </div>
            <div class="card-body d-flex justify-content-center gap-3">
                <button class="btn btn-primary flex-fill" wire:click="submit"><i class="ph-floppy-disk"></i> Lưu</button>
                <a href="{{ route('admin.campaigns.index') }}" type="button" class="btn btn-warning flex-fill"><i class="ph-arrow-counter-clockwise"></i> Trở lại</a>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $(document).ready(function () {
        const dpBasicElementStartDate = document.querySelector('#startDate');
        if (dpBasicElementStartDate) {
            new Datepicker(dpBasicElementStartDate, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                format: 'dd/mm/yyyy',
                weekStart: 1,
                language: 'vi',
            });
            dpBasicElementStartDate.addEventListener('changeDate', function (event) {
                const selectedDate = new Date(event.detail.date);
                const formattedDate = formatDateToString(selectedDate);
                Livewire.dispatch('update-start-date', { value: formattedDate })
            });
        }


        const dpBasicElementEndDate = document.querySelector('#endDate');
        if (dpBasicElementStartDate) {
            new Datepicker(dpBasicElementEndDate, {
                container: '.content-inner',
                buttonClass: 'btn',
                prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                format: 'dd/mm/yyyy',
                weekStart: 1,
                language: 'vi',
            });
            dpBasicElementEndDate.addEventListener('changeDate', function (event) {
                const selectedDate = new Date(event.detail.date);
                const formattedDate = formatDateToString(selectedDate);
                Livewire.dispatch('update-end-date', { value: formattedDate })
            });
        }

        $('#planTemplate').select2({
            placeholder: 'Chọn mẫu kế hoạch',
            allowClear: true,
            dropdownParent: $('.container-plan-template')
        }).change(function() {
            alert(1);
            Livewire.dispatch('selectedPlan', [$(this).val()]);
        });
    });

</script>
@endscript
