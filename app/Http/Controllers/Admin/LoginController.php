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
    //         'email' => 'admin@anishpharma.com',
    //         'password' => Hash::make('E3b5jolem65xKzP3'),
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
                        $response = array(
                            'success' => true,
                            'userType' => $admin->role,
                            'message' => 'Login successful'
                        );
                        return $response;
                    }else{
                        $response = array(
                            'error' => true,
                            'error_type' => 'login',
                            'message' => 'Login failed - Incorrect Credentials'
                        );
                        return $response;
                    }      
                }else{
                    $response = array(
                        'error' => true,
                        'error_type' => 'login',
                        'message' => 'Login failed - Admin not found'
                    );
                    return $response;
                }
            } catch (\Exception $e) {
                return [
                    'error' => true,
                    'error_type' => 'database',
                    'message' => 'Database connection error: ' . $e->getMessage(),
                ];
            }

            if(array_key_exists('error', $response)){                
                return response()->json($response, 422);
            }

            return response()->json($response);

        }

    }    

    public function logout(Request $request){
        $request->session()->flush();
        return redirect()->route('admin.login');
    }
}
