<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function getPayments()
    {
        $payments = Payment::all();

        $data = [
            'data' => $payments,
            'status' => 200
        ];

        return response()->json($data,200);
    }

    public function getPaymentByID(int $id)
    {
        $payment = Payment::find($id);

        $data = [
            'data' => $payment,
            'status' => 200
        ];

        return response()->json($data,200);
    }
}
