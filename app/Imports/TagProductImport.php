<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Tag;
use App\Models\TagProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class TagProductImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = Product::firstOrCreate(['name' => $row['product']]);
        $row['product'] = $product->id;
        // Product::where('name', $row['product'])->first()->id;
        $tag = explode(",", $row['tag']);
        // $tag = array_chunk($tag,1);
        // $tag = implode("", $tag);
        // dd($tag);
        foreach($tag as $item){
            Tag::firstOrCreate(['tag' => $item]);
        }
        // dd($item);
        $date = explode(",", $row['insert_date']);
        foreach($date as $insert_date)
        $tag_id = Tag::whereIn('tag', $tag)->pluck('id')->toArray();
        // dd($tag_id);
        // $product = Product::find($row['product']);
        $product->tags()->syncWithPivotValues($tag_id, ['insert_date' => $insert_date]);
        // dd($row['tag']);
        // dd($row['tag']);
        // $row['tag'] = Tag::where('tag', $tag)->first()->id;
        // dd($tag_name);
        // dd($tag_name);
        // Tag::where('tag', $tag)->first()->id;
        // $date = implode("\n", $date);
        // $date = str_replace(",", "\n", $row['insert_date']);
        // dd($row['tag']);
        // dd($date);
        // foreach($date as $item){
        //     return new TagProduct([
        //         'tag_id' => $row['tag'],
        //         'product_id' => $row['product'],
        //         'created_at' => $row['created_at'],
        //         'updated_at' => $row['updated_at'],
        //         'insert_date' => $item,
        //     ]);
        // }
    }
    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'id';
    }
}
