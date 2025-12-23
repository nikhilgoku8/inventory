<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $subCategoryIds = [];

        if(!empty($request->input('category_id'))){
            $category = Category::find($request->input('category_id'));
            $subCategoryIds = $category->subcategories->pluck('id')->toArray();
        }

        if(!empty($request->input('sub_category_id'))){
            $subCategoryIds = [$request->input('sub_category_id')];
        }

        $data['categories'] = Category::all();
        $data['sub_categories'] = !empty($request->input('category_id'))
            ? SubCategory::where('category_id', $request->input('category_id'))->get()
            : SubCategory::all();
            
        $data['result'] = Product::with('subCategory', 'subCategory.category')
            ->leftJoin('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->when($request->input('q'), function ($query) use ($request) {
                return $query->where('products.title', 'LIKE', '%'.$request->input('q').'%');
            })
            ->when($subCategoryIds, function ($query) use ($subCategoryIds) {
                return $query->whereIn('products.sub_category_id', $subCategoryIds);
            })
            ->orderBy('sub_categories.category_id')   // 🔥 Sort by category first
            ->orderBy('products.sub_category_id')
            ->orderBy('products.title')
            ->select('products.*') // VERY IMPORTANT otherwise pagination breaks
            ->paginate(100);

        return view('admin.products.index', $data);
    }

    public function create()
    {
        $data['categories'] = Category::all();
        return view('admin.products.create', $data);
    }

    public function show(Product $product)
    {
        $data['result'] = $product;
        $data['categories'] = Category::all();
        $data['subCategories'] = SubCategory::all();
        return view('admin.products.show', $data);
    }

    public function edit(Product $product)
    {
        $data['result'] = $product;
        $data['categories'] = Category::all();
        // $data['subCategories'] = SubCategory::all();
        $data['subCategories'] = SubCategory::where('category_id', $product->subCategory->category_id)->get();
        return view('admin.products.edit', $data);
    }

    public function store(Request $request)
    {
        return $this->handleProductRequest($request, new Product(), true);
    }

    public function update(Request $request, Product $product)
    {
        return $this->handleProductRequest($request, $product, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleProductRequest(Request $request, Product $product, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'sub_category_id' => 'required|exists:sub_categories,id',
                'title' => 'required|string|max:255|unique:products,title,'.$dataID,
                'description' => 'nullable|string',
                'code' => ['required', 'regex:/^[A-Z]+(-[A-Z]+)*$/', 'unique:products,code,'.$dataID],
                'image' => 'bail|required_without:existing_image|file|mimes:jpg,jpeg,png,webp|max:1024',
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            $validated = $validator->validated();

            $validated['slug'] = $this->string_filter($validated['title']);

            // Need to set folder path for file manipulation
            $uploadRoot = base_path(env('UPLOAD_ROOT'));
            $imagesFolder = $uploadRoot . '/products';

            if($request->hasFile('image')){
                $file = $validated['image'];
                $fileName = $validated['slug'] . '_' . uniqid() . '_' . date('Ymdhis') . '.' . $file->getClientOriginalExtension();
                $file->move($imagesFolder, $fileName);
                $validated['image'] = $fileName;

                if(!empty($dataID)){
                    // Get existing image name from database for current id
                    $existing_image = Product::find($dataID)->image;

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

            // Directly handle the save/update logic here
            if ($isNew) {
                $product = Product::create($validated);
            } else {
                $product->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Product created successfully!' : 'Product updated successfully!',
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

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }

    public function bulkDelete(Request $request)
    {
        Product::destroy($request->input('dataID'));

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
