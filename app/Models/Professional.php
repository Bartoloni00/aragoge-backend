<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $appends = ['specialty_name'];

    public function profession()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Speciality::class, 'specialty_id');
    }

    public function getSpecialtyNameAttribute()
    {
        return $this->specialty ? $this->specialty->name : null;
    }
}
