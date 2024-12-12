@push('head')
<style>
    .input-group-prepend{
        max-height:35px;
    }
</style>
@endpush

<div class="container mt-5">
    <h2 class="text-center mb-4 fw-bold">Vendor Dashboard</h2>

    @if (session()->has('message'))
        <div class="alert alert-success text-center">
            {{ session('message') }}
        </div>
    @endif

    <!-- Business Details Section -->
    <h3 class="fw-bold mb-3">Business Details</h3>
    <form wire:submit.prevent="saveBusinessDetails" enctype="multipart/form-data">
        
        <!-- Business Name -->
        <div class="mb-3">
            <label for="business_name" class="form-label fw-semibold">Business Name</label>
            <input type="text" id="business_name" class="form-control" wire:model="business_name" placeholder="Enter your business name">
            @error('business_name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea id="description" class="form-control" wire:model="description" placeholder="Describe your business"></textarea>
        </div>

        <!-- Business Location with Autocomplete -->
        <div class="mb-3">
            <label for="address" class="form-label fw-semibold">Business Location</label>
            <input type="text" id="address" class="form-control" onfocus="initializeAutocomplete()" wire:model="address" placeholder="Enter location">
            @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
    
        <!-- Latitude and Longitude (Readonly) -->
        <div class="row">
            <div class="col-md-6 mb-3 d-none">
                <label for="latitude" class="form-label fw-semibold">Latitude</label>
                <input type="text" id="latitude" class="form-control" wire:model.defer="latitude" placeholder="Latitude" readonly>
                @error('latitude') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3 d-none">
                <label for="longitude" class="form-label fw-semibold">Longitude</label>
                <input type="text" id="longitude" class="form-control" wire:model.defer="longitude" placeholder="Longitude" readonly>
                @error('longitude') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Mile Ranges and Rates -->
        <h4 class="fw-bold mt-4">Mile Ranges and Rates</h4>
        <div class="mb-3">
            <div class="d-flex align-items-center mb-2">
                <!-- Styled mileage range as plain text -->
                <span class="mr-3 font-weight-bold text-secondary">0 - 10 miles</span>
        
                <!-- Input group for Rate with $ symbol inside the field on the left -->
                <div class="input-group" style="max-width: 150px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.01" class="form-control" wire:model="rates.0.rate" placeholder="Rate">
                </div>
            </div>
            @error('rates.0.rate') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-3">
            <div class="d-flex align-items-center mb-2">
                <!-- Styled mileage range as plain text -->
                <span class="mr-3 font-weight-bold text-secondary">11 - 20 miles</span>
        
                <!-- Input group for Rate with $ symbol inside the field on the left -->
                <div class="input-group" style="max-width: 150px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.01" class="form-control" wire:model="rates.1.rate" placeholder="Rate">
                </div>
            </div>
            @error('rates.1.rate') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Contact Information -->
        <h4 class="fw-bold mt-4">Contact Information</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="phone_number" class="form-label fw-semibold">Phone Number (optional)</label>
                <input type="text" id="phone_number" class="form-control" wire:model="phone_number" placeholder="Enter phone number">
            </div>
            <div class="col-md-6 mb-3">
                <label for="whatsapp_number" class="form-label fw-semibold">WhatsApp Number (optional)</label>
                <input type="text" id="whatsapp_number" class="form-control" wire:model="whatsapp_number" placeholder="Enter WhatsApp number">
            </div>
        </div>

        <!-- Business Logo -->
        <div class="mb-3">
            <label for="logo" class="form-label fw-semibold">Business Logo</label>
            <div class="mb-2">
                <img 
                    src="{{ $currentLogo ?: 'https://via.placeholder.com/100' }}" 
                    alt="Business Logo" 
                    class="rounded border img-fluid" 
                    style="max-height: 100px; max-width: 100px;"
                />
            </div>
            <input type="file" id="logo" class="form-control" wire:model="logo">
            @error('logo') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <!-- Save Button -->
        <button type="submit" class="btn btn-primary w-100 fw-bold">Save Business Details</button>
    </form>

    <!-- Change Password Section -->
    <hr class="my-5">
    <h3 class="fw-bold mb-3">Change Password</h3>
    <form wire:submit.prevent="changePassword">
        <div class="mb-3">
            <label for="current_password" class="form-label fw-semibold">Current Password</label>
            <input type="password" id="current_password" class="form-control" wire:model="current_password" placeholder="Enter current password">
            @error('current_password') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label fw-semibold">New Password</label>
            <input type="password" id="new_password" class="form-control" wire:model="new_password" placeholder="Enter new password">
            @error('new_password') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="new_password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
            <input type="password" id="new_password_confirmation" class="form-control" wire:model="new_password_confirmation" placeholder="Confirm new password">
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-bold">Change Password</button>
    </form>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC44otCXkNlpDZKwN1evKAKYxuI6w0DGog&libraries=places"></script>
<script>
    function initializeAutocomplete() {
        const input = document.getElementById('address');
        const autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();

            if (place.geometry) {
                const lat = place.geometry.location.lat();
                const lng = place.geometry.location.lng();
                const formattedAddress = place.formatted_address; // Get the suggested address

                // Update the address input and hidden input fields directly
                document.getElementById('address').value = formattedAddress;
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                // Emit an event to Livewire to update the properties, including address
                Livewire.dispatch('updateLocation', { lat: lat, lng: lng, address: formattedAddress });
            }
        });
    }
</script>

@endpush
