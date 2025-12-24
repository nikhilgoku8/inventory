<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeValueController extends Controller
{
    public function index(Request $request)
    {
        $data['attributes'] = Attribute::all();
        $data['result'] = AttributeValue::with('attribute')
            ->when($request->input('q'), fn($query) => $query->where('title', 'LIKE', '%'.$request->input('q').'%'))
            ->when($request->input('attribute_id'), fn($query) => $query->where('attribute_id', $request->input('attribute_id')))
            ->orderBy('attribute_id')
            ->orderBy('value')
            ->paginate(100);
        return view('admin.attribute-values.index', $data);
    }

    public function create()
    {
        $data['attributes'] = Attribute::all();
        return view('admin.attribute-values.create', $data);
    }

    public function show(AttributeValue $attributeValue)
    {
        $data['result'] = $attributeValue;
        $data['attributes'] = Attribute::all();
        return view('admin.attribute-values.show', $data);
    }

    public function edit(AttributeValue $attributeValue)
    {
        $data['result'] = $attributeValue;
        $data['attributes'] = Attribute::all();
        return view('admin.attribute-values.edit', $data);
    }

    public function store(Request $request)
    {
        return $this->handleAttributeValueRequest($request, new AttributeValue(), true);
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        return $this->handleAttributeValueRequest($request, $attributeValue, false);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    private function handleAttributeValueRequest(Request $request, AttributeValue $attributeValue, bool $isNew)
    {
        $dataID = $request->input('dataID');
        try {

            $rules = [
                'attribute_id' => 'required|exists:attributes,id',
                'value' => 'required|string|max:255|unique:attribute_values,value,'.$dataID,
                'code' => ['required', 'regex:/^[A-Z0-9]+(-[A-Z0-9]+)*$/', 'unique:attribute_values,code,'.$dataID],
            ];

            $messages = [];

            $attributes = [];

            $validator = Validator::make($request->all(), $rules , $messages, $attributes);

            // This validates and gives errors which are caught below and also stop further execution
            $validated = $validator->validated();

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            // Directly handle the save/update logic here
            if ($isNew) {
                $attributeValue = AttributeValue::create($validated);
            } else {
                $attributeValue->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'AttributeValue created successfully!' : 'AttributeValue updated successfully!',
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

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();
        return redirect()->route('admin.attribute-values.index')->with('success', 'AttributeValue deleted!');
    }

    public function bulkDelete(Request $request)
    {
        AttributeValue::destroy($request->input('dataID'));

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }

    public function get_values_by_attribute($id){
        return AttributeValue::where('attribute_id',$id)->get();
    }
}
