<div class="row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header bold">
                <i class="ph-info"></i>
                Thông tin chung
            </div>
            <div class="card-body">
                <p class="text-muted mb-2">Bản mẫu kế hoạch: <span class="text-primary"> {{ $planTemplateName }}</span></p>

                <!-- Thời gian -->
                <div class="row d-flex justify-content-between mb-2">
                    <div class="col-sm-5">
                        <label class="form-label">Ngày bắt đầu:<span class="required">*</span></label>
                        <input wire:model="start" id="startDate" type="text"
                               class="form-control datepicker-basic datepicker-input" value="{{ $this->start }}">
                    </div>

                    <div class="col-sm-5">
                        <label class="form-label">Ngày kết thúc:<span class="required">*</span></label>
                        <input wire:model="end" id="endDate" type="text"
                               class="form-control datepicker-basic datepicker-input" value="{{ $this->end }}">
                    </div>
                </div>
                <!-- /Thời gian -->

                <!-- Mô tả-->
                <div class="row">
                    <div class="col">
                        <label class="form-label">Nội dung kế hoạch <span class="required">*</span> </label>
                        <div wire:ignore>
                            <textarea wire:model.live="content"
                                      id="content"
                                      class="form-control">
                                {!! $content !!}
                            </textarea>
                        </div>
                        @error('content')
                        <label class="text-danger mt-1">{{ $message }}</label>
                        @enderror
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="card">
            <div class="card-header bold">
                <i class="ph-gear-six"></i>
                Hành động
            </div>
            <div class="card-body d-flex justify-content-center gap-3">
                <button class="btn btn-primary flex-fill" wire:click="submit"><i class="ph-floppy-disk"></i> Chỉnh sửa</button>
                <a href="{{ route('admin.plans.show', $planTemplateId) }}" type="button" class="btn btn-warning flex-fill"><i class="ph-arrow-counter-clockwise"></i> Trở lại</a>
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
    });
</script>
@endscript

@section('script_custom')
    <script>
        const style = document.createElement('style');

        document.head.appendChild(style);

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#content'), {
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'link',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'undo',
                            'redo'
                        ]
                    }
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                    });

                    Livewire.on('contentUpdated', content => {
                        editor.setData(content);
                    });

                    window.editor = editor;
                })
                .catch(error => {
                    console.error('CKEditor initialization failed:', error);
                });
        });
    </script>
@endsection

