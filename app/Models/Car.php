<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;
    use SoftDeletes; // ← soft delete идэвхтэй

    // Чиний алдаа эндээс болж гарч байсан – Laravel 8.1 дээр withoutTrashed() байхгүй
    // Тиймээс бид өөрсдөө global scope нэмж өгнө
    protected static function booted()
    {
        static::addGlobalScope(fn($query) => $query->whereNull('deleted_at'));
    }

    protected $fillable = [
        'plate_number',
        'brand',
        'model',
        'year',
        'image',
        'customer_id',
    ];

    protected $appends = ['image_url'];

    // Зурагны URL-ийг авах
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Үйлчлүүлэгчтэй холбох
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}