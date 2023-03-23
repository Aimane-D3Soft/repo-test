<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
        return Product::all();
    }
    /**
    * @var Product $product
    */
    public function map($product): array
    {
        return [
            $product->name,
            $product->price,
            $product->description,
            $product->image,
            $product->category->categories,
            $product->created_at,
            $product->updated_at,
        ];
    }
    public function headings(): array
    {
        return [
            'name', 
            'price', 
            'description', 
            'image', 
            'category', 
            'created_at', 
            'updated_at'
        ];
    }
}
