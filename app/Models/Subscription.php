<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'planning_id', 'subscription_date', 'expiration_date', 'is_active', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function planning()
    {
        return $this->belongsTo(Planning::class, 'planning_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'subscription_id');
    }

    public static function getSubscriptionsByUser(int $id)
    {
        $subscriptionsByUser = Subscription::whereHas('user', function($query) use ($id) {
            $query->where('id', $id);
        })
        ->with('payments')
        ->get()
        ->each(function($subscription) {
            // Ocultamos los campos 'id' y 'subscription_id' de cada pago
            $subscription->payments->each(function($payment) {
                $payment->makeHidden(['id', 'subscription_id']);
            });
        });
        return $subscriptionsByUser;
    }

    public static function getSubscriptionsByPlanningID(int $planning_id)
    {
        $subscriptionsByPlanning = Subscription::whereHas('planning', function($query) use ($planning_id) {
            $query->where('id', $planning_id);
        })->get();

        if ($subscriptionsByPlanning->count() < 1) return "Esta planificacion todavia no tiene ninguna subscripcion.";

        return $subscriptionsByPlanning;
    }

    public static function IsUserSuscriptedToPlanning(int $userId, int $planningId): bool
    {
        return self::where('user_id', $userId)
                    ->where('planning_id', $planningId)
                    ->exists();
    }
}
