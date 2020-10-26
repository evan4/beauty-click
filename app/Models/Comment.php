<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'order_id',
        'user_id'
    ];

    /**
     * Get the order that owns the comment.
    */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * Get the user that owns the comment.
    */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
