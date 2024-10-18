<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Subscription;

class IsSubscritedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $pass): Response
    {
        $planningId = $request->route('planningId');
        $userId = $request->user()->id;

        /**
         * El parametro $pass puede ser 'true' o 'false'
         * 'true' su utiliza en los casos que necesitemos que el usuario este suscrito a la planificacion.
         * ejemplo: actualizar suscripcion o cancelarla.
         * 
         * 'false' su utiliza en los casos que necesitemos que el usuario no este suscrito a la planificacion.
         * ejemplo: suscribirse a una planificacion.
         */
        if ($pass == 'false') {
            if (Subscription::IsUserSuscriptedToPlanning($userId, $planningId)) {
                return response()->json(['errors' => 'Ya estas suscrito a esta planificacion'], 403);
            }else{
                return $next($request);
            }
        } else {
            if (!Subscription::IsUserSuscriptedToPlanning($userId, $planningId)) {
                return response()->json(['errors' => 'No estas suscrito a esta planificacion'], 403);
            }else{
                return $next($request);
            }
        }
    }
}
