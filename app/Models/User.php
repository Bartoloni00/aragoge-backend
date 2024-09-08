<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        $user = [];
        $user['description'] = $professional->profession->description;
        $user['synopsis'] = $professional->profession->synopsis;
        $user['specialty_id'] = $professional->profession->specialty_id;
        $user['specialty_name'] = $professional->profession->specialty_name;

        return $user;
    }

}
