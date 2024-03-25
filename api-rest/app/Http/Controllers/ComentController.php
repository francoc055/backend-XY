<?php

namespace App\Http\Controllers;

use App\Models\Coment;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ComentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        try {
            $comment = $request->input();
            Coment::create($comment);
            return response()->json(['message' => 'Comentario agregado correctamente'], 201);
    
        } catch (Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir
            return response()->json(['error' => $e], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function getCommentsByTask($idTask){
        try {
            // Busca la tarea por su ID
            $task = Task::findOrFail($idTask);
    
            // Obtén los comentarios relacionados con la tarea
            $comments = Coment::where('task_id', $task->id)->get();
    
            return response()->json(['comments' => $comments], 200);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir
            return response()->json(['error' => 'No se encontraron comentarios para la tarea especificada'], 404);
        }
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
    public function destroy($commentId)
    {
        try{
            $user = JWTAuth::parseToken()->authenticate();
            $comment = Coment::findOrFail($commentId);
            
            $task = Task::findOrFail($comment['task_id']);

            if($user->id == $task['user_id'] || $comment['user_id'] == $user->id || $user->role == 'admin'){
                $comment->delete();
                return response()->json(['message' => 'Comentario eliminado correctamente'], 204);
            }
            else
            {
                return response()->json(['message'=> 'Unauthorized'], 401);
            }
        }catch (Exception $e) {
            return response()->json(['message' => 'error'], 401);
        }
    }
}
