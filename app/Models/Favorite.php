<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = "favorites";
    protected $fillable = ['user_id', 'product_id'];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Kiểm tra sản phẩm đã được yêu thích chưa.
     *
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public static function isFavorited(int $userId, int $productId)
    {
        return self::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->exists();
    }
}
