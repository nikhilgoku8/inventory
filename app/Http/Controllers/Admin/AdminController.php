<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index(){
        $this->data['result'] = Admin::orderBy('admins.name')->paginate(25);
        return view('admin.admins.index', $this->data);
    }

    public function usertype($usertype){
        $this->data['result'] = Admin::where('admins.role', $usertype)->orderBy('admins.name')->paginate(25);
        return view('admin.admins.index', $this->data);
    }

    public function create(){
        return view('admin.admins.create');
    }

    public function store(Request $request){

        $dataID = $request->dataID;

        $rules = array(
            'name'=>'required',
            'email'=>'required|email',
            'password'=> $dataID ? 'nullable|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/' : 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'role'=>'required'
        );

        $validator = Validator::make($request->all(), $rules);
        
        if(!$validator->passes()){
            return response()->json([
                'error' => true,
                'error_type' => 'form',
                'message' => 'Invalid request',
                'errors' => $validator->errors()->toArray(),
            ], 422);

        }else{

            $data = array(
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'updated_by' => session('username'),
                'updated_at' => now()
            );

            if(!empty($request->password)){
                $data['password'] = Hash::make($request->password);
            }

            if(!empty($request['dataID'])){

                $old_password = DB::table('admins')->where('id', $request['dataID'])->value('password');
                if (Hash::check($request->password, $old_password)){
                    
                    return response()->json([
                        'error' => true,
                        'error_type' => 'form',
                        'message' => 'Invalid request',
                        'errors' => ['password' => 'Previous Password Not Allowed'],
                    ], 422);
                }

                Admin::where('id', $request['dataID'])->update($data);

                session()->flash('success','Record updated');
                $response = array(
                    'success' => true,
                    'message' => 'Record created',
                    'class' => 'alert alert-success'
                );
            }else{
                $data['created_by'] = session('username');
                $data['created_at'] = now();

                Admin::create($data);
                
                session()->flash('success','Record created');
                $response = array(
                    'success' => true,
                    'message' => 'Record created',
                    'class' => 'alert alert-success'
                );
            }

            return response()->json($response);

        }
    }

    public function edit($dataID){
        $this->data['result'] = Admin::find($dataID);
        return view('admin.admins.edit', $this->data);
    }

    public function bulkDelete(Request $request){

        Admin::destroy($request->dataID);

        $response = array(
            'success' => true,
            'message' => 'Record created'
        );

        return response()->json($response);
    }
}
