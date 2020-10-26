<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'quantity',
        'service_id',
        'order_id'
    ];

    /**
     * Get the service that owns the OrderService.
    */
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    /**
     * Get the order that owns the OrderService.
    */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

}
