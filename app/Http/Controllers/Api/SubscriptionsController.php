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

    public function subscripting(Request $request,int $planningId){
        $planning = Planning::find($planningId);

        if(!$planning) return response()->json(['errors'=> 'NO se ha encontrado la planificacion solicitada'], 404);

        return response()->json(['planning id'=> $planning], 200);
    }
}
