<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function show(News $news)
    {
        $gallery = $news->getMedia('gallery');
        return view('news.show', compact('news', 'gallery'));
    }
}
