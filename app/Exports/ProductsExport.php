<?php

namespace App\Exports;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductsExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    WithEvents
{
    public $attrs;

    public function headings(): array
    {
        return ['product id', 'product description'];
    }

    public function collection()
    {
        return Product::all();
    }

    public function map($product): array
    {
        // $this->attrs = $this->filters($category);

        $row = [$product->id, $product->description];

        // if ($this->attrs !== false) {
        //     foreach ($this->attrs as $attr) {
        //         foreach ($attr->items as $key => $item) {
        //             $row = [
        //                 $category->catalog->id,
        //                 $category->catalog->name,
        //                 $category->id,
        //                 $category->name,
        //                 $attr->id,
        //                 $attr->name,
        //                 $item->id,
        //                 $item->name,
        //             ];

        //             array_push($rows, $row);
        //         }
        //     }
        // } else {
        //     $rows = [
        //         $category->catalog->id,
        //         $category->catalog->name,
        //         $category->id,
        //         $category->name,
        //         '',
        //         '',
        //         '',
        //         '',
        //     ];
        // }

        return $row;
    }

    // Берет свойста из категории и виды свойств из товаров
    // public function filters($category)
    // {
    //     if (Str::of($category->attributes)->trim()->isEmpty()) {
    //         return collect(); // return empty collection
    //     }

    //     $attributesId = Str::replace('.', ',', $category->attributes);
    //     $ids = explode(',', $attributesId);

    //     $items = $category->productsAttributes()
    //         ->get()
    //         ->unique()
    //         ->pluck('id');

    //     return Attribute::whereIn('id', $ids)
    //         ->with(['items' => function ($query) use ($items) {
    //             $query->whereIn('id', $items);
    //         },
    //         ])
    //         ->orderBy('name', 'asc')
    //         ->get();
    // }

    // // Одежда для Ольги

    // public function collection()
    // {
    //     return Product::whereHas('categories', function ($query) {
    //         $query->whereIn('product_category.category_id', [33, 44]);
    //     })
    //     //->has('media')
    //         ->with('variations', 'attributes')
    //     // ->with('categories')
    //     // ->with('categories.catalog')
    //     // ->with('media')

    //         ->get();
    // }

    // public function headings(): array
    // {
    //     return [
    //         'id',
    //         'Название',
    //     ];
    // }

    // public function map($product): array
    // {

    //     if (!$product->attributes()->whereIn('attribute_id', [46, 47, 48, 49, 34, 4, 52, 53, 56, 55])) {

    //         //dd($product->attributes()->whereNotIn('attribute_id', [46, 47, 48, 49, 34, 4, 52, 53, 56, 55]));
    //         return [
    //             $product->id,
    //             $product->name,
    //         ];
    //     }
    //     return [];
    // }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:C1';
                $event->sheet
                    ->getDelegate()
                    ->getStyle($cellRange)
                    ->getFont()
                    ->setSize(13);
            },
        ];
    }
}
