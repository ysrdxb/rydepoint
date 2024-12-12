<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessDetail;
use App\Models\Page;
use App\Models\HomePageContent;

class HomeController extends Controller
{
    public function index()
    {        
        $homepage = HomePageContent::first();
        return view('home', compact('homepage'));
    }
    
    public function search(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $search_location = $request->input('search_location');

        $radius = 30;

        $vendors = BusinessDetail::selectRaw("
            *, 
            ( 6371 * acos( cos( radians(?) ) *
            cos( radians( latitude ) ) *
            cos( radians( longitude ) - radians(?) ) +
            sin( radians(?) ) *
            sin( radians( latitude ) ) ) ) AS distance
        ", [$latitude, $longitude, $latitude])
        ->having('distance', '<=', $radius)
        ->where(function($query) use ($latitude, $longitude) {
            $query->where('latitude', '!=', $latitude)
                  ->orWhere('longitude', '!=', $longitude);
        })
        ->orderBy('distance', 'asc')
        ->get();

        session([
            'vendors' => $vendors,
            'user_latitude' => $latitude,
            'user_longitude' => $longitude,
            'search_location' => $search_location
        ]);

        return redirect()->route('vendor.results');
    }
}
