<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Sku;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportProducts implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        // $products = Product::with([
        //     'skus.attributeValues' => function ($query) {
        //         $query->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
        //               ->orderBy('attributes.sort_order', 'asc')
        //               ->select('attribute_values.*');
        //     },
        //     'skus.attributeValues.attribute'
        // ])->get();

        $categories = Category::with([
            'subCategories.products.skus.attributeValues' => function ($query) {
                $query->join('attributes', 'attribute_values.attribute_id', '=', 'attributes.id')
                      ->orderBy('attributes.sort_order', 'asc')
                      ->select('attribute_values.*');
            },
        ])->get();

        $allSkus = Sku::with('attributeValues')->get();

        // Find max attribute values count across all SKUs
        // $maxAttributeValues = $products
        //     ->flatMap(fn ($product) => $product->skus)
        //     ->map(fn ($sku) => $sku->attributeValues->count())
        //     ->max();

        $maxAttributeValues = $allSkus
            ->map(fn ($sku) => $sku->attributeValues->count())
            ->max();

        // Static headings
        $headings = [
            'Category',
            'Sub Category',
            'Product',
            // 'SKU Code',
        ];

        // Dynamic attribute columns
        for ($i = 1; $i <= $maxAttributeValues; $i++) {
            // $headings[] = "Attribute Name $i";
            $headings[] = "Attribute Value $i";
        }

        $data = collect([$headings]);


        foreach ($categories as $category) {
            foreach ($category->subCategories as $subCategory){
                foreach ($subCategory->products as $product) {
                    foreach ($product->skus as $sku) {

                        $row = [
                            $category->title,
                            $subCategory->title,
                            $product->title,
                            // $sku->sku_code ?? '',
                        ];

                        foreach ($sku->attributeValues as $attributeValue) {
                            // $row[] = $attributeValue->attribute->title ?? '';
                            $row[] = $attributeValue->value ?? '';
                        }

                        // Fill empty columns if SKU has fewer attributes
                        $missing = ($maxAttributeValues - $sku->attributeValues->count()) * 2;

                        for ($i = 0; $i < $missing; $i++) {
                            $row[] = '';
                        }

                        $data->push($row);
                    }
                }
            }
        }

        return $data;
    }
}
