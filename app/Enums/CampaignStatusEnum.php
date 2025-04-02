<?php

namespace App\Enums;

enum CampaignStatusEnum: string
{
    case Active = 'active';

    case Inactive = 'inactive';

    /**
     * Get the description of the status.
     */
    public function description(): string
    {
        return match ($this) {
            self::Active => 'Hoạt động',
            self::Inactive => 'Ngưng hoạt động',
        };
    }
}
