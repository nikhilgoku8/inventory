<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Sku;
use App\Models\SkuBundle;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\InventoryMovement;

use Picqer\Barcode\BarcodeGeneratorPNG;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SkuController extends Controller
{
    // public function index(Request $request)
    // {

    //     $subCategoryIds = [];

    //     if(!empty($request->input('category_id'))){
    //         $category = Category::find($request->input('category_id'));
    //         $subCategoryIds = $category->subcategories->pluck('id')->toArray();
    //     }

    //     if(!empty($request->input('sub_category_id'))){
    //         $subCategoryIds = [$request->input('sub_category_id')];
    //     }

    //     $data['categories'] = Category::all();
    //     $data['sub_categories'] = !empty($request->input('category_id'))
    //         ? SubCategory::where('category_id', $request->input('category_id'))->get()
    //         : SubCategory::all();
            
    //     $data['result'] = Sku::with('subCategory', 'subCategory.category')
    //         ->leftJoin('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
    //         ->when($request->input('q'), function ($query) use ($request) {
    //             return $query->where('products.title', 'LIKE', '%'.$request->input('q').'%');
    //         })
    //         ->when($subCategoryIds, function ($query) use ($subCategoryIds) {
    //             return $query->whereIn('products.sub_category_id', $subCategoryIds);
    //         })
    //         ->orderBy('sub_categories.category_id')   // 🔥 Sort by category first
    //         ->orderBy('products.sub_category_id')
    //         ->orderBy('products.title')
    //         ->select('products.*') // VERY IMPORTANT otherwise pagination breaks
    //         ->paginate(100);

    //     return view('admin.products.index', $data);
    // }

    public function scan_qr()
    {
        return view('admin.scan-qr');
    }

    public function create(Product $product)
    {
        $data['result'] = $product;
        $data['attributes'] = Attribute::all();
        $data['products'] = Product::all();
        return view('admin.skus.create', $data);
    }

    public function view(Request $request)
    {
        $data['result'] = $sku;
        $data['categories'] = Category::all();
        $data['subCategories'] = SubCategory::all();
        return view('admin.skus.show', $data);
    }

    public function validateSku(Request $request)
    {
        $request->validate([
            'sku_code' => 'required|exists:skus,sku_code'
        ]);

        $sku = Sku::where('sku_code', $request->sku_code)->first();

        // if (! $sku) {
        //     return response()->json([
        //         'error' => true,
        //         'message' => 'Invalid SKU code',
        //         'errors' => [ 'all_errors' => 'Invalid SKU code'],
        //     ], 422);
        // }

        return response()->json([
            'success' => true,
            'redirect_url' => route('admin.skus.edit', $sku->id)
        ]);
    }

    public function show(Sku $sku)
    {
        $data['result'] = $sku;
        return view('admin.skus.show', $data);
    }

    public function edit(Sku $sku)
    {
        $data['result'] = $sku->loadMissing('attributeValues');
        return view('admin.skus.edit', $data);
    }

    public function store(Request $request, Product $product)
    {
        return $this->handleSkuRequest($request, new Sku(), true, $product);
    }

    public function update(Request $request, Sku $sku)
    {
        if ($sku->is_bundle) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bundle Inventory Movements Not Allowed',
                'errors' => [ 'all_errors' => 'Bundle Inventory Movements Not Allowed'],
            ], 403);
        }

        try {

            $rules = [
                'image' => 'bail|required_without:existing_image|file|mimes:jpg,jpeg,png,webp|max:1024',
                'stock' => 'required|numeric|min:1',
                'movement_type' => 'required',
                'remarks' => 'nullable|string',
            ];

            $messages = [];

            $validator = Validator::make($request->all(), $rules , $messages, []);

            $validated = $validator->validated();

            $currentStock = $sku->stock;
            $stockToBeUpdated = 0;

            if ($validated['movement_type'] == 'decrement'){

                if ($currentStock < $validated['stock']) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid attribute and value combination.',
                        'errors' => [ 'stock' => 'Decrement Stock cannot be less than current stock'],
                    ], 422);
                }
                $stockToBeUpdated = $currentStock - $validated['stock'];

            }else{
                $stockToBeUpdated = $currentStock + $validated['stock'];
            }

            $skuData = [
                'stock' => $stockToBeUpdated,
                'created_by' => session('username'),
                'updated_by' => session('username'),
            ];

            // Need to set folder path for file manipulation
            $uploadRoot = base_path(env('UPLOAD_ROOT'));
            $imagesFolder = $uploadRoot . '/products/'. $sku->product->slug;

            if($request->hasFile('image')){
                $file = $validated['image'];
                $fileName = $sku->product->slug . '_' . uniqid() . '_' . date('Ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->move($imagesFolder, $fileName);
                $skuData['image'] = $fileName;

                $existing_image = $sku->image;
                // Delete existing image if exists
                if($existing_image && file_exists($imagesFolder.'/'.$existing_image)){
                    @unlink($imagesFolder.'/'.$existing_image);
                }

            }else{
                $validated['image'] = $request->input('existing_image');
            }

            $sku->update($skuData);

            InventoryMovement::create([
                'sku_id' => $sku->id,
                'quantity' => $validated['stock'],
                'movement_type' => $validated['movement_type'],
                'remarks' => $validated['remarks'],
                'created_by' => session('username'),
                'updated_by' => session('username'),
            ]);

            session()->flash('success', 'Sku updated successfully!');

            return response()->json([
                'status' => 'success',
                'message' => 'Sku updated successfully!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }

    // public function string_filter($string){
    //     $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
    //     return $string;
    // }

    private function handleSkuRequest(Request $request, Sku $sku, bool $isNew, Product $product)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'image' => 'bail|required_without:existing_image|file|mimes:jpg,jpeg,png,webp|max:1024',
                // 'price' => 'nullable|numeric',
                'stock' => 'required|numeric|min:1',
                'attributes' => 'required|array|min:1',
                'attributes.*.id' => 'required|exists:attributes,id|distinct',
                'attributes.*.value' => 'required|exists:attribute_values,id|distinct',
                'is_bundle' => 'required|boolean',
                'bundles' => 'required_if:is_bundle,1|array|min:1',
                'bundles.*.product_id' => 'nullable|required_if:is_bundle,1|exists:products,id',
                'bundles.*.sku_id' => 'nullable|required_if:is_bundle,1|exists:skus,id|distinct',
                'bundles.*.quantity' => 'nullable|required_if:is_bundle,1|numeric|min:1',
            ];

            $messages = [
                'required_without' => 'The :attribute field is required.'
            ];

            $validator = Validator::make($request->all(), $rules , $messages, []);

            $validated = $validator->validated();

            // dd($validated['is_bundle']);
            
            // To cross check if the attribute value id belongs to the attribute type id
            foreach ($validated['attributes'] as $attr) {
                $isValid = DB::table('attribute_values')
                    ->where('id', $attr['value'])
                    ->where('attribute_id', $attr['id'])
                    ->exists();

                if (! $isValid) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid attribute and value combination.',
                        'errors' => [ 'all_errors' => 'Invalid attribute and value combination.'],
                    ], 422);
                }
            }

            $incomingAttributeValueIds = collect($validated['attributes'])
                ->pluck('value')
                // ->map('intval')
                ->map(fn ($v) => (int) $v)
                ->sort()
                ->values()
                ->toArray();


            $product->load('skus.attributeValues:id');

            // foreach ($product->skus->where('id', '!=', $skuId) as $sku) {
            foreach ($product->skus as $sku) {

                $existing = $sku->attributeValues
                    ->pluck('id')
                    ->sort()
                    ->values()
                    ->toArray();

                if ($existing === $incomingAttributeValueIds) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'This SKU variant already exists for this product.',
                        'errors' => [ 'all_errors' => 'This SKU variant already exists for this product.'],
                    ], 422);
                }
            }

            $validated['product_id'] = $product->id;

            // Need to set folder path for file manipulation
            $uploadRoot = base_path(env('UPLOAD_ROOT'));
            $imagesFolder = $uploadRoot . '/products/'. $product->slug;

            if($request->hasFile('image')){
                $file = $validated['image'];
                $fileName = $product->slug . '_' . uniqid() . '_' . date('Ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->move($imagesFolder, $fileName);
                $validated['image'] = $fileName;

                if(!empty($dataID)){
                    // Get existing image name from database for current id
                    $existing_image = Sku::find($dataID)->image;

                    // Delete existing image if exists
                    if($existing_image && file_exists($imagesFolder.'/'.$existing_image)){
                        @unlink($imagesFolder.'/'.$existing_image);
                    }
                }
            }else{
                $validated['image'] = $request->input('existing_image');
            }

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            $attribute_codes = AttributeValue::whereIn('attribute_values.id', $incomingAttributeValueIds)
                ->join('attributes', 'attributes.id', '=', 'attribute_values.attribute_id')
                ->orderBy('attributes.sort_order')
                ->pluck('attribute_values.code')
                ->implode('-');

            // dd($attribute_codes);

            $validated['sku_code'] = $product->code .'-'.$attribute_codes;

            // // Generate via sku_code and store barcode
            // $generator = new BarcodeGeneratorPNG();
            // $barcodeData = $generator->getBarcode($validated['sku_code'], $generator::TYPE_CODE_128);

            // $validated['barcode'] = $product->slug . '_barcode_' . uniqid() . '_' . date('Ymdhis') . '.png';

            // file_put_contents($imagesFolder . '/' . $validated['barcode'], $barcodeData);

            // Generate via sku_code and store barcode
            $qr_data =  QrCode::format('svg')
                ->size(300)     // print-safe size
                ->margin(2)
                ->generate($validated['sku_code']);

            $validated['barcode'] = $product->slug . '_qr_code_' . uniqid() . '_' . date('Ymdhis') . '.svg';

            file_put_contents($imagesFolder . '/' . $validated['barcode'], $qr_data);

            // Directly handle the save/update logic here
            if ($isNew) {
                $sku = Sku::create($validated);
            } else {
                $sku->update($validated);
            }

            $sku->attributeValues()->sync($incomingAttributeValueIds);

            // Create if bundle
            if($validated['is_bundle']){
                foreach($validated['bundles'] as $bundle){
                    SkuBundle::create([
                        'bundle_sku_id' => $sku->id,
                        'child_sku_id'  => $bundle['sku_id'],
                        'quantity'      => $bundle['quantity'],
                    ]);
                }

                // Bundle Stock is derived so need to set it as 0
                $sku->update(['stock' => 0]);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Sku created successfully!' : 'Sku updated successfully!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'form',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'error',
                'error_type' => 'server',
                'message' => 'Something went wrong. Please try again later.',
                'console_message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Sku $sku)
    {
        $sku->delete();
        return redirect()->route('admin.products.index')->with('success', 'Sku deleted!');
    }

    public function bulkDelete(Request $request)
    {
        Sku::destroy($request->input('dataID'));

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }

    public function get_skus_by_product($id){
        // $data = [];
        // $skus = Sku::where('product_id',$id)->get();
        // foreach ($skus as $sku) {
        //     $i = 1;
        //     $attribute_values = '';
        //     foreach ($sku->attributeValues as $attribute){
        //         if($i != 1){
        //             $slash = ' / ';
        //         }else{
        //             $slash = '';
        //         }
        //         $attribute_values .= $slash . $attribute->value;
        //         $i++;
        //     }

        //     $data[] = [
        //         'id' => $sku->id,
        //         'value' => $attribute_values,
        //     ];
        // }
        // return $data;

        // This I got with ChatGPT
        return Sku::with('attributeValues')
        ->where('product_id', $id)
        ->where('is_bundle', 0)
        ->get()
        ->map(function ($sku) {
            return [
                'id' => $sku->id,
                'value' => $sku->attributeValues
                    ->pluck('value')
                    ->implode(' / ')
            ];
        })
        ->toArray();
    }
}
