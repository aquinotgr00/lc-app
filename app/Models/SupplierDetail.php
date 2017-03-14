<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierDetail extends Model
{
    protected $fillable = ['supplier_id', 'material_id', 'price'];

    public $timestamps = false;

    public function supplier() {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function material() {
        return $this->belongsTo('App\Models\Material');
    }
}
