<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    public function taskByUser(){
        try{
            $user = JWTAuth::parseToken()->authenticate();
            $tasks = Task::where('user_id', $user->id)->get();
            return response()->json(['tasks' => $tasks], 200);
        }catch (Exception $e) {
            return response()->json(['error' => 'Sin tareas'], 404);
        }

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
        try{
            $inputs = $request->input();
            $task = Task::create($inputs);
            return response()->json(['data'=> $task], 201);
        }catch(Exception $e){
            return response()->json(['error'=> 'error al crear la tarea'], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::find($id);
        if(isset($task)){
            return response()->json(['data'=> $task], 200);
        }
        return response()->json(['message'=> 'not found'], 404);
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
    public function update(Request $request, $id)
    {

        $task = Task::find($id);
        if(isset($task)){
            $task->description = $request->description;
            if($task->save()){
                return response()->json(['message'=> 'Updated task'], 204);
            }
        }

        return response()->json(['message'=> 'not found'], 404);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $task = Task::find($id);

        if(isset($task) && ($user->id == $task->user_id || $user->role == 'admin')){
            $task->status = $request->status;
            if($task->save()){
                return response()->json(['message'=> 'Updated task'], 204);
            }
        }

        return response()->json(['message'=> 'not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if(isset($task)){
            $res = Task::destroy($id);
            if($res){
                return response()->json(['mensaje'=> 'Deleted task'], 204);
            }

        }

        return response()->json(['error'=>true, 'mensaje'=> 'no existe la task'], 404);
    }
}
