<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'address',
        'phone',
        'total',
        'note',
        'shipping_id',
        'payment_id',
        'user_id'
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    /**
     * Get the payment type that owns the order.
     */
    public function payment()
    {
        return $this->belongsTo('App\Models\Payment');
    }

    /**
     * Get the shipping type that owns the order.
     */
    public function shipping()
    {
        return $this->belongsTo('App\Models\Shipping');
    }
}
