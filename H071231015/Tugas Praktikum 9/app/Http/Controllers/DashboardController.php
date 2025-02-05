<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index(): View
    {
        if (Auth::user()->role === 'admin') {
            $stats = [
                'total_products' => Product::count(),
                'products_value' => Product::sum('price'),
                'available_products' => Product::where('stock', '>', 0)->count(),
                'products' => Product::latest()->take(5)->get()
            ];
            return view('dashboard.admin', compact('stats'));
        } else {
            $products = Product::where('stock', '>', 0)
                ->orderBy('name')
                ->paginate(10);
            
            return view('dashboard.user', compact('products'));
        }
    }
}