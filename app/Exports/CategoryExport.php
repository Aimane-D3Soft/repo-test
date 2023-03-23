<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::all();
    }

        /**
    * @var Category $category
    */
    public function map($category): array{
        return[
            $category->categories,
            $category->created_at,
            $category->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            'categories',
            'created_at',
            'updated_at',
        ];
    }
}
