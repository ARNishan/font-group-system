<?php

namespace App\Validators;

class FontGroupValidator
{
    public static function validate($data): bool
    {
        if (empty($data['groupName']) || count($data['fonts']) < 2) {
            return false;
        }
        return true;
    }
}
