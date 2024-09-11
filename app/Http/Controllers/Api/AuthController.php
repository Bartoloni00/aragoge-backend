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

            User::create(attributes: $dataUser);

            DB::commit();

            return response()->json(data: ['message' => 'User with email: '. $dataUser['email'] . ' has created succesfully' ], status: 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(data: [
                'errors' => $e->errors()
            ], status: 422);
    
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            if ($e->getCode() == 23000) return response()->json(data: ['message' => 'It looks like this email is already registered. Please use a different one.', 400]);

            return response()->json(data: [
                'message' => 'Database error occurred.',
                'error' => $e->getMessage()
            ], status: 500);
        } catch (\Throwable $th) {
            DB::rollBack();
    
            return response()->json(data: [
                'message' => 'Unexpected error occurred. Please try again later.',
                'error' => $th->getMessage()
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
            return response()->json(['error' => 'Too many attempts. Try again later.'], 429);
        }
    
        // Verificar las credenciales del usuario
        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($request->ip());
            return response()->json(['error' => 'Email or password is incorrect, try again'], 401);
        }
    
        // Limpiar los intentos fallidos si el inicio de sesión es exitoso
        RateLimiter::clear($request->ip());
    
        $user = Auth::user();
    
        if ($user->tokens) $user->tokens()->delete();  

        $token = $user->createToken('auth_token')->plainTextToken;
        
    
        return response()->json([
            'message' => 'Successful login',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json(
            ['message' => 'succesfull logout'],
            204
        );
    }
}
