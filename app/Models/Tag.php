<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['tag'];

    function products(){
        return $this->belongsToMany(Product::class, 'tags_products', 'product_id', 'tag_id');
    }
}
