<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Product extends Model
{
    use HasFactory;

    function categories (): Relation
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    function productImages (): Relation
    {
        return $this->hasMany(ProductGallery::class);
    }

    function productSizes (): Relation
    {
        return $this->hasMany(ProductSize::class);
    }

    function productOptions (): Relation
    {
        return $this->hasMany(ProductOption::class);
    }
}
