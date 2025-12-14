<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; // ← ЭНЭЭГ НЭМЭХ!!

class AdController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');

        $ads = Ad::latest();

        if ($search) {
            $ads->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($category) {
            $ads->where('category', $category);
        }

        $ads = $ads->with('user')->paginate(12); // user-г нэг удаа ачаална

        $categories = ['Guitars', 'Amps', 'Pedals', 'Accessories', 'Parts', 'Services'];

        return view('ads.index', compact('ads', 'categories', 'search', 'category'));
    }

    public function create()
    {
        $categories = ['Guitars', 'Amps', 'Pedals', 'Accessories', 'Parts', 'Services'];
        return view('ads.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string',
            'brand'       => 'nullable|string|max:100',
            'model'       => 'nullable|string|max:100',
            'year'        => 'nullable|string|max:10',
            'condition'   => 'nullable|in:New,Like New,Good,Fair,For Parts',
            'location'    => 'nullable|string|max:100',
            'price'       => 'nullable|numeric|min:0',
            'phone'       => 'nullable|string|max:20',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = $request->file('image')->store('ads', 'public');
        }

        Ad::create($data);

        return redirect('/ads')->with('success', 'Зар амжилттай оруулагдлаа!');
    }

    public function show(Ad $ad)
    {
        $ad->load('comments.user'); // сэтгэгдэл + хэрэглэгчийг нэг дор ачаална
        return view('ads.show', compact('ad'));
    }

    public function myAds()
    {
        $ads = auth()->user()->ads()->latest()->paginate(12);
        return view('ads.my', compact('ads'));
    }

    public function destroy(Ad $ad)
    {
        $this->authorize('delete', $ad);

        if ($ad->image) {
            Storage::disk('public')->delete($ad->image);
        }

        $ad->delete();

        return redirect('/my-ads')->with('success', 'Зар устгагдлаа!');
    }

    public function edit(Ad $ad)
    {
        $this->authorize('update', $ad);
        $categories = ['Guitars', 'Amps', 'Pedals', 'Accessories', 'Parts', 'Services'];
        return view('ads.edit', compact('ad', 'categories'));
    }

    public function update(Request $request, Ad $ad)
    {
        $this->authorize('update', $ad);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string',
            'brand'       => 'nullable|string|max:100',
            'model'       => 'nullable|string|max:100',
            'year'        => 'nullable|string|max:10',
            'condition'   => 'nullable|in:New,Like New,Good,Fair,For Parts',
            'location'    => 'nullable|string|max:100',
            'price'       => 'nullable|numeric|min:0',
            'phone'       => 'nullable|string|max:20',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($ad->image) {
                Storage::disk('public')->delete($ad->image);
            }
            $data['image'] = $request->file('image')->store('ads', 'public');
        }

        $ad->update($data);

        return redirect('/my-ads')->with('success', 'Зар амжилттай шинэчлэгдлээ!');
    }

    // LIKE ФУНКЦ – ЯГ ОДОО 100% АЖИЛЛАНА!
    public function like(Ad $ad)
    {
        // Нэвтрээгүй бол алдаа буцаана
        if (!Auth::check()) {
            return response()->json(['error' => 'Нэвтэрнэ үү'], 401);
        }

        $user = auth()->user();

        if ($ad->isLikedBy($user)) {
            $ad->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $ad->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $ad->likeCount()
        ]);
    }
}