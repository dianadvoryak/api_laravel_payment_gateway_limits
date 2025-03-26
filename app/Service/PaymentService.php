<?php

namespace App\Service;

use App\Models\Payment;
use App\Models\PaymentGatewayLimit;

class PaymentService 
{
    public function store($request)
    {
        $gatewayId = $request->input('gateway_id');

        $gatewayLimit = PaymentGatewayLimit::where('gateway_id', $gatewayId)->first();

        if (!$gatewayLimit) {
            return response()->json(['error' => 'Лимит для данного шлюза не установлен'], 400);
        }

        $gatewayLimit = $gatewayLimit->checkAndUpdateLimit();

        if ($gatewayLimit->used_amount + $amount > $gatewayLimit->limit) {
            return response()->json(['error' => 'Превышен лимит для данного шлюза'], 400);
        }

        $data = $request->all();

        if ($data['type'] == 'SBERBANK') {
            unset($data['type']);
            unset($data['sign']);
            unset($data['gateway_id']);
        
            ksort($data);
    
            $implode = implode(':', $data);
    
            $implode .= 'merchant_key';
    
            $hash = hash('sha256', $implode);

            Payment::create([
                'hash_sign' => $hash, 
            ]);

        } else {
            unset($data['type']);
            unset($data['sign']);
            unset($data['gateway_id']);
        
            ksort($data);
    
            $implode = implode('.', $data);
    
            $implode .= 'app_key';
    
            $hash = hash('md5', $implode);

            Payment::create([
                'hash_sign' => $hash, 
            ]);
        }

        $gatewayLimit->increment('used_amount', $amount);

        return response()->json(['success' => 'Платеж успешно проведен']);
    }

}
