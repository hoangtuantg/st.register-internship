<div class="row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header bold">
                <i class="ph-info"></i>
                Thông tin công ty thực tập
            </div>
            <div class="card-body">
                <div class="form-group mt-2">
                    <label class="form-label">
                        Tên công ty: <span class="text-danger">*</span>
                    </label>
                    <div>
                        <input wire:model.live="name" type="text"
                            class="form-control  @error('name') is-invalid @enderror">
                        @error('name')
                            <label class="text-danger mt-1">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label class="form-label">
                        Email: <span class="text-danger">*</span>
                    </label>
                    <div>
                        <input wire:model.live="email" type="text"
                            class="form-control  @error('email') is-invalid @enderror">
                        @error('email')
                            <label class="text-danger mt-1">{{ $message }}</label>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-2">
                    <label class="form-label">
                        Địa chỉ: <span class="text-danger">*</span>
                    </label>
                    <div>
                        <input wire:model.live="address" type="text"
                            class="form-control  @error('address') is-invalid @enderror">
                        @error('address')
                            <label class="text-danger mt-1">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label class="form-label">
                        Số điện thoại: <span class="text-danger">*</span>
                    </label>
                    <div>
                        <input wire:model.live="phone" type="text"
                            class="form-control  @error('phone') is-invalid @enderror">
                        @error('phone')
                            <label class="text-danger mt-1">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label class="form-label">
                        Mô tả: <span class="text-danger">*</span>
                    </label>
                    <div>
                        <textarea wire:model.live="description" rows="5" class="form-control @error('description') is-invalid @enderror"></textarea>
                        @error('description')
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
            <div class="card-body d-flex align-items-center gap-1">
                <button class="btn btn-primary" wire:click="update"><i class="ph-floppy-disk"></i> Lưu</button>
                <a href="{{ route('admin.companies.index') }}" type="button" class="btn btn-warning"><i
                        class="ph-arrow-counter-clockwise"></i> Trở lại</a>
            </div>
        </div>
    </div>
</div>
