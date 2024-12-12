@section('title', $search_location)
@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<style>
.container-fluid {
    padding: 0 2%;
}

/* Listing Card */
.listing-card {
    background-color: #ffffff;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1) !important;
    border-radius: 8px;
    transition: box-shadow 0.3s;
    padding: 20px;
}

/* Vendor Logo Styling */
.vendor-logo {
    max-width:124px ;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
}

.vendor-info {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
    color: #555;
    flex-wrap: nowrap; /* Ensures items stay in a row */
}

.vendor-info i {
    color: #0071bc;
    margin-right: 6px;
}

@media (max-width: 767px) {
    .vendor-logo {
        width: 140px !important;
        margin-bottom: 10px;
    }

    .vendor-info {
        display: inline-flex; /* Displays items in a single line */
        flex-wrap: nowrap; /* Prevents items from stacking vertically */
        gap: 8px; /* Adds some spacing between elements */
        font-size: 0.85rem;
    }

    .vendor-info i {
        margin-right: 4px;
    }
}


/* Vendor Name Link */
.vendor-name a {
    color: #2c3e50;
    font-weight: bold;
    text-decoration: none;
    font-size: 1.1rem;
}
.vendor-name a:hover {
    color: #0071bc;
}

/* Button Styling */
.col-md-3 .btn {
    font-size: 0.85rem;
    padding: 4px 4px;
    text-align: center;
    font-weight: 400;
    border-radius: 6px;
}
.col-md-3 .btn-primary {
    background-color: #0071bc;
    border-color: #0071bc;
    color: #fff;
}
.col-md-3 .btn-primary:hover {
    background-color: #005a9e;
    border-color: #005a9e;
}
.col-md-3 .btn-light {
    background-color: #f5f5f5;
    border-color: #ddd;
    color: #333;
}
.col-md-3 .btn-light:hover {
    background-color: #e9e9e9;
}

/* Map Area Styling */
.map-area {
    height: 200px;
    width: 100%;
    background: #f5f5f5;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
    #map {
        height: 200px;
        width: 100%;
        margin-bottom: 20px;
    }
</style>
@endpush

