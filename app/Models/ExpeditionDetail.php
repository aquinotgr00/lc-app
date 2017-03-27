<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpeditionDetail extends Model
{
    protected $fillable = ['expedition_id', 'master_kokab_id', 'price'];

    public $timestamps = false;

    public function expedition() {
        return $this->belongsTo('App\Models\Expedition');
    }

    public function kokab() {
        return $this->belongsTo('App\Models\Kokab', 'master_kokab_id');
    }
}
