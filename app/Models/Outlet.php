<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'outlet_laundries';

    /**
   * @var array
   */
    protected $fillable = ['name', 'email', 'phone', 'address'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function outletCustomers()
    {
        return $this->hasMany('App\Models\OutletCustomer', 'outlet_laundry_id');
    }

    public function outletSaleDailies()
    {
        return $this->hasMany('App\Models\OutletSaleDaily', 'outlet_laundry_id');
    }
}
