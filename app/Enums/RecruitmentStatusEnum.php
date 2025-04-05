<?php

namespace App\Enums;

enum RecruitmentStatusEnum: string
{
    case Open = 'open';       
    case Closed = 'closed';  

    /**
     * Get the description of the status.
     */
    public function description(): string
    {
        return match ($this) {
            self::Open => 'Nhận thực tập',
            self::Closed => 'Tạm dừng',
        };
    }
}
