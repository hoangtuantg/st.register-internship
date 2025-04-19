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
                        <label class="form-label">Số lượng tuyển dụng </label>
                        <input wire:model.live="amount" type="number" class="form-control @error('amount') is-invalid @enderror">
                        @error('amount')
                            <label class="text-danger mt-1">{{ $message }}</label>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label class="form-label mt-2">Nội dung kế hoạch <span class="required">*</span> </label>
                        <div wire:ignore>
                            <textarea wire:model.live="jobDescription" id="jobDescription" class="form-control">
                                {!! $jobDescription !!}
                            </textarea>
                        </div>
                        @error('jobDescription')
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
                <button class="btn btn-primary flex-fill" wire:click="update"><i class="ph-floppy-disk"></i> Chỉnh
                    sửa</button>
                <a href="{{ route('admin.company-campaign.show', ['campaign' => $campaignId]) }}" type="button"
                    class="btn btn-warning flex-fill">
                    <i class="ph-arrow-counter-clockwise"></i> Trở lại
                </a>

            </div>
        </div>
    </div>
</div>

@section('script_custom')
    <script>
        const style = document.createElement('style');

        document.head.appendChild(style);

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#jobDescription'), {
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
                        @this.set('jobDescription', editor.getData());
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