<div class="container">
    @if($vendors->isEmpty() && !$selectedVendor)
        <br><br><br>

        <div class="alert alert-warning" role="alert">
            No transport providers found in your area.
        </div>
        <a class="btn btn-secondary mt-3" href="{{ route('home') }}">Go Back</a>
        <br><br>

    @elseif($selectedVendor && !$showThankYou)
            @php
                $pickupLatitude = $latitude;
                $pickupLongitude = $longitude;
                $earthRadius = 3958.8;
                $vendorLatitude = $selectedVendor->latitude;
                $vendorLongitude = $selectedVendor->longitude;
                $latFrom = deg2rad($pickupLatitude);
                $lonFrom = deg2rad($pickupLongitude);
                $latTo = deg2rad($vendorLatitude);
                $lonTo = deg2rad($vendorLongitude);
                $latDelta = $latTo - $latFrom;
                $lonDelta = $lonTo - $lonFrom;
                $a = sin($latDelta / 2) * sin($latDelta / 2) +
                    cos($latFrom) * cos($latTo) *
                    sin($lonDelta / 2) * sin($lonDelta / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $distance = $earthRadius * $c;
                $businessRates = \App\Models\BusinessRate::where('business_id', $selectedVendor->id)->orderBy('distance_from')->get();
                $rate = null;
                $maxDistance = 0;
                foreach ($businessRates as $businessRate) {
                    if ($distance >= $businessRate->distance_from && $distance <= $businessRate->distance_to) {
                        $rate = $businessRate->rate;
                        break;
                    }
                    $maxDistance = max($maxDistance, $businessRate->distance_to);
                }
                if ($rate === null && $distance > $maxDistance) {
                    $rate = 'from ' . number_format($businessRates->last()->rate, 2);
                }
            @endphp    
        <br><br>
        <div class="listing-card text-center row" style="margin:auto; max-width:609px; padding: 20px; border-radius: 10px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <img src="{{ isset($selectedVendor) && $selectedVendor->logo ? public_path('storage/' . $selectedVendor->logo) : 'https://via.placeholder.com/100' }}" 
                 alt="{{ $selectedVendor->name ?? 'Vendor Logo' }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
            <h5 style="margin-top: 15px; font-size: 1.5rem; font-weight: bold; color: #333;">{{ $selectedVendor->business_name }}</h5>
        
            <!-- Review Section -->
            <div class="review-section" style="margin-top: 20px; text-align: center;">
                <h6 style="font-size: 1.2rem; color: #333;">Rate this Vendor</h6>
                <div style="margin-top: 10px;">
                    @for ($i = 1; $i <= 5; $i++)
                        <span 
                            wire:click="{{ !$existingRating ? "rate($i)" : '' }}" 
                            style="cursor: {{ !$existingRating ? 'pointer' : 'not-allowed' }}; font-size: 1.5rem; color: {{ $i <= $rating ? 'gold' : '#ccc' }};">
                            {{ $i <= $rating ? '★' : '☆' }}
                        </span>
                    @endfor
                </div>
                @if($ratingMessage)
                    <p class="text-success" style="font-size: 1rem; margin-top: 10px;">{{ $ratingMessage }}</p>
                @endif
                @if($ratingMessageError)
                    <p class="text-danger" style="font-size: 1rem; margin-top: 10px;">{{ $ratingMessageError }}</p>
                @endif                
            </div>
            <!-- End of Review Section -->
        
            <!-- Vendor Info Section -->
            <div class="vendor-infox" style="text-align: left; font-size: 1rem; color: #555;">
                <div><strong>Address:</strong> {{ $selectedVendor->address }}</div>
                <div><strong>Pickup Location:</strong> {{ $search_location }}</div>
                <div><strong>Rate:</strong> 
                    {{ $rate !== null ? '$' . $rate : 'Rate not available' }}
                </div>
                <div><strong>Distance:</strong> {{ number_format($distance, 2) }} miles</div>
                <div><strong>Date:</strong> {{ now()->format('Y-m-d') }}</div>
            </div>
            <!-- End of Vendor Info Section -->
        
            <!-- Booking Form -->
            <form wire:submit.prevent="bookVehicle" style="text-align:left; margin-top: 20px;">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="name" style="font-weight: 600;">Name:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name">
                    @error('name') <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="email" style="font-weight: 600;">Email:</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" wire:model="email">
                    @error('email') <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="phone" style="font-weight: 600;">Phone:</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" wire:model="phone">
                    @error('phone') <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="description" style="font-weight: 600;">Description:</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description" rows="4"></textarea>
                    @error('description') <span class="text-danger" style="font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; font-size: 1rem;">Book Vehicle</button>
            </form>
        
            <!-- Go Back Button -->
            <br>
            <a class="btn btn-secondary mt-3" href="{{ route('vendor.results') }}" style="padding: 10px; font-size: 1rem; background-color: #6c757d; border-color: #6c757d;">Go to Result Page</a>
        </div>
        

        <br><br>
    @elseif($showThankYou)
        <Br><br>
        <div class="listing-card text-center row" style="margin:auto; max-width:549px;">
            <h5>Thank You!</h5>
            <p>Your booking enquiry has been submitted successfully. We will contact you soon.</p>
            <button class="btn btn-secondary mt-3" wire:click="goBack">Go Back to Vendors List</button>
        </div>
        <br><br>
    @else

    <br>
    <div class="container-fluid mt-4">
        <div class="row">
            <div id="map"></div>
            <div class="col-lg-12">
                @foreach($vendors as $vendor)
                    <div class="listing-card row mb-4 p-3 shadow-sm align-items-center bg-white rounded">
                        <!-- Vendor Logo Section -->
                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                            <img src="{{ $vendor->logo ? asset('storage/' . $vendor->logo) : 'https://via.placeholder.com/100' }}" 
                                 alt="{{ $vendor->business_name }}" 
                                 class="vendor-logo">
                            
                        </div>
                
                        <!-- Vendor Details Section -->
                        <div class="col-md-7" style="border-right:1px solid #e0e0e0;">
                            <h5 class="vendor-name mb-1">
                                <a href="javascript:;" class="text-dark fw-bold" wire:click="selectVendor({{ $vendor->id }})">{{ $vendor->business_name }}</a>
                            </h5>
                            <div class="review-stars mb-2">
                                @php
                                    $reviews = \App\Models\Review::where('vendor_id', $vendor->id)->get();
                                    $count = $reviews->count();
                                    $averageRating = $count > 0 ? round($reviews->sum('rating') / $count, 2) : 0;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="me-1" style="color: {{ $i <= $averageRating ? '#FFD700' : '#ddd' }}">★</span>
                                @endfor
                                <small class="text-muted">({{ $count }} reviews)</small>
                            </div>
                            <p class="vendor-info text-muted mb-1">
                                <i class="ti-location-pin"></i> {{ $vendor->address }}
                            </p>
                            <p class="vendor-info text-muted mb-1">
                                <i class="ti-info-alt"></i> {{ $vendor->description }}
                            </p>                            
                            <p class="vendor-info text-muted mb-1">
                                <i class="ti-map-alt"></i> {{ round($vendor->distance, 2) }} km away
                            </p>
                            <p class="vendor-info text-muted mb-1">
                                <i class="ti-money"></i>
                                @php
                                    $businessRates = \App\Models\BusinessRate::where('business_id', $vendor->id)->orderBy('distance_from')->get();
                                    $rate = null;
                                    $maxDistance = 0;
                                    foreach ($businessRates as $businessRate) {
                                        if ($vendor->distance >= $businessRate->distance_from && $vendor->distance <= $businessRate->distance_to) {
                                            $rate = $businessRate->rate;
                                            break;
                                        }
                                        $maxDistance = max($maxDistance, $businessRate->distance_to);
                                    }
                                    if ($rate === null && $vendor->distance > $maxDistance) {
                                        $rate = 'from ' . number_format($businessRates->last()->rate, 2);
                                    }
                                @endphp
                                {{ $rate !== null ? '$' . $rate : 'Rate not available' }}
                                <input type="hidden" id="vendorRatex{{ $vendor->id }}" value="{{ $rate }}">
                            </p>
                        </div>
                
                        <!-- Action Buttons Section -->
                        <div class="col-md-3 d-flex flex-column align-items-end">
                            <!-- View Details (default for desktop) -->
                            <button class="btn btn-primary btn-sm mb-2 w-100 d-flex align-items-center justify-content-center d-none d-md-flex" wire:click="selectVendor({{ $vendor->id }})">
                                <i class="ti-eye me-2"></i> View Details
                            </button>
                            <a href="mailto:{{ $vendor->email }}" class="btn btn-outline-secondary btn-sm mb-2 w-100 d-flex align-items-center justify-content-center">
                                <i class="ti-email me-2"></i> Email
                            </a>
                            <!-- SMS button visible only on mobile -->
                            <a href="sms:{{ $vendor->phone_number }}" class="btn btn-outline-secondary btn-sm mb-2 w-100 d-flex align-items-center justify-content-center d-md-none">
                                <i class="ti-comment me-2"></i> SMS
                            </a>
                            <!-- Call button changes behavior based on screen size -->
                            <a href="javascript:void(0);" class="btn btn-outline-secondary btn-sm w-100 d-flex align-items-center justify-content-center" 
                               onclick="handleCallClick(this, '{{ $vendor->phone_number }}')">
                                <i class="ti-mobile me-2"></i> <span>Call</span>
                            </a>

                            <a href="{{ route('chat', ['vendorId' => $vendor->user->id]) }}" class="btn btn-primary">Chat with {{ $vendor->business_name }}</a>
                            
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    


    @endif
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC44otCXkNlpDZKwN1evKAKYxuI6w0DGog"></script>
<style>
    /* Custom label style for business names */
    .custom-label {
        background-color: rgba(5, 5, 5, 0.5);
        padding: 2px 5px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: bold;
        color: black;
        white-space: nowrap;
    }

    /* Ensure the map container has a height */
    #map {
        width: 100%;
        height: 300px;
    }
