<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // 
use App\Models\Like;
use App\Models\Comment;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'price',
        'phone',
        'user_id',
        'image',
    ];

    // Зарын эзэн
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Like систем
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Хэрэглэгч like дарсан эсэхийг шалгах
    public function isLikedBy(?User $user)
    {
        if (! $user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Like-ын тоо
    public function likeCount()
    {
        return $this->likes()->count();
    }

    // Сэтгэгдэл систем
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}   