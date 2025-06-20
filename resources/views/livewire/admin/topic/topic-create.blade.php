<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bold">
                <i class="ph-info"></i>
                Thông tin đề tài
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">
                        Tên đề tài: <span class="text-danger">*</span>
                    </label>
                    <div>
                        <input wire:model.live="title" type="text" class="form-control">
                        @error('title')
                            <label class="text-danger mt-1">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label mt-1">
                        Mô tả:
                    </label>
                    <textarea class="form-control" wire:model.live="description"></textarea>
                    @error('description')
                        <label class="text-danger mt-1">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label mt-1">
                        Đợt đăng ký: <span class="text-danger">*</span>
                    </label>
                    <select id="campaign" class="form-control" wire:model.live="campaign_id">
                        <option value="">-- Chọn đợt đăng ký --</option>
                        @foreach ($campaigns as $campaign)
                            <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                        @endforeach
                    </select>
                    @error('campaign_id')
                        <label class="text-danger mt-1">{{ $message }}</label>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bold">
                <i class="ph-gear-six"></i>
                Hành động
            </div>
            <div class="card-body d-flex align-items-center gap-1">
                <button wire:click="store" class="btn btn-primary" type="submit"><i class="ph-floppy-disk"></i>Tạo
                    mới</button>
                <a href="{{ route('admin.topics.index') }}" type="button" class="btn btn-warning"><i
                        class="ph-arrow-counter-clockwise"></i> Trở lại</a>
            </div>
        </div>
    </div>

</div>
