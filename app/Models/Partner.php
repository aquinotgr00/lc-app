<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'address', 'type', 'active', 'active_date'
    ];

    public function partnerFee() {
        return $this->hasOne('App\Models\PartnerFee');
    }
}

