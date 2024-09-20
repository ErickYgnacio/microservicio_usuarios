<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $data = [
                'message' => 'No se encontraron usuarios',
                'users' => $users,
                'status' => 200
            ];
            return response()->json($data, 200);
        }
        return response()->json($users, 200);
    }

    public function store(UsuarioStoreRequest $request)
    {
        DB::beginTransaction();
        try{
            $validated = $request->validated();
            $usuario = User::create($validated);
            DB::commit();
            return response()->json([
                'message' => 'Usuario creado exitosamente',
                'user' => $usuario
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(User $user)
    {
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(UsuarioUpdateRequest $request, User $user)
    {
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        DB::beginTransaction();
        try{
            $validated = $request->validated();
            $user->update($validated);
            DB::commit();
            return response()->json([
                'message' => 'Usuario actualizado exitosamente',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado exitosamente'], 200);
    }
}
