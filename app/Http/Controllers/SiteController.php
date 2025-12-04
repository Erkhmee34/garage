<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Order;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    // Хэрэглэгчийн машины жагсаалт
    public function myCars(Request $request)
    {
        $cars = Car::whereHas('customer', function($q) use($request) {
                    $q->where('phone', $request->phone);
                })
                ->with('customer')
                ->latest()
                ->get();

        return view('my-cars', compact('cars'));
    }

    // Захиалгын дэлгэрэнгүй
    public function orderDetail($id)
    {
        $order = Order::with(['car.customer', 'service'])->findOrFail($id);
        return view('order-detail', compact('order'));
    }
}