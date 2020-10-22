<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'quantity'
    ];

    /**
     * Get the service that owns the orderProduct.
    */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the order that owns the orderProduct.
    */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
