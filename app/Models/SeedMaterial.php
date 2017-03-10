<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeedMaterial extends Model
{
    protected $fillable = ['material_id', 'prime_plus', 'prime_standart', 'superior_a', 'superior_b'];

    public function material() {
        return $this->belongsTo('App\Models\Material');
    }

    public function purchaseOrderDetails() {
        return $this->hasMany('App\Models\PurchaseOrderDetail');
    }
}
