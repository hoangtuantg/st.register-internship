<div class="content d-flex justify-content-center align-items-center min-vh-80 bg-light">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 1000px; border-radius: 16px;">
        <div class="row g-4 align-items-center">
            <!-- Phần hình ảnh -->
            <div class="col-lg-6 text-center order-2 order-lg-1">
                <div class="mb-4">
                    <img src="{{ asset($campaigns->isEmpty() ? 'assets/images/empty.png' : 'assets/images/login.png') }}"
                        alt="status" class="img-fluid" style="max-height: 300px;">
                </div>
            </div>

            <!-- Phần logo + tiêu đề + danh sách -->
            <div class="col-lg-6 order-1 order-lg-2">
                <div class="text-center mb-4">
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <img src="{{ asset('assets/images/FITA.png') }}" alt="FITA Logo" style="height: 64px;">
                        <img src="{{ asset('assets/images/logoST.jpg') }}" alt="ST Logo" style="height: 64px;">
                    </div>
                    <h4 class="mt-3 mb-0 fw-bold">Đăng ký nguyện vọng TTNN/KLTN</h4>
                </div>

                <div class="px-3">
                    @if ($campaigns->isEmpty())
                        <div class="alert alert-info text-center" style="border-radius: 12px;">
                            Quay lại vào lần sau nhé! <br>
                            Bạn đang không nằm trong danh sách đủ điều kiện thực tập.
                        </div>
                    @else
                        <div class="list-group">
                            @foreach ($campaigns as $campaign)
                                <div class="list-group-item list-group-item-action shadow-sm mb-2" style="border-radius: 12px;">
                                    <div class="card-body p-2">
                                        <div class="card-item">
                                            <i class="ph-arrow-circle-right"></i> {{ $campaign->name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
