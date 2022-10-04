<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User_role;
use App\Models\roles;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function authenticate(Request $request){
        //echo 'test';exit;
       $credentials = $request->only('email', 'password');
       //echo '<pre>';print_R($credentials);exit;
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        //echo '<pre>';print_R($request->all());exit;
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 200);
            }
        } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not create token.',
                ], 500);
        }
    
        //Token created, return with success response and jwt token
        $user = JWTAuth::user();
        return response()->json([
            'success' => true,
            'token' => $token,
            'detail'=>$user,
        ]);
    }
    public function addUser(Request $request){
        try {
            $credentials = $request->only('email', 'password','name');
            $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required',
                'name'=>'required'
            ]);
            

            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
            if(User::where('email',$credentials['email'])->count()>0){
                    return response()->json([
                    'success' => false,
                    'message'=>'email already exist'
                ]);
            }
            $credentials['password']=Hash::make($credentials['password']);
            if($user=User::create($credentials)){
                $user_id=$user->id;
                $role_id=2;
                User_role::create(['user_id'=>$user_id,'role_id'=>$role_id]);
                return response()->json([
                'success' => true,
                'user_id' => $user_id,
                'message'=>'user added successfully',
            ]);
                
            }
        } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not create user.',
                ]);
        } 
    }

    public function userList(){
        try {
           $userList=User::with("role")->get();
            return response()->json([
                'success' => true,
                'user' => $userList
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not get user.',
                ]);
        } 

    }
    public function userDetail($id){
        try {

             $userList=User::with("role")->where('id',$id)->first();

             //print_r($userList);die();
            return response()->json([
                'success' => true,
                'user' => $userList
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not get userdetail.',
                ]);
        } 

    }
    public function updateUser(Request $request){
        try {
            $credentials = $request->only('email','name','password');
            $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password'=>'required',
                'name'=>'required'
            ]);
             $credentials['password']=Hash::make($credentials['password']);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
            if(User::where('email',$credentials['email'])->count()>0){
                    return response()->json([
                    'success' => false,
                    'message'=>'email already exist'
                ]);
            }

            if ($user = User::where("id", $request->id)->update(
                    $credentials)) {
                    return response()->json([
                        'success' => true,
                        'message'=>'user updated successfully',
                ]);

            }
            
        } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not create user.',
                ]);
        } 
    }

    public function userDelete($id){
        try{
        $userList=User::where('id',$id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'user deleted successfully'
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not delete user.',
                ]);
        } 
    }
    public function roleList(){
        try {

            $user = JWTAuth::user();           
            $userList=roles::get();
            return response()->json([
                'success' => true,
                'roles' => $userList
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not get rolelist.',
                ]);
        } 

    }
    
}
