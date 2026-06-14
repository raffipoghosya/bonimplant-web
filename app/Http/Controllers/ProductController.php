<?php

namespace App\Http\Controllers;

use App\Models\BodyPart;
use App\Models\Category;
use App\Models\Product;
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
            ->with(['category', 'bodyParts', 'media']);

        // Filter by category
        if ($categoryId = $request->get('category')) {
            $query->where('category_id', $categoryId);
        }

        // Filter by body part
        if ($bodyPartId = $request->get('body_part')) {
            $query->whereHas('bodyParts', fn ($q) => $q->where('body_parts.id', $bodyPartId));
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

        $locale = app()->getLocale();
        $skeletonParts = BodyPart::where('is_active', true)
            ->whereNotNull('svg_element_ids')
            ->get()
            ->flatMap(function ($bp) use ($locale) {
                $name = $bp->getTranslation('name', $locale) ?: $bp->getTranslation('name', 'en');
                $ids = $bp->svg_element_ids ?? [];
                $mapped = [];
                foreach ($ids as $svgId) {
                    $mapped[$svgId] = ['name' => $name, 'body_part_id' => $bp->id];
                }
                return $mapped;
            })
            ->toArray();

        return view('products.index', compact(
            'categories', 'bodyParts', 'products',
            'selectedCategory', 'selectedBodyPart', 'skeletonParts'
        ));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'bodyParts', 'media']);

        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        $bodyParts = BodyPart::where('is_active', true)->orderBy('sort_order')->get();

        $gallery = $product->getMedia('gallery');

        $locale = app()->getLocale();
        $skeletonParts = BodyPart::where('is_active', true)
            ->whereNotNull('svg_element_ids')
            ->get()
            ->flatMap(function ($bp) use ($locale) {
                $name = $bp->getTranslation('name', $locale) ?: $bp->getTranslation('name', 'en');
                $ids = $bp->svg_element_ids ?? [];
                $mapped = [];
                foreach ($ids as $svgId) {
                    $mapped[$svgId] = ['name' => $name, 'body_part_id' => $bp->id];
                }
                return $mapped;
            })
            ->toArray();

        return view('products.show', compact(
            'product', 'categories', 'bodyParts', 'gallery', 'skeletonParts'
        ));
    }
}
