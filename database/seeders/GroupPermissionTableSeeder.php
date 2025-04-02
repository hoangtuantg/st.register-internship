<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GroupPermission;

class GroupPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = config('group_permissions', []);
        foreach ($groups as $group) {
            $this->checkIssetBeforeCreate($group);
        }
    }
    private function checkIssetBeforeCreate($data): void
    {
        $groupPermission = GroupPermission::where('code', $data['code'])->first();
        if (empty($groupPermission)) {
            GroupPermission::create($data);
        } else {
            $groupPermission->update($data);
        }
    }
}
