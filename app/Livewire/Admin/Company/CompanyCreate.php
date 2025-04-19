<?php

namespace App\Livewire\Admin\Company;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Company;
use App\Services\SsoService;
use Illuminate\Support\Facades\Gate;

class CompanyCreate extends Component
{
    #[Validate(as: 'tên công ty')]
    public $name;

    #[Validate(as: 'địa chỉ')]
    public $address;

    #[Validate(as: 'số điện thoại')]
    public $phone;

    #[Validate(as: 'mô tả')]
    public $description;

    #[Validate(as: 'email')]
    public $email;

    public function render()
    {
        return view('livewire.admin.company.company-create');
    }

    public function store()
    {
        Gate::authorize('create', Company::class);
        $this->validate();
        $facultyId = app(SsoService::class)->getFacultyId();
        Company::create([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'description' => $this->description,
            'faculty_id' => $facultyId,
        ]);

        session()->flash('success', 'Thêm mới công ty thành công.');

        return redirect()->route('admin.companies.index');
    }

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match("/^[0-9]{10}$/", $value)) {
                        return $fail('Số điện thoại chưa đúng định dạng ');
                    }
                }
            ],
            'description' => 'required|string',
            'email' => 'required|email',
        ];
    }   
}
