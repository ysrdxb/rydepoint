<div class="container">
    <h2 class="mb-4">Site Settings</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveSettings">
        <div class="mb-3">
            <label for="site_name" class="form-label">Site Name</label>
            <input type="text" id="site_name" class="form-control" wire:model="site_name">
            @error('site_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="meta_title" class="form-label">Meta Title</label>
            <input type="text" id="meta_title" class="form-control" wire:model="meta_title">
            @error('meta_title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Description</label>
            <textarea id="meta_description" class="form-control" wire:model="meta_description"></textarea>
            @error('meta_description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Site Logo</label>
            <input type="file" id="logo" class="form-control" wire:model="logo">
            @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
            @if ($existingLogo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $existingLogo) }}" alt="Site Logo" width="100">
                </div>
            @endif
        </div>

        <!-- Additional Fields -->
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" id="address" class="form-control" wire:model="address">
            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" id="phone" class="form-control" wire:model="phone">
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" class="form-control" wire:model="email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="facebook" class="form-label">Facebook</label>
            <input type="url" id="facebook" class="form-control" wire:model="facebook">
            @error('facebook') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="twitter" class="form-label">Twitter</label>
            <input type="url" id="twitter" class="form-control" wire:model="twitter">
            @error('twitter') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="google" class="form-label">Google</label>
            <input type="url" id="google" class="form-control" wire:model="google">
            @error('google') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="pinterest" class="form-label">Pinterest</label>
            <input type="url" id="pinterest" class="form-control" wire:model="pinterest">
            @error('pinterest') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
