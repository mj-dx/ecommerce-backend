<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $coupon = Coupon::create($request->only(['code', 'type', 'value', 'expires_at', 'usage_limit']));

        return response()->json(['message' => 'Coupon created', 'coupon' => $coupon], 201);
    }
}
