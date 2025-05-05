@php
    use App\Enums\StepRegisterEnum;
@endphp

<div class="content login-wrapper" style="background: white;">
    @if ($step == StepRegisterEnum::StepOne)
        <div>
            <div class="mb-1 text-center">
                <div class="gap-1 mt-2 mb-4 d-inline-flex align-items-center justify-content-center">
                    <img src="{{ asset('assets/images/FITA.png') }}" class="h-64px" alt="">
                    <img src="{{ asset('assets/images/logoST.jpg') }}" class="h-64px" alt="">
                </div>
            </div>
            <div class="text-center">
                <h5 class="fw-bold text-primary">{{ $campaign->name }}</h5>
                <div class="alert alert-warning mt-4 mx-auto w-75" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Lưu ý:</strong> Sinh viên thực hiện đăng ký sẽ được hệ thống mặc định là
                    <strong>Trưởng nhóm</strong>.
                </div>
                <div class="align-items-center mt-4">
                    <button wire:loading wire:target="nextStepTwo" type="button" class="btn btn-primary">
                        Đăng ký &nbsp;
                        <i class="ph-circle-notch spinner"></i>
                    </button>
                    <button wire:loading.remove wire:click="nextStepTwo()" type="button" class="btn btn-primary">
                        Đăng ký &nbsp;
                        <i class="ph-arrow-circle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($step == StepRegisterEnum::StepTwo)
        <livewire:client.internship.internship-register-member 
            :code="$code" 
            :campaignId="$campaignId"
            :studentChecked="$studentChecked" />
    @endif

    @if ($step == StepRegisterEnum::StepThree)
        <livewire:client.internship.internship-register-info 
            :code="$code" 
            :campaignId="$campaignId"
            :studentChecked="$studentChecked" />
    @endif
</div>
