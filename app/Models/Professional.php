<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Speciality;

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

    public const CREATE_RULES = [
        'description' => ['required'],
        'synopsis' => ['required'],
        'specialty_id' => ['required', 'integer', 'in:1,2,3'],
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
}
