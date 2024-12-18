<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Planning;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class Payment extends Model
{
    use HasFactory;

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

    public static function createPreference($planningId,$paymentId)
    {
        MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));

        $items = self::createPaymentItemsPreference($planningId);
        $payer = self::createPayer($paymentId);
        $request = self::createPreferenceRequest($items, $payer, $paymentId);

        $client = new PreferenceClient();

        try {
            $preference = $client->create($request);
            return $preference;
        } catch (MPApiException $error) {
            return null;
        }

    }

    private static function createPayer($paymentId): array
    {
        $payment = Payment::find($paymentId);
        $suscription = Subscription::find($payment->subscription_id);
        $user = User::find($suscription->user_id);
        $payer = array(
            "name"=> $user->first_name,
            "surname"=> $user->last_name,
            "email"=> $user->email,
        );
        return $payer;
    }

    private static function createPreferenceRequest($items, $payer, $paymentId): array
    {
        $paymentMethods = [
            "excluded_payment_methods" => [],
            "installments" => 12,
            "default_installments" => 1
        ];
    
        $backUrls = array(
            'success' => "https://ezequiel-arevalo.github.io/aragoge/",
            'failure' => "https://ezequiel-arevalo.github.io/aragoge/"
        );
    
        $request = [
            "items" => $items,
            "payer" => $payer,
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor"=> "Aragoge",
            "external_reference"=> $paymentId,
            "expires"=> false,
            "auto_return" => 'approved',
        ];
        return $request;
    }

    private static function createPaymentItemsPreference($planningId)
    {
        $planning = Planning::find($planningId);

        $item = array(
            "id" => $planning->id,
            "title" => $planning->title,
            "description" => $planning->description,
            "currency_id" => "ARS",
            "quantity" => 1,
            "unit_price" => $planning->price,
        );

        return $items = array($item);
    }
}