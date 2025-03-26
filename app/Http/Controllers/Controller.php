<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use OpenApi\Attributes as OA;

#[OA\Info(title: "API", version: "1.0.0")]
#[OA\Server(url: "/api/", description: "Base API URL")]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer"
)]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
