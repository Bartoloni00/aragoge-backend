<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Payment;

class ValidatePayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->has('paymentId') || !$request->has('preferenceId')){
            return response()->json([
                'message' => 'Faltan parámetros para validar el pago.',
            ], 400);
        }

        $paymentId = $request->input('paymentId');
        $preferenceId = $request->input('preferenceId');

        $payment = Payment::find($request->route('payment_id'));
        if (!$payment) {
            return response()->json([
                'message' => 'El pago no fue encontrado.',
            ], 400);
        }

        if ($payment->preference_id != null) {
            return response()->json([
                'message' => 'El pago ya ha sido validado.',
            ], 208);
        }
        try {
            $payment::validatePayment($paymentId, $preferenceId);
            next($request);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 400);
        }
    }
}
