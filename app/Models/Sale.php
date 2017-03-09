<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'address',
        'phone',
        'order_date',
        'transfer_date',
        'ship_date',
        'estimation_date',
        'transfer_via',
        'discount',
        'nominal',
        'shipping_fee',
        'packing_fee',
        'expedition',
        'resi',
        'description',
        'status',
        'note'
    ];

    /**
     * @var timestamps
     */
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function saleDetails()
    {
        return $this->hasMany('App\Models\SaleDetail');
    }

    public function getStatusDisplayName() {
        if ( $this->status == 1 ) {
            return "Pending";
        } elseif ( $this->status == 2 ) {
            return "Release";
        } elseif ( $this->status == 3 ) {
            return "Process";
        } elseif ( $this->status == 4 ) {
            return "Processing dengan masalah";
        } elseif ( $this->status == 5 ) {
            return "Masalah";
        } elseif ( $this->status == 6 ) {
            return "Ready Hold";
        } elseif ( $this->status == 7 ) {
            return "Ready Ship";
        } elseif ( $this->status == 8 ) {
            return "Ship";
        } elseif ( $this->status == 9 ) {
            return "Finish";
        }
    }

    public function getStatusDisplayColour() {
        if ($this->status == 1) {
            return "info";
        } elseif ($this->status == 2) {
            return "danger";
        } elseif ($this->status == 3) {
            return "info";
        } elseif ($this->status == 4) {
            return "warning";
        } elseif ($this->status == 5) {
            return "success";
        } elseif ($this->status == 6) {
            return "warning";
        }
    }
}
