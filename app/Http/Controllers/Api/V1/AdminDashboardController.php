<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminDashboardController extends Controller
{
    public function statistics(): JsonResponse
    {
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        if (! auth()->user()->hasRole($role)) {
            auth()->user()->assignRole($role);
        }

        return response()->json([
            'users' => User::count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'sales' => Order::sum('total'),
        ], 200);
    }
}
