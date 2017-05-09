<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreOrder extends Model
{
    protected $fillable = ['store_customer_id', 'address', 'phone', 'total', 'status'];

    public function storeCustomer() {
    	return $this->belongsTo('App\Models\StoreCustomer');
    }

    public function storeOrderDetails() {
    	return $this->hasMany('App\Models\StoreOrderDetail', 'order_id');
    }

    public function getStatusDisplayName() {
        if ( $this->status == 1 ) {
            return 'Baru';
        } elseif ( $this->status == 2 ) {
            return 'Proses';
        } elseif ( $this->status == 3 ) {
            return 'Selesai';
        }
    }
}
