<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccount;
use App\Models\User;
use App\Notifications\ConfirmAccountNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $users = User::where('role', 'employee')->get();
            return response()->json($users, 200);
        }catch(Exception $e){
            return response()->json(['Error' => 'no es encontraron usuarios'], 404);
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
        try {
            $user = $request->input();
            $user['role'] = 'employee';

            $createdUser = User::create($user);
    
            Mail::to($createdUser->email)->send(new ConfirmAccount('establece pass', 'http://localhost:5173/resetPass'));
    
            return response()->json(['message' => 'Correo electrónico de confirmación enviado correctamente.'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'No se pudo crear el usuario.']);
        }
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
    public function update(Request $request)
    {
        $data = $request->input();
        $user = User::where('email', $data['email'])->first();

        if (!$user || $data['password'] != $data['confirm_password']) {
            return response()->json(['error' => 'Incorrect credentials'], 400);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return response()->json(['message' => 'Contraseña restablecida correctamente'], 204);
    }

    public function SendEmail(Request $request){
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['error' => 'Correo electrónico no encontrado'], 404);
        }
        Mail::to($user->email)->send(new ConfirmAccount('restablecer pass', 'http://localhost:5173/resetPass'));

        return response()->json(['message' => 'Correo electrónico enviado'], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
