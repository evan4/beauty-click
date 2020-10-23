<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'parent_id',
    ];

    /**
     * Get the category that owns the service.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * Get the user that owns the service.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
  
    /**
     * Get the route key for the model.
     *
     * @return string
    */
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
