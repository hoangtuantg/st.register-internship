<?php

namespace App\Common;

use Carbon\Exceptions\InvalidFormatException;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Carbon;

class Helpers
{
    public static function validateBirth($value)
    {
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        } else {
            $possibleFormats = [
                'Y/m/d',
                'Y-m-d',
                'Y-n-j',
                'Y/n/j',
                'Y-m-j',
                'Y/m/j',
                'Y-n-d',
                'Y/n/d',
            ];
            foreach ($possibleFormats as $format) {
                if (self::isValidDateFormat($value, $format)) {
                    return Carbon::createFromFormat($format, $value)->format('Y-m-d');
                }
            }
        }

        return $value;
    }

    public static function isValidDateFormat($dateString, $format): bool
    {
        try {
            $date = Carbon::createFromFormat($format, $dateString);

            return $date && $date->format($format) === $dateString;
        } catch (InvalidFormatException $e) {
            return false;
        }
    }

    public static function splitName($fullName): array
    {
        // Remove any extra spaces
        $fullName = trim($fullName);

        // Split the full name into parts
        $parts = explode(" ", $fullName);

        // Get the last part as the first name
        $firstName = array_pop($parts);

        // The remaining parts are the last name + middle name
        $lastName = implode(" ", $parts);

        return [
            'lastName' => $lastName,
            'firstName' => $firstName,
        ];
    }
}
