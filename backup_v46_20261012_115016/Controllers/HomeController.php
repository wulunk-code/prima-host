<?php

namespace App\Http\Controllers;

use App\Models\Banner;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Event;
use App\Models\Setting;
use App\Models\Member;
use App\Models\OrderItem;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        $products = $query->latest()->get();

        $banners = Banner::where('status', 'aktif')->latest()->get();

        $promotions = Promotion::where(
            'is_active',
            true
        )->latest()->get();

        $events = Event::where(
            'is_active',
            true
        )->latest()->get();

        $setting = Setting::first();

        $totalMembers = Member::count();

        $topProducts = OrderItem::selectRaw(
                'product_id, SUM(qty) as total_qty'
            )
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->take(8)
            ->get();

        return view('home', compact(
            'banners',
            'products',
            'promotions',
            'events',
            'setting',
            'totalMembers',
            'topProducts'
        ));
    }
}