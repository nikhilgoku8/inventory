<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data['categories'] = Category::all();
        $data['result'] = SubCategory::with('category')
            ->when($request->input('q'), fn($query) => $query->where('title', 'LIKE', '%'.$request->input('q').'%'))
            ->when($request->input('category_id'), fn($query) => $query->where('category_id', $request->input('category_id')))
            ->orderBy('category_id')
            ->orderBy('title')
            ->paginate(100);
        return view('admin.sub-categories.index', $data);
    }

    public function create()
    {
        $data['categories'] = Category::all();
        return view('admin.sub-categories.create', $data);
    }

    public function show(SubCategory $subCategory)
    {
        $data['result'] = $subCategory;
        $data['categories'] = Category::all();
        return view('admin.sub-categories.show', $data);
    }

    public function edit(SubCategory $subCategory)
    {
        $data['result'] = $subCategory;
        $data['categories'] = Category::all();
        return view('admin.sub-categories.edit', $data);
    }

    public function store(Request $request)
    {
        return $this->handleSubCategoryRequest($request, new SubCategory(), true);
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        return $this->handleSubCategoryRequest($request, $subCategory, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleSubCategoryRequest(Request $request, SubCategory $subCategory, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255|unique:sub_categories,title,'.$dataID,
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            $validated['slug'] = $this->string_filter($validated['title']);

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            // Directly handle the save/update logic here
            if ($isNew) {
                $subCategory = SubCategory::create($validated);
            } else {
                $subCategory->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'SubCategory created successfully!' : 'SubCategory updated successfully!',
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

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return redirect()->route('admin.sub-categories.index')->with('success', 'SubCategory deleted!');
    }

    public function bulkDelete(Request $request)
    {
        SubCategory::destroy($request->input('dataID'));

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }

    public function get_sub_categories_by_category($id){
        return SubCategory::where('category_id',$id)->get();
    }
}
