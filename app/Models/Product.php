<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'category_id',
        'name',
        'price',
        'description',
        'image',
    ];

    function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'tags_products')->withPivot('insert_date');
    }
    function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
