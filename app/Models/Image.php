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

    public static function manipularImg(int $height, int $width,string $folder, $cover, null|string $image_alt = null, null|int $image_id = null)
    {
        $filename = time() . '.' . $cover->getClientOriginalExtension();
        $image = InterventionImage::read($cover);
        
        // Resize image
        $image->cover($height, $width)->save(storage_path('app/public/'. trim($folder) .'/' . $filename));
    
        if (!empty($image_id)) {
            $existingImage = Image::find($image_id);
            
            if ($existingImage) {
                // Elimina el archivo de imagen anterior físicamente si existe
                Storage::delete('public/'. trim($folder) .'/' . $existingImage->name);
                
                // Actualiza el registro en la base de datos
                $existingImage->update([
                    'name' => $filename,
                    'alt' => $image_alt ?? 'Imagen de portada',
                    'updated_at' => now()
                ]);
                
                return $existingImage;
            }
        } else {
            // Crea un nuevo registro si no se proporcionó $image_id o si no se encontró la imagen
            return Image::create([
                'name' => $filename,
                'alt' => $image_alt ?? 'Imagen de portada',
                'created_at' => now()
            ]);
        }
    }

    public static function deleteImage($folder, $image_id)
    {
        $image = Image::find($image_id);
        Storage::delete('public/'. trim($folder) .'/' . $image->name);
        $image->delete();
    }
}
