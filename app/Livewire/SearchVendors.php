<?php

namespace App\Livewire;

use App\Models\BusinessDetail;
use App\Models\BusinessRate;
use App\Models\BookingEnquiry;
use App\Models\Review;
use Livewire\Component;

class SearchVendors extends Component
{
    public $location;
    public $latitude;
    public $longitude;
    public $vendors = [];
    public $showResults = false;
    public $selectedVendor = null;
    public $name;
    public $email;
    public $phone;
    public $description;
    public $showThankYou = false;
    public $search_location;
    public $rating = 0;    
    public $ratingMessage;
    public $ratingMessageError;
    public $existingRating = 0;
    public $averageRating = 0;

    protected $listeners = ['setLocation' => 'updateLocation'];

    public function mount()
    {
        $this->vendors = session('vendors', collect());
        $this->latitude = session('user_latitude');
        $this->longitude = session('user_longitude');
        $this->search_location = session('search_location');
    }

    public function updateLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }
    
    public function getVendorRate($vendorId)
    {
        $rate = BusinessRate::where('business_id', $vendorId)->first();
        return response()->json(['rate' => $rate ? $rate->rate : null]);
    }

    public function submitRating()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);
    
        if (!$this->selectedVendor) {
            $this->ratingMessageError = 'Please select a vendor first.';
            return;
        }
    
        $existingRating = Review::where('vendor_id', $this->selectedVendor->id)
                                ->where('ip_address', request()->ip())
                                ->first();
    
        if ($existingRating) {
            $this->ratingMessageError = 'You have already rated this vendor.';
            return;
        }
    
        Review::create([
            'vendor_id' => $this->selectedVendor->id,
            'rating' => $this->rating,
            'ip_address' => request()->ip(),
        ]);
    
        $this->rating = null;
        $this->ratingMessage = 'Rating submitted successfully!';
    }
    
    public function rate($newRating)
    {
        $existingRating = Review::where('vendor_id', $this->selectedVendor->id)
                                ->where('ip_address', request()->ip())
                                ->first();
    
        if ($existingRating) {
            $this->ratingMessageError = 'You have already rated this vendor.';
            return;
        }
    
        $this->rating = $newRating;
        $this->submitRating();
    }  

    public function searchVendorsNearby()
    {
        if ($this->latitude && $this->longitude) {
            $radius = 10;
    
            $vendors = BusinessDetail::with('reviews')
                ->selectRaw("
                    *,
                    (6371 * acos( cos( radians(?) ) *
                    cos( radians( latitude ) ) *
                    cos( radians( longitude ) - radians(?) ) +
                    sin( radians(?) ) *
                    sin( radians( latitude ) ) ) ) AS distance
                ", [$this->latitude, $this->longitude, $this->latitude])
                ->having('distance', '<=', $radius)
                ->orderBy('distance', 'asc')
                ->get();
    
            $this->vendors = $vendors;
            $this->showResults = true;
        }
    }
    
    

    public function selectVendor($vendorId)
    {
        $this->selectedVendor = BusinessDetail::find($vendorId);

        $existingRating = Review::where('vendor_id', $vendorId)
                                ->where('ip_address', request()->ip())
                                ->first();
        $this->rating = $existingRating ? $existingRating->rating : 0;

        $this->averageRating = Review::where('vendor_id', $vendorId)->avg('rating') ?? 0;

    }

    public function bookVehicle()
    {

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'description' => 'required|string|max:1000',
        ]);

        BookingEnquiry::create([
            'vendor_id' => $this->selectedVendor->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'description' => $this->description,
        ]);

        $this->showThankYou = true;

        $this->reset(['name', 'email', 'phone', 'description']);
    }

    public function goBack()
    {
        $this->selectedVendor = null;
    }

    public function render()
    {
        return view('results')->layout('layouts.app');
    }
}
