<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class Payment extends Model
{
    use HasFactory;

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    protected $fillable = [
        'total_price',
        'preference_id',
        'payment_id',
        'payment_status',
        'subscription_id',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public static function validatePayment(string $paymentId, string $preferenceId): bool
    {
        // Consultar la API de Mercado Pago
        $url = "https://api.mercadopago.com/v1/payments/{$paymentId}";
        $accessToken = config('mercadopago.accessToken');

        try {
            $response = Http::withToken($accessToken)->get($url);
    
            if ($response->status() === 404) throw new Exception("El payment_id proporcionado no existe en Mercado Pago.", 404);

            if ($response->failed()) throw new Exception("Error de conexión con Mercado Pago: {$response->status()}", 1);
    
            $paymentData = $response->json();
    
            // Validar que el estado del pago sea aprobado
            if (!isset($paymentData['status']) || $paymentData['status'] !== 'approved') {
                $status = $paymentData['status'] ?? 'desconocido';
                throw new Exception("El estado del pago no es 'approved'. Estado actual: {$status}", 2);
            }
    
            // Validar que el preference_id coincida
            if (!isset($paymentData['preference_id']) || $paymentData['preference_id'] !== $preferenceId) {
                $receivedPreferenceId = $paymentData['preference_id'] ?? 'no proporcionado';
                throw new Exception("El preference_id no coincide. Recibido: {$receivedPreferenceId}", 3);
            }
    
            return "Validación exitosa. El pago es válido.";
        } catch (\Exception $e) {
            throw new Exception("Error inesperado al validar el pago: {$e->getMessage()}", 4);
        }
    }
}
