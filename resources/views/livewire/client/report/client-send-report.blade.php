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
                        <span class="d-block text-muted">Nộp báo cáo</span>
                        <h5 class="mb-0 p-2">{{ $campaign?->name }}</h5>
                    </div>

                    <div class="mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Báo cáo tổng kết</h5>
                            </div>

                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="row mb-3">
                                        <label class="col-form-label col-lg-3">
                                            File báo cáo tổng kết <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9">
                                            <input type="file" wire:model="groupReportFile" class="form-control"
                                                accept=".doc,.docx" required>
                                            @error('groupReportFile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button wire:loading wire:target="submit" class="btn btn-primary">
                                    <i class="ph-circle-notch spinner"></i>
                                    Nộp báo cáo
                                </button>
                                <button wire:click="submit" wire:loading.remove class="btn btn-primary">
                                    <i class="ph-floppy-disk"></i>
                                    Nộp báo cáo
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
