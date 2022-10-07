<?php

namespace App\Http\Controllers;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Tasks;
use App\Models\Assigntask;



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

     public function updatetask(Request $request){
        try {

            //echo 'workedit';die();
             $credentials = $request->only('taskname','taskdetail','project_id');

             //echo '<pre>';print_r($credentials );die();
            $validator = Validator::make($credentials, [
                 'taskname'=>'required',
                 'taskdetail'=>'required',
                 'project_id'=>'required'
              
            ]);
            //$credentials['status']="pending";
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
            }
            if(Tasks::where('taskname',$credentials['taskname'])->count()>0){
                    return response()->json([
                    'success' => false,
                    'message'=>'tasks with this name already exist'
                ]);
            }
             if ($user = Tasks::where("id", $request->id)->update(
                    $credentials)) {
                    return response()->json([
                        'success' => true,
                        'message'=>'task updated successfully',
                ]);

            }          
        } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not update task.',
                ]);
        } 
    }

    public function taskDelete($id){
        try{

            //echo 'delete';die();
        $projectList=Tasks::where('id',$id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'task deleted successfully'
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not delete task.',
                ]);
        } 
    }

    public function assigntask(Request $request){
        try {
            //echo 'assigntask';die();

            $credentials = $request->only('user_id','project_id','task_id','starting_date','ending_date','status');

              $validator = Validator::make($credentials, [
                 'user_id'=>'required',
                 'project_id'=>'required',
                 'task_id'=>'required',
                 'starting_date'=>'required',
                 'ending_date'=>'required',
         ]);
              if(Assigntask::where('user_id',$request->user_id)->where('task_id',$request->task_id)->count()>0){
                    return response()->json([
                    'success' => false,
                    'message'=>'This task is already assigned to other person',
                ]);
              }

           if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 200);
                
            }
              // $taskList=Task::where('id',$id)->first();
             if($user=Assigntask::create($credentials)){
                
                return response()->json([
                'success' => true,
                'message'=>'task Assign successfully',
            ]);
                
            }

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Failed to assign task.',
                ]);
        } 
    }
    public function taskDetail(){
         try {
                 //echo 'edit';die();
              // $taskList=Task::where('id',$id)->first();
             $task_detail=Assigntask::with('task_detail')->with('user')->with('project')->get()->toArray();
             //echo '<pre>';print_R($task_detail);exit;
                
                return response()->json([
                'success' => true,
                'data'=>$task_detail,
            ]);
                
            
            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Failed to assign task.',
                ]);
        } 
    }
    public function assigntaskDelete($id){
        try{

            //echo 'delete';die();
            
        $projectList=Assigntask::where('id',$id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Assigntask deleted successfully'
            ]);

            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Could not delete Assigntask.',
                ]);
        } 
    }
    public function usertaskList($id){
         try {
                 //echo 'edit';die();
             $task_detail=Assigntask::where("user_id" ,$id)->with('user_task_detail')->with('project_detail')->get();
             //echo '<pre>';print_R($task_detail);exit;
                
                return response()->json([
                'success' => true,
                'data'=>$task_detail,
            ]);
                
            
            } catch (JWTException $e) {
        
            return response()->json([
                    'success' => false,
                    'message' => 'Failed to get task.',
                ]);
        } 
    }



}