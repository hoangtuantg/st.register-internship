<div class="row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header bold">
                <i class="ph-info"></i>
                Thông tin chung
            </div>
            <div class="card-body">
                <!-- Tên bản mẫu kế hoạch -->
                <div class="row">
                    <div class="col">
                        <label for="name" class="col-form-label">
                            Tên bản mẫu kế hoạch <span class="required">*</span>
                        </label>
                        <input wire:model.live="name" type="text" id="name" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- /Tên bản mẫu kế hoạch -->

                <!-- Mô tả-->
                <div class="row">
                    <div class="col">
                        <label for="description" class="col-form-label">
                            Mô tả
                        </label>
                        <textarea wire:model.live="description" type="number" class="form-control"></textarea>
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
                <button class="btn btn-primary flex-fill" wire:click="submit"><i class="ph-floppy-disk"></i> Lưu</button>
                <a href="{{route('admin.plans.index')}}" type="button" class="btn btn-warning flex-fill"><i class="ph-arrow-counter-clockwise"></i> Trở lại</a>
            </div>
        </div>
    </div>
</div>
