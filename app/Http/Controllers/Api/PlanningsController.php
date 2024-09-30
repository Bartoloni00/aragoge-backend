<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planning;
use App\Models\ProfessionalUser;
use App\Models\Subscription;
use Illuminate\Http\Request;

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

    public function getSubscriptionsForThisPlanning(int $id)
    {
        $subscriptions = Subscription::getSubscriptionsByPlanningID($id);
        
        if ($subscriptions->count() < 1) {
            return response()->json(['errors' => 'No se encontraron subscripciones para esta planificacion', 'status_code' => 404], 404);
        }

        $data = [
            'data' => $subscriptions,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function delete(int $id)
    {
        $planning = Planning::find($id);
        //la validacion de esta planning se hizo en el middleware "ismyplanningmiddleware"

        $subscriptions = Subscription::getSubscriptionsByPlanningID($id);

        if (is_array($subscriptions) && $subscriptions->count() > 0) {
            return response()->json([
                'errors'=> 'No se puede eliminar una planificación con sus subscripciones',
                'status' => 400
            ],400);
        }

        $planning->delete();

        return response()->json(['message' => 'La planificación ha sido eliminada correctamente', 'status_code' => 204], 204);
    }
}
