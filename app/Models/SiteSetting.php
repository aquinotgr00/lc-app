<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public static function getValue($name) {
        $_this = new self;
        return $_this->where('name', 'LIKE', $name)->first()->value;
    }
}
