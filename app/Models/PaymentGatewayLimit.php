<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGatewayLimit extends Model
{
    protected $fillable = ['gateway_id', 'limit', 'used_amount', 'reset_at'];

    public function gateway()
    {
        return $this->belongsTo(Payment::class);
    }

    public function checkAndUpdateLimit()
    {
        $currentDate = now()->toDateString();

        if (!$this->reset_at || $this->reset_at->toDateString() !== $currentDate) {
            $this->update([
                'used_amount' => 0,
                'reset_at' => now()->endOfDay(),
            ]);
        }

        return $this;
    }
}