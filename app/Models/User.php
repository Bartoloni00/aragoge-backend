<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
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
    
    public const ERROR_MESSAGES = [
        'first_name.required' => 'First name is a required fill',
        'first_name.max' => 'First name max length: 60',
        'last_name.required' => 'Last name is a required fill',
        'last_name.max' => 'Last name max length: 60',
        'email.required' => 'Email is required',
        'email.email' => 'This must be an email',
        'rol_id.required' => 'Role ID is required',
        'rol_id.in' => 'Role ID must be either 2 or 3', // Para los valores permitidos de rol
        'password.required' => 'Password is required',
        'password.min' => 'Password must have at least 6 characters',
        'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number',
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
                $user->professional_data = User::addProfessionalData($user);
            }
        }

        return $usersFiltered;
    }

    public static function getUserByID(int $id)
    {
        $user = User::findOrFail($id);

        if ($user->rol_name == 'professional') {
            $user->professional_data = User::addProfessionalData($user);
        }

        return $user;
    }
    private static function addProfessionalData(User $professional): array
    {
       if ($professional->profession) {
        $user = [];
        $user['description'] = $professional->profession->description;
        $user['synopsis'] = $professional->profession->synopsis;
        $user['specialty_id'] = $professional->profession->specialty_id;
        $user['specialty_name'] = $professional->profession->specialty_name;

        return $user;
       } else {
        return  ['This professional dont have a profile yet'];
       }
    }


    public function hasRole($role)
    {
        return $this->rol->name === $role;
    }
}
