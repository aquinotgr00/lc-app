<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seed extends Model
{
    protected $fillable = ['name', 'price_1', 'price_2', 'price_3'];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
