<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        // Find the page by slug and ensure it is published (status = 1)
        $page = Page::where('slug', $slug)->where('status', 1)->firstOrFail();

        // Pass the page content and metadata to the view
        return view('pages.show', compact('page'));
    }
}
