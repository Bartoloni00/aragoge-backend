<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;
use Illuminate\Support\Facades\Storage;

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
    
        if (!empty($image_id)) {
            $existingImage = Image::find($image_id);
            
            if ($existingImage) {
                // Elimina el archivo de imagen anterior físicamente si existe
                Storage::delete('public/plannings/' . $existingImage->name);
                
                // Actualiza el registro en la base de datos
                $existingImage->update([
                    'name' => $filename,
                    'alt' => $image_alt ?? 'Imagen de portada',
                    'updated_at' => now()
                ]);
                
                return $existingImage;
            }
        }
        
        // Crea un nuevo registro si no se proporcionó $image_id o si no se encontró la imagen
        return Image::create([
            'name' => $filename,
            'alt' => $image_alt ?? 'Imagen de portada',
            'created_at' => now()
        ]);
    }
}
