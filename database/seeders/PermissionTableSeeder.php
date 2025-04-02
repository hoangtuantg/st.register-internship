<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = config('permissions', []);
        foreach ($permissions as $permission) {
            $this->checkIssetBeforeCreate($permission);
        }
    }
    public function checkIssetBeforeCreate($data): void
    {
        $permission = Permission::where('code', $data['code'])->first();
        if (empty($permission)) {
            Permission::create($data);
        } else {
            $permission->update($data);
        }
    }
}
