<?php

namespace App\Livewire\Admin\Company;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Company;
use Illuminate\Support\Facades\Gate;

class CompanyUpdate extends Component
{
    #[Validate(as: 'Tên công ty')]
    public $name;

    #[Validate(as: 'Địa chỉ')]
    public $address;

    #[Validate(as: 'Số điện thoại')]
    public $phone;

    #[Validate(as: 'Mô tả')]
    public $description;

    #[Validate(as: 'Email')]

    public $email;
    
    //public $id;
    public int|string $companyId;

    public function render()
    {
        return view('livewire.admin.company.company-update');
    }

    public function mount($id):void 
    {
        $this->companyId = $id;
        $company = Company::find($this->companyId);
        // $company = Company::query()->find($this->id);
        // dd($company);
        $this->name = $company->name;
        $this->address = $company->address;
        $this->phone = $company->phone;
        $this->email = $company->email;
        $this->description = $company->description;
    }

    public function update()
    {
        $company = Company::findOrFail($this->companyId);
        Gate::authorize('update', $company);

        $this->validate();
        $company->update([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'description' => $this->description,
        ]);
        session()->flash('success', 'Cập nhật công ty thành công.');

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
