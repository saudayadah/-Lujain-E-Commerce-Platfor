<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Toggle المنتج في قائمة الرغبات
     */
    public static function toggle(int $userId, int $productId): array
    {
        $exists = self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($exists) {
            $exists->delete();
            return [
                'action' => 'removed',
                'message' => 'تم الحذف من قائمة الرغبات',
                'in_wishlist' => false,
            ];
        }

        self::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return [
            'action' => 'added',
            'message' => 'تم الإضافة لقائمة الرغبات',
            'in_wishlist' => true,
        ];
    }

    /**
     * التحقق من وجود المنتج في قائمة رغبات المستخدم
     */
    public static function isInWishlist(int $userId, int $productId): bool
    {
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    /**
     * عدد المنتجات في قائمة رغبات المستخدم
     */
    public static function countForUser(int $userId): int
    {
        return self::where('user_id', $userId)->count();
    }
}
