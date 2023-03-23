<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Test;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class TestImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $rows)
    {
        Category::firstOrCreate(['categories' => $rows['category']]);
        $rows['category'] = Category::where('categories', $rows['category'])->first()->id;
        // dd($rows['name']);
        return new Product([
            'name' => $rows['name'],
            'price' => $rows['price'],
            'description' => $rows['description'],
            'image' => $rows['image'],
            'category_id' => $rows['category'],
            'created_at' => $rows['created_at'],
            'updated_at' => $rows['updated_at'],
        ]);
    }
    
    /**
     * @return string|array
     */

    public function uniqueBy()
    {
        return 'name';
    }
}
