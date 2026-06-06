<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Category;
use App\Models\News;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::instance();

        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $news = News::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->limit(8)
            ->get();

        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with(['category', 'media'])
            ->limit(6)
            ->get();

        return view('home.index', compact('aboutUs', 'categories', 'news', 'featuredProducts'));
    }
}
