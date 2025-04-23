<?php

namespace App\Enums;

enum TeacherStatusEnum: string
{
    
    case Accept = 'accept';
    case Refuse = 'refuse';

    /**
     * Lấy mô tả cho trạng thái
     */
    public function description(): string
    {
        return match ($this) {
            self::Accept => 'Hướng dẫn',
            self::Refuse => 'Tạm dừng',
        };
    }

}
