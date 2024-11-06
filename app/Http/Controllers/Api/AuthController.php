<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $dataUser = $request->only(keys: [
                'first_name',
                'last_name',
                'email',
                'password',
                'rol_id',
                'image_id',
                'professional_id',
                'created_at',
                'updated_at',
            ]);
            $request->validate(User::CREATE_RULES,User::ERROR_MESSAGES);

            $dataUser['password'] = Hash::make(value: $dataUser['password']);
            $dataUser['create_at'] = now();
            $dataUser['updated_at'] = now();

            if($request->hasFile('cover')){
                $cover = $request->file('cover');
                $dataUser['cover_alt'] = $dataUser['cover_alt'] ?? 'Imagen de perfil';
                
                $image = Image::manipularImg(250, 400, 'users',$cover, $dataUser['cover_alt']);
                $dataUser['image_id'] = $image->id;
            }

            User::create(attributes: $dataUser);

            DB::commit();

            return response()->json(data: ['message' => 'El usuario con el email: '. $dataUser['email'] . ' fue con exito' ], status: 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(data: [
                'errors' => $e->errors()
            ], status: 422);
    
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) return response()->json(
                data: ['errors' => ['email'=>['Este email ya esta registrado. por favor, Intente con otro']]], 
                status: 422);

            return response()->json(data: [
                'message' => 'Error en la base de datos. Por favor, inténtelo de nuevo.',
                'errors' => $e->getMessage()
            ], status: 500);
        } catch (\Throwable $th) {
            DB::rollBack();
    
            return response()->json(data: [
                'message' => 'Ocurrio un error inesperado. Por favor, inténtelo de nuevo.',
                'errors' => $th->getMessage()
            ], status: 500);
        }
    }

    public function login(Request $request)
    {
        // Validación de los campos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'string', 
                'min:6', // Mínimo 6 caracteres
                'regex:/[a-z]/', // Debe contener al menos una letra minúscula
                'regex:/[A-Z]/', // Debe contener al menos una letra mayúscula
                'regex:/[0-9]/', // Debe contener al menos un número
            ]
        ]);
    
        $credentials = $request->only('email', 'password');
    
        // Limitar el número de intentos de inicio de sesión
        if (RateLimiter::tooManyAttempts($request->ip(), 5)) {
            return response()->json(['errors' => 'Demasiados intentos, reintentelo mas tarde.'], 429);
        }
    
        // Verificar las credenciales del usuario
        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($request->ip());
            return response()->json(['errors' => 'El email o la contraseña es incorrecta, intente nuevamente'], 401);
        }
    
        // Limpiar los intentos fallidos si el inicio de sesión es exitoso
        RateLimiter::clear($request->ip());
    
        $user = Auth::user();
    
        if ($user->tokens) $user->tokens()->delete();  

        $token = $user->createToken('auth_token')->plainTextToken;
        
    
        return response()->json([
            'message' => 'Inicio de sesiòn exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();

            return response()->json(
                ['message' => 'La sesiòn ha sido cerrada correctamente'],
                204
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['errors' => 'Ocurrio un error inesperado. Por favor, inténtelo de nuevo.', 'message' => $th->getMessage()],
                500
            );
        }
    }
}
