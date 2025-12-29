<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Attribute;

class AttributeController extends Controller
{
    public function index()
    {
        $data['result'] = Attribute::paginate(100);
        return view('admin.attributes.index', $data);
    }

    public function create()
    {
        return view('admin.attributes.create');
    }

    public function show(Attribute $attribute)
    {
        $data['result'] = $attribute;
        return view('admin.attributes.show', $data);
    }

    public function edit(Attribute $attribute)
    {
        $data['result'] = $attribute;
        return view('admin.attributes.edit', $data);
    }

    public function string_filter($string){
        $string = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-\']/', '', str_replace(' ', '-', str_replace("- ","-", str_replace(" -","-", str_replace("&","and", preg_replace("!\s+!"," ",strtolower($string))))))));
        return $string;
    }

    public function store(Request $request)
    {
        return $this->handleAttributeRequest($request, new Attribute(), true);
    }

    public function update(Request $request, Attribute $attribute)
    {

        return $this->handleAttributeRequest($request, $attribute, false);

    }

    private function handleAttributeRequest(Request $request, Attribute $attribute, bool $isNew)
    {

        $dataID = $request->input('dataID');

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:attributes,title,'. $dataID,
                'sort_order' => 'nullable|numeric|min:0',
            ]);

            if ($isNew) {
                $validated['created_by'] = session('username');
            }
            $validated['updated_by'] = session('username');

            // Directly handle the save/update logic here
            if ($isNew) {
                $attribute = Attribute::create($validated);
            } else {
                $attribute->update($validated);
            }

            return response()->json([
                'status' => 'success',
                'message' => $isNew ? 'Attribute created successfully!' : 'Attribute updated successfully!',
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

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute deleted!');
    }

    public function bulkDelete(Request $request)
    {
        // $dataIDs = $request->input('dataID');

        Attribute::destroy($request->dataID);

        return response()->json(['success' => true, 'message' => 'Record Deleted']);
    }
}
