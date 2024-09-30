<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Planning;
use App\Models\ProfessionalUser;

class IsMyPlanningMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtén el parámetro 'id' desde la URI
        $idParam = $request->route('id');

        $planning = Planning::find($idParam);

        if (!$planning) {
            return response()->json([
                'errors'=> 'La planificación no fue encontrada',
                'status' => 404
            ],404);
        }

        if(ProfessionalUser::isMyPlanning($request->user()->id, $planning->id)) return $next($request);
        
        return response()->json(['errors' => 'No tienes permisos para acceder a esta planificacion', 'status_code' => 403], 403);
    }
}
