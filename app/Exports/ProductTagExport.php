<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Tag;
use App\Models\TagProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductTagExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with('tags')->get();
    }
    /**
    * @var Product $product
    */

    public function map($product): array
    {
        $tag = $product->tags->pluck('tag')->toArray();
        $tag = join(",", $tag);
        $date = $product->tags->pluck('pivot')->toArray();
        $date = array_column($date, 'insert_date');
        $date = join(",", $date);
        return [
            $tag,
            $product->name,
            $product->created_at,
            $product->updated_at,
            $date,
        ];
    }
    public function headings(): array
    {
        return ['tag', 'product', 'created_at', 'updated_at', 'insert_date'];
    }
}
