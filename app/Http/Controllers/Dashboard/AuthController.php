<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        
    
        $user = $request->user();
    
        // Check if user is an admin
        if (Gate::allows('IsAdmin', $user)) {
            return view('Dashboards.index', compact('user'));
        }else{

            return view('welcome', compact('user'));
        }
    
    }
    
    public function registerUser(Request $request){
        $validateUser = Validator::make(
            $request->all(),[
            'name'=>'required|string',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|string|min:6'
            ]);

            if($validateUser->fails()){
           return response()->json([
            'status'=>false,
            'message'=>'please Insert Valid details',
            'error'=>$validateUser->errors()->all(),
           ], 404);
            }
            
            $users = User::create([  
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password
            ]);
            
            return response()->json([
                'status'=>true,
                'message'=>'User Created Successfully',
                'user'=>$users,
            ],200);
    }
    public function login(Request $request){
        $validateUser = Validator::make(
            $request->all(),[
            'email'=>'required|email',
            'password'=>'required|string|min:6'
            ]);

            if($validateUser->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'please Insert Valid details',
                'error'=>$validateUser->errors()->all()
            ], 404);
            }
            if(Auth::attempt(
            ['email'=>$request->email,
            'password'=>$request->password
            ])){
                $authUser = Auth::user();
                return response()->json([
                    'status'=>true,
                    'message'=>'user login succesfully',
                    'token'=>$authUser->createToken('api_token')->plainTextToken,
                    'token_type'=>'bearer',
                    'user'=>$authUser,
                ],200);

            }else{
                return response()->json([
                  'status'=>false,
                  'message'=>'email and password not match'
                ],404);
            }

    } 
    public function dashboard(Request $request){
     $user = $request->user();
    //  return response()->json([
    //     'user' => $request->user(),
    //     'token' => $request->bearerToken(),
    //     'authenticated' => $request->user() ? true : false
    // ]);

    if($user->role === 'admin'){
        return response()->json([
          'status'=>true,
          'redirect'=>route('admin-dashboard'),
          'user'=>$user
        ], 200);
    }else{
        return response()->json([
            'status'=>true,
            'redirect'=>route('home')
        ],200);
    }

    }
    public function logout(Request $request){
       $user = $request->user();
       $user->tokens()->delete();
        return response()->json([
            'status'=>true,
            'message'=>'User logout successfully',
        ],200);
    }
    public function selectUsers(){
        $data['user'] = User::all();
        return response()->json([
            'status'=>true,
            'message'=>'All users',
            'user'=>$data,
        ], 200);
    }
    public function LoginUserDetails(Request $request){
        $user = $request->user();
        return response()->json([
            'status'=>"true",
            'message'=>"user Details",
            'user'=>$user
        ] ,200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
