<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
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
        $inputs = $request->input();
        $task = Task::create($inputs);
        return response()->json(['data'=> $task], 201);
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
        $task = Task::find($id);
        if(isset($task)){
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
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if(isset($user)){
            $res = Task::destroy($id);
            if($res){
                return response()->json(['mensaje'=> 'Deleted task'], 204);
            }

        }

        return response()->json(['error'=>true, 'mensaje'=> 'no existe el user'], 404);
    }
}
