<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Planning;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function getSubscriptions()
    {
        $subscriptions = Subscription::with('payments')->get();

        $data = [
            'data' => $subscriptions,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function getSubscriptionByID(int $id)
    {
        $subscription = Subscription::with('payments')->findOrFail($id);

        if (!$subscription) {
            return response()->json([
                'errors'=> 'La subscripción no fue encontrada',
                'status' => 404
            ],404);
        }

        $data = [
            'data' => $subscription,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function subscripting(Request $request,int $planningId)
    {
        // en el middleware verificamos que la planificacion exista
        try {
            $subscription = Subscription::create([
                'user_id' => $request->user()->id,
                'planning_id' => $planningId,
                'subscription_date' => date('Y-m-d'),
                'expiration_date' => date('Y-m-d', strtotime('+1 month')),
                'is_active' => 1,
                'created_at' => now(),
            ]);
    
            return response()->json(['data'=> $subscription], 201);
        } catch (\Throwable $th) {
            return response()->json(['errors'=> 'Algo salio mal, no fue posible crear la subscripcion', 'error' => $th], 500);

        }
    }

    public function renewSubscription(Request $request, int $planningId)
    {
        try {
            $user_id = $request->user()->id;

            // Renovamos la suscripcion por 30 dias mas
            $subscription = Subscription::renew($user_id, $planningId);
    
            return response()->json(['data'=> $subscription], 201);
        } catch (\Throwable $th) {
            return response()->json(['errors'=> 'Algo salio mal, no fue posible renovar la subscripcion', 'error' => $th], 500);
        }
    }
}
