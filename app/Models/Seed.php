<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seed extends Model
{
    protected $fillable = ['product_id', 'price_1', 'price_2', 'price_3', 'stock'];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }

    public function formula() {
        return $this->belongsTo('App\Models\Formula');
    }

    public function formulaDetails()
    {
        return $this->hasMany('App\Models\FormulaDetail');
    }
}
