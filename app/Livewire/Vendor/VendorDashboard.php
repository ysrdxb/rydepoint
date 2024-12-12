<?php

namespace App\Livewire\Vendor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessDetail;
use App\Models\BusinessRate;
use Illuminate\Support\Facades\Storage;

class VendorDashboard extends Component
{
    use WithFileUploads;

    public $business_name, $description, $price_per_km, $phone_number, $email, $whatsapp_number;
    public $logo, $address;
    public $rates = [];
    public $latitude;
    public $longitude;    
    public $currentLogo;
    
    public function mount()
    {
        $vendor = Auth::user();
        $business = BusinessDetail::where('user_id', $vendor->id)->first();

        if ($business) {
            $this->business_name = $business->business_name;
            $this->description = $business->description;
            $this->phone_number = $business->phone_number;
            $this->whatsapp_number = $business->whatsapp_number;
            $this->email = $business->email;
            $this->address = $business->address;
            $this->latitude = $business->latitude;
            $this->longitude = $business->longitude;
            $this->currentLogo = asset('storage/' . $business->logo);

            // Initialize with rates for 0-10 and 11-20 miles
            $this->rates = BusinessRate::where('business_id', $business->id)
                ->where(function ($query) {
                    $query->where('distance_from', 0)
                          ->where('distance_to', 10)
                          ->orWhere(function ($query) {
                              $query->where('distance_from', 11)
                                    ->where('distance_to', 20);
                          });
                })
                ->get(['distance_from', 'distance_to', 'rate'])
                ->toArray();
    
            // Ensure both ranges are present, even if not retrieved
            if (count($this->rates) < 2) {
                $this->rates = [
                    ['distance_from' => 0, 'distance_to' => 10, 'rate' => $this->rates[0]['rate'] ?? 0],
                    ['distance_from' => 11, 'distance_to' => 20, 'rate' => $this->rates[1]['rate'] ?? 0],
                ];
            }
        } else {
            $this->rates = [
                ['distance_from' => 0, 'distance_to' => 10, 'rate' => 0],
                ['distance_from' => 11, 'distance_to' => 20, 'rate' => 0],
            ];
            $this->currentLogo = null;
            
        }
    }
    
    public function saveBusinessDetails()
    {
        $rules = [
            'business_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'email' => 'nullable|string',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'rates.0.rate' => 'required|numeric|min:0',
            'rates.1.rate' => 'required|numeric|min:0',
        ];
    
        if ($this->logo) {
            $rules['logo'] = 'image|mimes:jpeg,png,jpg|max:2048';
        }
    
        $this->validate($rules);
    
        $business = BusinessDetail::where('user_id', Auth::id())->first();
    
        // Handle logo upload only if a new one is provided
        if ($this->logo) {
            $logoPath = $this->logo->store('logos', 'public');
        } else {
            $logoPath = $business ? $business->logo : null;
        }
    
        $business = BusinessDetail::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'business_name' => $this->business_name,
                'description' => $this->description,
                'phone_number' => $this->phone_number,
                'whatsapp_number' => $this->whatsapp_number,
                'email' => $this->email,
                'logo' => $logoPath, // Use the logo path
                'address' => $this->address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]
        );
    
        foreach ($this->rates as $rate) {
            BusinessRate::updateOrCreate(
                [
                    'business_id' => $business->id,
                    'distance_from' => $rate['distance_from'],
                    'distance_to' => $rate['distance_to'],
                    'user_id' => Auth::user()->id,
                ],
                ['rate' => $rate['rate']]
            );
        }
    
        session()->flash('message', 'Business details and rates updated successfully!');
    }



    protected $listeners = ['updateLocation'];

    public function updateLocation($lat, $lng, $address)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
        $this->address = $address;
    }

    public function render()
    {
        return view('livewire.vendor.dashboard')->layout('layouts.vendor');
    }
}
