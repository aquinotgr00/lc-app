<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $fillable = ['purchase_order_id', 'product_id', 'quantity', 'total', 'supplier_id', 'description'];

    public function purchaseOrder()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}
