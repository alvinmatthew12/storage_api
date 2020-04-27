<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = [
        'product_name', 'product_description', 'product_qty'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
