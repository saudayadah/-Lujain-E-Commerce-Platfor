<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * عرض قائمة الرغبات
     */
    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * إضافة/إزالة منتج من قائمة الرغبات (Toggle)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً',
                'redirect' => route('login'),
            ], 401);
        }

        $result = Wishlist::toggle(auth()->id(), $request->product_id);

        return response()->json([
            'success' => true,
            'action' => $result['action'],
            'message' => $result['message'],
            'in_wishlist' => $result['in_wishlist'],
            'count' => Wishlist::countForUser(auth()->id()),
        ]);
    }

    /**
     * حذف منتج من قائمة الرغبات
     */
    public function destroy(Wishlist $wishlist)
    {
        // التحقق من أن المنتج يخص المستخدم الحالي
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->delete();

        return redirect()->route('wishlist.index')
            ->with('success', 'تم حذف المنتج من قائمة الرغبات');
    }

    /**
     * نقل جميع المنتجات من قائمة الرغبات إلى السلة
     */
    public function moveAllToCart()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($wishlists->isEmpty()) {
            return redirect()->route('wishlist.index')
                ->with('info', 'قائمة الرغبات فارغة');
        }

        $cartService = app(\App\Services\CartService::class);
        $addedCount = 0;

        foreach ($wishlists as $wishlist) {
            if ($wishlist->product && $wishlist->product->isInStock()) {
                $cartService->addItem($wishlist->product->id, 1);
                $wishlist->delete();
                $addedCount++;
            }
        }

        if ($addedCount > 0) {
            return redirect()->route('cart.index')
                ->with('success', "تم نقل {$addedCount} منتج إلى السلة");
        }

        return redirect()->route('wishlist.index')
            ->with('error', 'لا توجد منتجات متاحة للنقل');
    }

    /**
     * عدد المنتجات في قائمة الرغبات (للـ AJAX)
     */
    public function count()
    {
        $count = auth()->check() 
            ? Wishlist::countForUser(auth()->id()) 
            : 0;

        return response()->json(['count' => $count]);
    }
}
