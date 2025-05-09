<?php

namespace App\Livewire\Admin\Group;

use Livewire\Component;
use App\Common\Constants;
use App\Models\Group;

class GroupMemberIndex extends Component
{
    public Group $group;

    public function render()
    {
        return view('livewire.admin.group.group-member-index');
    }

    public function mount(Group $group)
    {
        $this->group = $group;
    }
}
