<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $appends = ['specialty_name'];

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
        'description.required' => 'Description is a required fill',
        'synopsis.required' => 'Synopsis is a required fill',
        'specialty_id.required' => 'Specialty ID is required',
        'specialty_id.integer' => 'Specialty ID must be an integer',
        'specialty_id.in' => 'Specialty ID must be either 1, 2 or 3',
    ];

    public function profession()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Speciality::class, 'specialty_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'professional_id');
    }

    public function getSpecialtyNameAttribute()
    {
        return $this->specialty ? $this->specialty->name : null;
    }
}
