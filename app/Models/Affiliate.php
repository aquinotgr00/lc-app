<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $fillable = ['user_id', 'balance', 'click', 'link', 'type', 'temp_balance'];

    public function user() {
    	return $this->belongsTo('App\User');
    }

    public function storeCustomers() {
    	return $this->hasMany('App\Models\StoreCustomer', 'aff_id');
    }

    public function getTypeDisplayName() {
        if ($this->type == 1) {
            return 'Biasa';
        } elseif ($this->type == 2) {
            return 'Super';
        }
    }
}
