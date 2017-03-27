<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kokab extends Model
{
    protected $table = 'master_kokab';

    public $timestamp = false;

    public function provinsi() {
        return $this->belongsTo('App\Models\Provinsi');
    }

    public function customers() {
        return $this->hasMany('App\Models\Customer');
    }

    public function expeditionDetails() {
        return $this->hasMany('App\Models\ExpeditionDetail');
    }
}
