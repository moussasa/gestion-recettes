<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Models\Order;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $company = CompanySetting::first();

        $stats = [
            'recipesCount' => Recipe::count(),
            'usersCount' => User::count(),
            'ordersCount' => Order::count(),
            'reviewsCount' => Review::count(),
        ];

        $recentOrders = Order::with(['cart', 'cart.items'])
            ->latest()
            ->take(5)
            ->get();

        $recentReviews = Review::with(['recipe', 'user'])
            ->latest()
            ->take(3)
            ->get();

        return view('admin.dashboard', compact('stats','company', 'recentOrders', 'recentReviews'));
    }
}