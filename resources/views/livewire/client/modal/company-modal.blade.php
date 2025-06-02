<div class="modal fade" id="companiesModal" tabindex="-1" aria-labelledby="companiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content overflow-hidden">
            <div class="modal-header">
                <h5 class="modal-title" id="companiesModalLabel">Danh sách công ty thực tập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>

            <div class="modal-body">
                <div class="accordion" id="accordionCompanies">
                    @forelse ($companies as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false"
                                    aria-controls="collapse{{ $loop->index }}">
                                    {{ $item->company->name }}
                                </button>
                            </h2>

                            <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordionCompanies">
                                <div class="accordion-body">
                                    <div class="row mb-1 align-items-center">
                                        <div class="col-3 fw-bold text-muted">Email:</div>
                                        <div class="col">{{ $item->company->email }}</div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <div class="col-3 fw-bold text-muted">Số điện thoại:</div>
                                        <div class="col">{{ $item->company->phone }}</div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <div class="col-3 fw-bold text-muted">Địa chỉ:</div>
                                        <div class="col">{{ $item->company->address }}</div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <div class="col-3 fw-bold text-muted">Số lượng tuyển:</div>
                                        <div class="col">{{ $item->amount }}</div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-3 fw-bold text-muted">Mô tả:</div>
                                        <div class="col">{!! $item->job_description !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">
                            <img src="{{ asset('assets/images/empty.png') }}" class="mb-3" style="max-width: 300px;">
                            <div class="fw-bold text-muted">Hiện chưa có công ty nào tuyển thực tập sinh</div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
