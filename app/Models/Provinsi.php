<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'master_provinsi';

    public $timestamp = false;

    public function kokab() {
        return $this->hasMany('App\Models\Kokab');
    }
}