</style>

<script>
    function handleCallClick(button, phoneNumber) {
        if (window.innerWidth >= 768) {  // Desktop behavior
            const span = button.querySelector('span');
            if (span.textContent === 'Call') {
                span.textContent = phoneNumber;  // Show phone number
            } else {
                span.textContent = 'Call';  // Switch back to "Call" on second click
            }
        } else {  // Mobile behavior
            window.location.href = 'tel:' + phoneNumber;  // Make call directly
        }
    }
    
    function initMap() {
        const defaultCenter = { lat: 0, lng: 0 };
        
        const assetBasePath = "{{ asset('storage') }}"; // Use Laravel's asset path for images

        // Get user's session location
        const sessionLocation = {
            lat: parseFloat(@json(session('user_latitude') ?? 0)),
            lng: parseFloat(@json(session('user_longitude') ?? 0))
        };

        // Initialize map centered on user's location or default if unavailable
        const map = new google.maps.Map(document.getElementById("map"), {
            center: sessionLocation.lat && sessionLocation.lng ? sessionLocation : defaultCenter,
            zoom: 1,
        });

        const vendors = @json($vendors);
        const bounds = new google.maps.LatLngBounds();

        // Display the user's session location if available
        if (sessionLocation.lat && sessionLocation.lng) {
            new google.maps.Marker({
                position: sessionLocation,
                map: map,
                label: {
                    text: "Your Location",
                    className: "custom-label"
                },
                icon: null,
            });
            bounds.extend(sessionLocation);
        }

        // Display each vendor's logo and price as a custom InfoWindow
        vendors.forEach(vendor => {
            const vendorPosition = {
                lat: parseFloat(vendor.latitude),
                lng: parseFloat(vendor.longitude)
            };

            if (isNaN(vendorPosition.lat) || isNaN(vendorPosition.lng)) {
                console.error("Invalid coordinates for vendor:", vendor);
                return;
            }

            // Check if vendor has a logo; if not, skip the logo display
            const logoSrc = vendor.logo ? `${assetBasePath}/${vendor.logo}` : 'https://via.placeholder.com/100';

            // Initial InfoWindow without price (will update via Ajax)
            const rate = document.getElementById(`vendorRatex${vendor.id}`).value || 'N/A';
        
            const infoWindowContent = `
                <div style="display: flex; align-items: center; background: rgba(255, 255, 255, 0.8); padding: 5px; border-radius: 5px;">
                    ${vendor.logo ? `<img src="${assetBasePath}/${vendor.logo}" alt="${vendor.business_name}" style="width: 30px; height: 30px; margin-right: 8px; border-radius: 50%;">` : ''}
                    <div>
                        <p style="margin: 0; font-weight: bold;">${vendor.business_name}</p>
                        <p style="margin: 0; color: green;">$${rate}</p>
                    </div>
                </div>
            `;

            const infoWindow = new google.maps.InfoWindow({
                content: infoWindowContent,
            });

            // Add a marker and open the InfoWindow
            const marker = new google.maps.Marker({
                position: vendorPosition,
                map: map,
                icon: null,
            });

            infoWindow.open(map, marker);

            // Draw line between user location and vendor
            new google.maps.Polyline({
                path: [sessionLocation, vendorPosition],
                geodesic: true,
                strokeColor: "#FF0000",
                strokeOpacity: 0.7,
                strokeWeight: 2,
                map: map,
            });

            bounds.extend(vendorPosition);
        });

        // Fit the map to show all markers
        if (!bounds.isEmpty()) {
            map.fitBounds(bounds);
        } else {
            console.warn("Bounds are empty. Check the coordinates provided.");
        }
    }

    window.onload = initMap;
</script>

@endpush


