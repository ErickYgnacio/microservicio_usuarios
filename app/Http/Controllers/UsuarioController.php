<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioStoreRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Models\Administrativo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index()
    {
        $users = User::whereHas('administrativo')->get();
        /* if ($users->isEmpty()) {
            $data = [
                'message' => 'No se encontraron usuarios',
                'users' => $users,
                'status' => 200
            ];
            return response()->json($data, 200);
        } */

        // Verificar si hay usuarios
        if ($users->isEmpty()) {
            $data = [
                'message' => 'No se encontraron usuarios',
                'content' => $users,
                'status' => 200,
                'empty' => true,
                'first' => true, // Si no hay usuarios, es el primer y último al mismo tiempo
                'last' => true,
                'number' => 0, // Página 0 al no tener usuarios
                'numberOfElements' => 0,
                'totalElements' => 0,
                'totalPages' => 0
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Usuarios encontrados',
            'content' => $users,
            'status' => 200,
            'empty' => false,
            'first' => false, // Asumimos que siempre estás trayendo la primera página
            'last' => false, // Si estás trayendo todos los usuarios en una sola página
            'number' => "1", // Número de la página actual
            'numberOfElements' => $users->count(),
            'totalElements' => $users->count(), // Todos los elementos ya que los traes en una sola página
            'totalPages' => 1 // Solo una página, dado que traes todos los registros
        ];
        return response()->json($data, 200);
    }

    public function store(UsuarioStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            unset($validated['categoria']);
            unset($validated['seguro']);
            $usuario = User::create($validated);

            $administrativo = Administrativo::create([
                'id_usuario' => $usuario->id_usuario,
                'categoria' => $request->categoria,
                'seguro' => $request->seguro
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Usuario creado exitosamente',
                'user' => $usuario->load('administrativo')
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
        try {
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
