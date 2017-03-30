<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerFee extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'partner_id',
        'packet_id',
        'first_payment',
        'second_payment',
        'commitment_fee',
        'first_pay',
        'settled',
        'addition',
        'description'
    ];

    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }

    public function packet() {
    	return $this->belongsTo('App\Models\Packet');
    }
}

