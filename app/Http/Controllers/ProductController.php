<?php

namespace App\Http\Controllers;

use App\Models\BodyPart;
use App\Models\Category;
use App\Models\Product;
use App\Models\SkeletonPart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        $bodyParts = BodyPart::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $query = Product::where('is_active', true)
            ->with(['category', 'bodyPart', 'media']);

        // Filter by category
        if ($categoryId = $request->get('category')) {
            $query->where('category_id', $categoryId);
        }

        // Filter by body part
        if ($bodyPartId = $request->get('body_part')) {
            $query->where('body_part_id', $bodyPartId);
        }

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("JSON_EXTRACT(title, '$.hy') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(title, '$.ru') LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("JSON_EXTRACT(title, '$.en') LIKE ?", ["%{$search}%"]);
            });
        }

        $products = $query->orderBy('sort_order')->get();

        $selectedCategory = $categoryId ? Category::find($categoryId) : null;
        $selectedBodyPart = $bodyPartId ? BodyPart::find($bodyPartId) : null;

        // Skeleton tooltip data — keyed by svg_element_id
        $skeletonParts = SkeletonPart::forFrontend();

        return view('products.index', compact(
            'categories', 'bodyParts', 'products',
            'selectedCategory', 'selectedBodyPart', 'skeletonParts'
        ));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'bodyPart', 'media']);

        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        $bodyParts = BodyPart::where('is_active', true)->orderBy('sort_order')->get();

        $gallery = $product->getMedia('gallery');

        // Skeleton tooltip data — keyed by svg_element_id
        $skeletonParts = SkeletonPart::forFrontend();

        return view('products.show', compact('product', 'categories', 'bodyParts', 'gallery', 'skeletonParts'));
    }
}
