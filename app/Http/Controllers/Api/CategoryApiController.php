<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::active()
            ->with(['children', 'parent'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
        
        return response()->json([
            'data' => $categories,
            'total' => $categories->count()
        ]);
    }

    public function show($id)
    {
        $category = Category::with(['children', 'products' => function($q) {
            $q->active()->inStock();
        }])->findOrFail($id);
        
        return response()->json($category);
    }
}

