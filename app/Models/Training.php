<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['customer_id', 'price', 'category'];

    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }

    public function categoryDisplayName() {
        if ($this->category == 1) {
            return 'Chemicals';
        } elseif ($this->category == 2) {
            return 'Management';
        }
    }
}
