<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource; //resource is for stucturing and JSON
use App\Http\Requests\StoreTaskRequest; //Request is for validation
use App\Models\Task;
use App\Traits\HttpResponses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $data = TaskResource::collection(
            Task::where('user_id', Auth::user()->id)->get()
        );
         return $data;
        // $tasks = Task::latest()->paginate(1);
        // return [
        //     "status" => 1,
        //     "data" => $tasks
        // ];
         
         
    }
  

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());

        $task = Task::create([
            'user_id'=> Auth::user()->id,
            'name'=>$request->name,
            'description'=>$request->description,
            'priority'=>$request->priority,
        ]);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // $task = Task::where('id', $id)->get();
        return new TaskResource($task);
        //return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        $request->validated($request->all());

        if(Auth::user()->id !== $task->user_id){
            return $this->error('', 'You are not the owner of this task!', 403);
        }
        $task->update($request->all());

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if(Auth::user()->id !== $task->user_id){
            return $this->error('', 'You are not the owner of this task!', 403);
        }

        $task->delete();
        return $this->success('', 'Deleted successfully!!', 200);
        
        //return $this->notTheOwner($task) ? $this->notTheOwner($task) : $task->delete();
    }

    // private function notTheOwner($task){
    //     if(Auth::user()->id !== $task->user_id){
    //         return $this->error('', 'You are not the owner of this task!', 403);
    //     }
    // }
}
