<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['categories'];

    function products(){
        return $this->hasMany(Product::class, 'id');
    }

    function tests(){
        return $this->hasMany(Product::class, 'id');
    }
}
