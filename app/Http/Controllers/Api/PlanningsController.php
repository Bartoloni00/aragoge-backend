<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planning;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PlanningsController extends Controller
{
    public function getPlannings()
    {
        $plannings = Planning::all();

        $data = [
            'data' => $plannings,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function getPlanningByID(int $id)
    {
        $planning = Planning::findOrFail($id);

        $data = [
            'data' => $planning,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }

    public function getSubscriptionsForThisPlanning(int $id)
    {
        $subscriptions = Subscription::getSubscriptionsByPlanningID($id);

        $data = [
            'data' => $subscriptions,
            'status_code' => 200
        ];

        return response()->json($data,200);
    }
}
