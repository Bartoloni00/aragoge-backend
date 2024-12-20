<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Speciality;
use App\Models\Planning;

class Professional extends Model
{
    use HasFactory;

    protected $appends = ['specialty_name', 'user_id'];

    protected $fillable = [
        'description',
        'synopsis',
        'specialty_id',
        'created_at',
        'updated_at'
    ];

    public const UPDATE_RULES = [
        'description' => ['string'],
        'synopsis' => ['string'],
        'specialty_id' => ['integer', 'in:1,2,3'],
    ];

    public const ERROR_MESSAGES = [
        'description.required' => 'Descripcion es un campo obligatorio',
        'synopsis.required' => 'Sinopsis es un campo obligatorio',
        'specialty_id.required' => 'La especialidad es un campo obligatorio',
        'specialty_id.integer' => 'La especialidad tiene que tener un valor numerico',
        'specialty_id.in' => 'La especialidad tiene que ser un valor: 1, 2 o 3',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'professional_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Speciality::class, 'specialty_id');
    }

    public function plannings()
    {
        return $this->hasMany(Planning::class);
    }

    // Accesor para obtener el nombre de la especialidad
    public function getSpecialtyNameAttribute()
    {
        return $this->specialty ? $this->specialty->name : null;
    }

    // Accesor para obtener el ID del usuario
    public function getUserIdAttribute()
    {
        return $this->user ? $this->user->id : null;
    }

    public static function createDefaultProfessionalProfile()
    {
        return Professional::create([
            'description' => 'Este perfil profesional todavia no posee una descripcion',
            'synopsis' => 'Perfil profesional sin descripcion',
            'specialty_id' => 4,
            'created_at' => now(),
            'updated_at' => now(), 
        ]);
    }
}
