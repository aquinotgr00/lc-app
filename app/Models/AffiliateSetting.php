<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateSetting extends Model
{
    protected $fillable = ['name', 'display_name', 'type', 'value', 'value_int'];
    
    public $timestamps  = false;
}
