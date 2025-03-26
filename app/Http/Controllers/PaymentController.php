<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Service\PaymentService;

#[OA\Post(path: "/callback_url/", summary: "callback url", tags: ["payment"])]
#[OA\RequestBody(
    required: true,
    content: new OA\MediaType(
        mediaType: 'application/json',
        schema: new OA\Schema(
            type: 'object',
            properties: [
                new OA\Property(property: "type", type: "string", example: "SBERBANK"),
                new OA\Property(property: "merchant_id", type: "integer", example: 6),
                new OA\Property(property: "payment_id", type: "integer", example: 13),
                new OA\Property(property: "status", type: "string", example: "completed"),
                new OA\Property(property: "amount", type: "integer", example: 500),
                new OA\Property(property: "amount_paid", type: "integer", example: 500),
                new OA\Property(property: "timestamp", type: "integer", example: 1654103837),
                new OA\Property(property: "sign", type: "string", example: "f027612e0e6cb321ca161de060237eeb97e46000da39d3add08d09074f931728"),
            ]
        )
    )
)]
#[OA\Response(
    response: 201,
    description: "Successful operation",
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: "success", type: "string", example: "Платеж успешно проведен"),
        ]
    )
)]
class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {
    }

    public function store(Request $request)
    {
        return $this->paymentService->store($request); 
    }
}