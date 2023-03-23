<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $rows)
    {
        // dd(Category::where('id', $rows['category_id'])->first()->id);
        // $rows['category_id'] = Category::where("id", $rows['category_id'])->first()->id;
        // dd($rows);
        return new Product([
            'id' => $rows['id'],
            'name' => $rows['name'],
            'price' => $rows['price'],
            'description' => $rows['description'],
            'image' => $rows['image'],
            'category_id' => $rows['category_id'],
            'created_at' => $rows['created_at'],
            'updated_at' => $rows['updated_at'],
        ]);
    }
}
