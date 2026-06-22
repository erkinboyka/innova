<?php

namespace App\Http\Controllers;

use App\Models\Grant;
use App\Models\Organization;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = $request->input('q');

        if (!$q) {
            return redirect()->back();
        }

        return view('search.results', [
            'q' => $q,
            'technologies' => Technology::where('title', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%")->take(10)->get(),
            'scientists' => User::where('role', 'scientist')->where('name', 'like', "%{$q}%")->take(10)->get(),
            'organizations' => Organization::where('name', 'like', "%{$q}%")->take(10)->get(),
            'grants' => Grant::where('title', 'like', "%{$q}%")->take(10)->get(),
        ]);
    }
}
