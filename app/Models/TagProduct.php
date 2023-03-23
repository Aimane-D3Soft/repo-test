<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TagProduct extends Pivot
{
    use HasFactory;

    protected $table = "tags_products";
    public $timestamps = false;
    protected $fillable = [
        'tag_id',
        'product_id',
        'insert_date',
    ];

}
