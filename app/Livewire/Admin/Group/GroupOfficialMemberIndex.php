<?php

namespace App\Livewire\Admin\Group;

use Livewire\Component;
use App\Models\GroupOfficial;

class GroupOfficialMemberIndex extends Component
{
    public GroupOfficial $group;

    public function render()
    {
        return view('livewire.admin.group.group-official-member-index');
    }

    public function mount(GroupOfficial $group)
    {
        $this->group = $group;
    }
}
