<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\Models\User;
use App\Models\Projects;
use App\Models\Userprojects;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User_role;
use Illuminate\Support\Facades\Hash;

class ProjectController extends Controller
{
    public function addProject(Request $request){
        try {
            $credentials = $request->only('name');
            $validator = Validator::make($credentials, [
                'name'=>'required'
            ]);
            
            

            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
            if(Projects::where('name',$credentials['name'])->count()>0){
                    return response()->json([
                    'success' => false,
                    'message'=>'project with this name already exist'
                ]);
            }
            if($user=Projects::create($credentials)){
                
                return response()->json([
                'success' => true,
                'message'=>'project  created successfully',
            ]);
                
            }
        } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not create project.',
                ]);
        } 
    } 
    public function projectList(){
        try {
            $projectList=Projects::with('assigned_detail')->get();
            //echo '<pre>';print_R($projectList);exit;
            return response()->json([
                'success' => true,
                'projects' => $projectList
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not get user.',
                ]);
        } 

    }
    public function projectDetail($id){
        try {

            $projectList=Projects::where('id',$id)->first();
            return response()->json([
                'success' => true,
                'projects' => $projectList
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not get project.',
                ]);
        } 
    }
    public function updateProject(Request $request){
        try {
            $credentials = $request->only('name');
            $validator = Validator::make($credentials, [
                'name'=>'required'
            ]);
            

            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
            if(Projects::where('name',$credentials['name'])->count()>0){
                    return response()->json([
                    'success' => false,
                    'message'=>'project name already exist'
                ]);
            }

            if ($user = Projects::where("id", $request->id)->update(
                    $credentials)) {
                    return response()->json([
                        'success' => true,
                        'message'=>'project updated successfully',
                ]);

            }
            
        } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not update project.',
                ]);
        } 
    }
    public function projectDelete($id){
        try{
        $projectList=Projects::where('id',$id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'project deleted successfully'
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not delete project.',
                ]);
        } 
    }
    public function projectAssign(Request $request){
        try {


            $credentials = $request->only('project_id','user_id');
            $validator = Validator::make($credentials, [
                'project_id'=>'required',
                'user_id'=>'required'
            ]);
            
            

            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
            if(Userprojects::where('user_id',$credentials['user_id'])->where('project_id',$credentials['project_id'])->count()>0){
                    return response()->json([
                    'success' => false,
                    'message'=>'This project is already assigned to this user'
                ]);
            }
            if($user=Userprojects::create($credentials)){
                
                return response()->json([
                'success' => true,
                'message'=>'Project assigned successfully',
            ]);
                
            }
        } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not assigned project.',
                ]);
        } 
    }
}
