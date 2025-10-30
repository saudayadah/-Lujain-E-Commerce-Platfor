<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('category');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%")
                  ->orWhere('description_ar', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->has('in_stock')) {
            if ($request->in_stock === 'true' || $request->in_stock === '1') {
                $query->where('stock', '>', 0);
            }
        }
        
        // Apply pagination with max limit to prevent performance issues
        $perPage = min((int) $request->get('per_page', 20), 100);
        $products = $query->paginate($perPage);
        
        return response()->json([
            'data' => $products->items(),
            'current_page' => $products->currentPage(),
            'per_page' => $products->perPage(),
            'total' => $products->total(),
        ]);
    }

    public function show($id)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($id);
        
        return response()->json($product);
    }
}

