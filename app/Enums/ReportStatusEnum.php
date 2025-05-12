<?php

namespace App\Enums;

enum ReportStatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function description(): string
    {
        return match ($this) {
            self::PENDING => 'Báo cáo chờ duyệt',
            self::APPROVED => 'Đã duyệt báo cáo',
            self::REJECTED => 'Báo cáo chưa đạt',
        };
    }
}
