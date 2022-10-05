<?php

namespace App\Http\Controllers;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Tasks;



class TasksController extends Controller
{
   public function addTask(Request $request){
        try {

             

            $credentials = $request->only('taskname','taskdetail','project_id');


            $validator = Validator::make($credentials, [
                 'taskname'=>'required',
                 'taskdetail'=>'required',
                 'project_id'=>'required'

              
            ]);
           
            
        
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
            // if(Projects::where('name',$credentials['name'])->count()>0){
            //         return response()->json([
            //         'success' => false,
            //         'message'=>'project with this name already exist'
            //     ]);
            // }

            if($user=Tasks::create($credentials)){
                
                return response()->json([
                'success' => true,
                'message'=>'task  created successfully',
            ]);
                
            }
        } catch (JWTException $e) {
        
            return response()->json([
                    'message' => 'Could not create task.',
                ]);
        } 
    }
    public function taskList($id){
        try {

            //echo 'work';die();
            $taskList=Tasks::where('project_id',$id)->get();
                   
            return response()->json([
                'success' => true,
                'tasks' => $taskList
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not get task.',
                ]);
            
        } 

    }
}