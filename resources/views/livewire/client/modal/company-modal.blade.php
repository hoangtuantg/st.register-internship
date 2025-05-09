<div class="modal fade" id="companiesModal" tabindex="-1" aria-labelledby="companiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="companiesModalLabel">Danh sách công ty thực
                    tập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionCompanies">
                    @forelse ($companies as $company)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $company->id }}">
                                <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $company->id }}" aria-expanded="false"
                                    aria-controls="collapse{{ $company->id }}">
                                    {{ $company->name }}
                                </button>
                            </h2>
                            <div id="collapse{{ $company->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $company->id }}" data-bs-parent="#accordionCompanies">
                                <div class="accordion-body">
                                    <div class="row mb-1 align-items-center">
                                        <div class="col-3 fw-bold text-muted">Email:</div>
                                        <div class="col">{{ $company->email }}</div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <div class="col-3 fw-bold text-muted">Số điện
                                            thoại:</div>
                                        <div class="col">{{ $company->phone }}</div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <div class="col-3 fw-bold text-muted">Địa chỉ:
                                        </div>
                                        <div class="col">{{ $company->address }}</div>
                                    </div>
                                    <div class="row mb-1 align-items-center">
                                        <div class="col-3 fw-bold text-muted">Mô tả:</div>
                                        <div class="col">{{ $company->description }}
                                        </div>
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
