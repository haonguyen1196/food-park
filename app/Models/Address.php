<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delivery_area_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'type',
    ];

    public function deliveryArea()
    {
        return $this->belongsTo(DeliveryArea::class);
    }
}