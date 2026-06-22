<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ScientistController extends Controller
{
    public function index()
    {
        $scientists = User::where('role', 'scientist')->withCount('technologies')->latest()->paginate(12);
        return view('scientists.index', compact('scientists'));
    }

    public function show(User $scientist)
    {
        if ($scientist->role !== 'scientist') {
            abort(404);
        }
        $scientist->load('organization', 'technologies');
        return view('scientists.show', compact('scientist'));
    }
}
