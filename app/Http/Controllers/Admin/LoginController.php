<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class LoginController extends Controller
{

    public function dashboard(Request $request){
        return view('admin.dashboard');
    }

    // public function register(){
    //     $data = array(
    //         'name' => 'Admin',
    //         'email' => 'admin@gmail.com',
    //         'password' => Hash::make('password'),
    //         'role' => 'superadmin'
    //     );
    //     DB::table('admins')->insert($data);
    //     echo "Success";
    // }

    public function login(){
        return view('admin/login');
    }

    public function authenticate(Request $request){

        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required'
        ]);
        
        if(!$validator->passes()){
            return response()->json([
                'error' => true,
                'error_type' => 'form',
                'message' => 'Invalid request',
                'errors' => $validator->errors()->toArray(),
            ], 422);

        }else{

            // $loginModel = new Login();
            // $response = $loginModel->authenticateMethod($request);

            try {

                $admin = Admin::where('email', $request->email)->first();
                
                if($admin){

                    if (Hash::check($request->password, $admin->password)) {

                        $admin->update(['last_login' => now()]);

                        $request->session()->put('username', $admin->name);
                        $request->session()->put('isAdmin', 'yes');
                        $request->session()->put('userType', $admin->role);
                        $request->session()->put('last_login', $admin->last_login ?? now());
                        return response()->json([
                            'success' => true,
                            'userType' => $admin->role,
                            'message' => 'Login successful'
                        ], 200);
                    }else{
                        return response()->json([
                            'error' => true,
                            'error_type' => 'login',
                            'message' => 'Login failed - Incorrect Credentials'
                        ], 401);
                    }      
                }else{
                    return response()->json([
                        'error' => true,
                        'error_type' => 'login',
                        'message' => 'Login failed - Admin not found'
                    ], 402);
                    // return $response;
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'error_type' => 'database',
                    'message' => 'Database connection error: ' . $e->getMessage(),
                ], 500);
            }

            return response()->json($response);
        }

    }    

    public function logout(Request $request){
        $request->session()->flush();
        return redirect()->route('admin.login');
    }
}
