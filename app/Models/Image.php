<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

class Image extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'alt',
        'created_at',
        'updated_at'
    ];

    public static function manipularImgPlanning($cover, null|string $image_alt = null, null|int $image_id = null)
    {

        $filename = time() . '.' . $cover->getClientOriginalExtension();
        $image = InterventionImage::read($cover);
        // Resize image
        $image->resize(300, 300, function ($constraint) {
            $constraint->upsize();
        })->save(storage_path('app/public/plannings/' . $filename));

        if(!empty($image_id)){
            $image = Image::find($image_id);
            // eliminar la imagen anterior fisicamente y editar la url de la imagen de la base de datos por la nueva
            $image->delete();
            // Parece que no se crea agrega la imagen a la DDBB y por lo tanto se rompe todo el sistema
            $image = Image::create([
                'name' => $filename,
                'alt' => $image_alt ?? 'Imagen de portada',
                'updated_at' => now()
            ]);
            return $image;
        } else {
            $image = Image::create([
                'name' => $filename,
                'alt' => $image_alt ?? 'Imagen de portada',
                'created_at' => now()
            ]);
            return $image;
        }
    }
}
