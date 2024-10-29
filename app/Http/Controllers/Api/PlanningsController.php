<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planning;
use App\Models\ProfessionalUser;
use App\Models\Subscription;
use App\Models\Category;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;


class PlanningsController extends Controller
{
    public function getPlannings(Request $request)
    {
        $queryParams = $request->only(['category','min_price','max_price']);

        // Aplicamos el filtro por categoría, si existe
        if (!empty($queryParams['category'])) {
        // Usamos tu método personalizado para filtrar por categoría
        $plannings = Planning::getPlanningsByCategoryFiltered($queryParams['category']);
        
        // Si no se encuentran plannings por categoría, devolvemos un error
        if ($plannings->count() < 1) {
            return response()->json(['errors' => 'Las planificaciones no fueron encontradas', 'status_code' => 404], 404);
        }
        } else {
            // Si no hay filtro de categoría, obtenemos todos los plannings
            $plannings = Planning::all();
        }

        // Filtrar por rango de precios
        if (!empty($queryParams['min_price']) || !empty($queryParams['max_price'])) {
            // Si ya tenemos plannings filtrados por categoría, continuamos filtrando sobre ellos
            $plannings = $plannings->filter(function($planning) use ($queryParams) {
                $minPrice = $queryParams['min_price'] ?? 0;  // Si no existe min_price, usar 0
                $maxPrice = $queryParams['max_price'] ?? INF; // Si no existe max_price, usar infinito

                return $planning->price >= $minPrice && $planning->price <= $maxPrice;
            });
            
            // Verificamos si después del filtro quedan resultados
            if ($plannings->count() < 1) {
                return response()->json(['errors' => 'Plannings Not Found', 'status_code' => 404], 404);
            }
        }

        $data = [
            'data' => $plannings,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function getPlanningByID(int $id)
    {
        $planning = Planning::find($id);

        if (!$planning) {
            return response()->json([
                'errors'=> 'La planificación no fue encontrada',
                'status' => 404
            ],404);
        }

        $data = [
            'data' => $planning,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function getSubscriptionsForThisPlanning(int $Id)
    {
        $subscriptions = Subscription::getSubscriptionsByPlanningID($Id);
        
        if (is_string($subscriptions) || $subscriptions->count() < 1) {
            return response()->json(['errors' => 'No se encontraron subscripciones para esta planificacion', 'status_code' => 404], 404);
        }

        $data = [
            'data' => $subscriptions,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function getImageForThisPlanning(int $id)
    {
        $planning = Planning::find($id);
        $image = Image::find($planning->image_id);

        if (!$image) {
            return response()->json([
                'errors' => 'No se encontró la imagen de la planificación',
                'status_code' => 404
            ], 404);
        }

        $path = storage_path('app/public/plannings/' . $image->name);
        // Obtener el contenido de la imagen
        $file = file_get_contents($path);

        // Determinar el tipo MIME de la imagen
        $type = mime_content_type($path);

        // Retornar la imagen con el encabezado de tipo MIME
        return response($file, 200)->header('Content-Type', $type);
    }

    public function create(Request $request)
    {
       try {
            DB::beginTransaction();

            $request->validate(Planning::CREATE_RULES, Planning::ERROR_MESSAGES);

            if(!Category::isValidCategoryId($request->category_id)) {
                return response()->json([
                    'errors' => [
                        'category_id' => [
                            'Debes asignar una categoría válida'
                        ]
                    ], 
                    'status_code' => 422
                ], 422);
            }
            

            $dataPlanning = $request->only(keys: [
                'title',
                'description',
                'synopsis',
                'price',
                'category_id',
                'cover',
                'cover_alt'
            ]);

            $dataPlanning['create_at'] = now();
            $dataPlanning['updated_at'] = now();

            $user = User::find($request->user()->id);

            $dataPlanning['professional_id'] = $user->professional_id;

            if($request->hasFile('cover')){
                $cover = $request->file('cover');
                $dataPlanning['cover_alt'] = $dataPlanning['cover_alt'] ?? 'Imagen de portada';
                
                $image = Image::manipularImgPlanning($cover, $dataPlanning['cover_alt']);
                $dataPlanning['image_id'] = $image->id;
            }

            $planning = Planning::create(attributes: $dataPlanning);

            DB::commit();

            return response()->json(data: [
                'message' => 'La planificación ha sido creada correctamente', 
                "data" => $planning
            ], status: 201);

       } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(data: [
                'errors' => $e->errors()
            ], status: 422);

        } catch (\Throwable $th) {
            DB::rollBack();
    
            return response()->json(data: [
                'message' => 'Ocurrio un error inesperado. Por favor, inténtelo de nuevo.',
                'errors' => $th->getMessage()
            ], status: 500);
        }
    }

    public function update(Request $request, int $id)
    {
        $planning = Planning::find($id);
        //la validacion de esta planning se hizo en el middleware "ismyplanningmiddleware"
        
        $request->validate(Planning::UPDATE_RULES, Planning::ERROR_MESSAGES);
        
        $dataPlanning = $request->only(keys: [
            'title',
            'description',
            'synopsis',
            'price',
            'category_id',
            'cover',
            'cover_alt'
        ]);

        if($request->category_id && !Category::isValidCategoryId($request->category_id)) {
            return response()->json([
                'errors' => [
                    'category_id' => [
                        'Debes asignar una categoría válida'
                    ]
                ], 
                'status_code' => 422
            ], 422);
        }
        
        $dataPlanning['updated_at'] = now();
        // Si la planificacion posee una images y el usuario esta enviandonos otra imagen para editar hacemos esto
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $dataPlanning['cover_alt'] = $dataPlanning['cover_alt'] ?? 'Imagen de portada';
                
            $image = Image::manipularImgPlanning($cover, $dataPlanning['cover_alt'], $planning->image_id ?? null);
            $dataPlanning['image_id'] = $image->id;
        }

        $planning->update($dataPlanning);
        
        return response()->json(data: [
            'message' => 'La planificación ha sido actualizada correctamente', 
            "data" => $planning
        ], status: 200);
    }

    public function delete(int $id)
    {
        $planning = Planning::find($id);
        // La validación de esta planificación se hizo en el middleware "ismyplanningmiddleware"
        try {
            $planning->delete();
            return response()->json(['message' => 'La planificación ha sido eliminada correctamente', 'status_code' => 204], 204);

        } catch (QueryException $e) {
            // Captura el error de integridad referencial (código 23000)
            if ($e->getCode() === '23000') {
                return response()->json([
                    'errors' => 'No se puede eliminar una planificación que posee suscripciones',
                    'status' => 400
                ], 400);
            }
    
            return response()->json([
                'errors' => 'Ocurrio un error inesperado. Por favor, inténtelo de nuevo.',
                'status_code' => 500
            ], 500);
        }
    }
}
