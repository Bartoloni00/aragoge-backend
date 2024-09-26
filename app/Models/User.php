<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ProfessionalUser;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $appends = ['rol_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'rol_id',
        'image_id',
        'professional_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        "email_verified_at",
        'rol',
        'profession'
    ];
    public const CREATE_RULES = [
        'first_name' => ['required', 'max:60'],
        'last_name' => ['required', 'max:60'],
        'email' => ['required', 'email'],
        'rol_id' => ['required', 'in:2,3'], // Acepta solo los valores 2 o 3
        'password' => [
            'required',
            'string', 
            'min:6', // Mínimo 6 caracteres
            'regex:/[a-z]/', // Debe contener al menos una letra minúscula
            'regex:/[A-Z]/', // Debe contener al menos una letra mayúscula
            'regex:/[0-9]/', // Debe contener al menos un número
        ]
    ];
    
    public const UPDATE_RULES = [
        'first_name' => ['max:60'],
        'last_name' => ['max:60'],
        'email' => ['email'],
        'rol_id' => ['in:2,3'],
    ];

    public const ERROR_MESSAGES = [
        'first_name.required' => 'El nombre es un campo obligatorio',
        'first_name.max' => 'El nombre puede tener un maximo de 60 caracteres',
        'last_name.required' => 'El apellido es un campo obligatorio',
        'last_name.max' => 'El apellido puede tener un maximo de 60 caracteres',
        'email.required' => 'Email es un campo obligatorio',
        'email.email' => 'El campo email debe ser un email válido',
        'rol_id.required' => 'El rol es un campo obligatorio',
        'rol_id.in' => 'Rol tiene que tener el valor 2 o 3',
        'password.required' => 'La contraseña es un campo obligatorio',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        'password.regex' => 'La contraseña debe contener al menos una letra minúscula, una letra mayúscula y un número',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function profession()
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');

    }

    public function getRolNameAttribute()
    {
        return $this->rol ? $this->rol->name : null;
    }

    public static function getAllUsersFiltered(string $rol)
    {
        $usersFiltered = User::whereHas('rol', function($query) use ($rol) {
            $query->where('name', $rol);
        })
        ->get();

        if ($rol == 'professional') {
            foreach ($usersFiltered as $user) {
                $user->professional_data = ProfessionalUser::addProfessionalData($user);
            }
        }

        return $usersFiltered;
    }

    public static function getUserByID(int $id)
    {
        $user = User::find($id);

        if ($user->rol_name == 'professional') {
            $user->professional_data = ProfessionalUser::addProfessionalData($user);
        }

        return $user;
    }

    public function hasRole($role)
    {
        return $this->rol->name === $role;
    }
}
