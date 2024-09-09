<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

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
        return $this->hasMany(Purchase::class, 'subscription_id');
    }

    public static function getSubscriptionsByUser(int $id)
    {
        $subscriptionsByUser = Subscription::whereHas('user', function($query) use ($id) {
            $query->where('id', $id);
        })
        ->get();

        return $subscriptionsByUser;
    }
}
