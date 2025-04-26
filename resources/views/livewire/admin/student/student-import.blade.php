<div id="model-import" wire:ignore.self class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Sinh viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="name" class="col-form-label">
                            File import <span class="required">*</span>
                        </label>
                        <input wire:model.live="file" type="file" id="name" class="form-control">
                        @error('name')
                            <label id="error-name" class="validation-error-label text-danger"
                                for="name">{{ $message }}</label>
                        @enderror
                        <a class="cursor-pointer text-primary d-inline-block mt-2" href="/templates/student.xlsx"
                            download>Tải file mẫu</a>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" wire:click="closeImportModal()">Đóng</button>
                @if ($file)
                    <button wire:loading wire:target="submit" type="button" class="btn btn-primary"> <i
                            class="ph-circle-notch spinner"></i>Lưu</button>
                    <button wire:loading.remove type="button" class="btn btn-primary"
                        wire:click="submit()">Lưu</button>
                @endif
            </div>
        </div>
    </div>
</div>
