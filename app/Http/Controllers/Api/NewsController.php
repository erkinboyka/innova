<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::query()
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->get('category'));
            })
            ->when($request->filled('featured'), function ($query) {
                $query->where('is_featured', true);
            })
            ->latest()
            ->paginate($request->integer('per_page', 12));

        return response()->json($news);
    }

    public function show(News $news)
    {
        return response()->json($news);
    }
}
