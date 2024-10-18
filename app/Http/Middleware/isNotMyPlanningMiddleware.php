<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Planning;
use App\Models\ProfessionalUser;

class isNotMyPlanningMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtén el parámetro 'id' desde la URI
        $idParam = $request->route('planningId');

        $planning = Planning::find($idParam);

        if (!$planning) {
            return response()->json([
                'errors'=> 'La planificación no fue encontrada',
                'status' => 404
            ],404);
        }
        if ($request->user()->rol->name === 'professional') {
            
            // Negamos la condicion
            if(!ProfessionalUser::isMyPlanning($request->user()->id, $planning->id)) return $next($request);
            
            return response()->json(['errors' => 'No puedes suscribirte a una planificacion que te pertenece', 'status_code' => 403], 403);
        }

        return $next($request);
    }
}
