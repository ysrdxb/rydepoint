<div class="container mt-4">
    <h2>Manage Businesses</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if(!$showForm)
        <button wire:click="openForm" class="btn btn-primary mb-3">Add New Business</button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Business Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($businesses as $business)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $business->business_name }}</td>
                        <td>{{ $business->email }}</td>
                        <td>{{ $business->phone_number }}</td>
                        <td>{{ $business->address }}</td>
                        <td>
                            <button wire:click="openForm({{ $business->id }})" class="btn btn-sm btn-warning">Edit</button>
                            <button wire:click="deleteBusiness({{ $business->id }})" class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $businesses->links() }}
    @endif

    @if($showForm)
        <form wire:submit.prevent="saveBusiness">
            <div class="row">
                <!-- First Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Vendor</label>
                        <select wire:model="user_id" class="form-control">
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Business Name</label>
                        <input type="text" wire:model="business_name" class="form-control">
                        @error('business_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" wire:model="email" class="form-control">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Phone Number</label>
                        <input type="text" wire:model="phone_number" class="form-control">
                        @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Latitude</label>
                        <input type="text" wire:model="latitude" class="form-control">
                        @error('latitude') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Second Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea wire:model="description" class="form-control"></textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <input type="text" wire:model="address" class="form-control">
                        @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>WhatsApp Number</label>
                        <input type="text" wire:model="whatsapp_number" class="form-control">
                        @error('whatsapp_number') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Longitude</label>
                        <input type="text" wire:model="longitude" class="form-control">
                        @error('longitude') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Logo</label>
                        <input type="file" wire:model="logo" class="form-control">
                        @if($existingLogo)
                            <img src="{{ asset('storage/' . $existingLogo) }}" width="50" alt="Logo">
                        @endif
                        @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">Save</button>
                <button type="button" wire:click="cancelForm" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
    @endif
</div>