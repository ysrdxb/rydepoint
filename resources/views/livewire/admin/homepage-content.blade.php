<div class="container mt-5">
    @include('message')
    <h2>Edit Homepage Content</h2>
    <form wire:submit.prevent="save">
        <!-- Logo Upload -->
        <div class="mb-3">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" wire:model="logo" class="form-control">
            @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Hero Title -->
        <div class="mb-3">
            <label for="hero_title" class="form-label">Hero Title</label>
            <input type="text" wire:model="hero_title" class="form-control">
            @error('hero_title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Hero Description -->
        <div class="mb-3">
            <label for="hero_description" class="form-label">Hero Description</label>
            <textarea wire:model="hero_description" class="form-control"></textarea>
            @error('hero_description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Search Placeholder -->
        <div class="mb-3">
            <label for="search_placeholder" class="form-label">Search Placeholder</label>
            <input type="text" wire:model="search_placeholder" class="form-control">
            @error('search_placeholder') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Button Text -->
        <div class="mb-3">
            <label for="button_text" class="form-label">Button Text</label>
            <input type="text" wire:model="button_text" class="form-control">
            @error('button_text') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Signup Text -->
        <div class="mb-3">
            <label for="signup_text" class="form-label">Signup Text</label>
            <input type="text" wire:model="signup_text" class="form-control">
            @error('signup_text') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- How to Use Title -->
        <div class="mb-3">
            <label for="how_to_use_title" class="form-label">How to Use Title</label>
            <input type="text" wire:model="how_to_use_title" class="form-control">
            @error('how_to_use_title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- How to Use Description -->
        <div class="mb-3">
            <label for="how_to_use_description" class="form-label">How to Use Description</label>
            <textarea wire:model="how_to_use_description" class="form-control"></textarea>
            @error('how_to_use_description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="step_one_title" class="form-label">Step One Title</label>
            <input type="text" wire:model="step_one_title" class="form-control">
            @error('step_one_title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="step_one_description" class="form-label">Step One Description</label>
            <textarea wire:model="step_one_description" class="form-control"></textarea>
            @error('step_one_description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Step Two -->
        <div class="mb-3">
            <label for="step_two_title" class="form-label">Step Two Title</label>
            <input type="text" wire:model="step_two_title" class="form-control">
            @error('step_two_title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="step_two_description" class="form-label">Step Two Description</label>
            <textarea wire:model="step_two_description" class="form-control"></textarea>
            @error('step_two_description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- Step Three -->
        <div class="mb-3">
            <label for="step_three_title" class="form-label">Step Three Title</label>
            <input type="text" wire:model="step_three_title" class="form-control">
            @error('step_three_title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="step_three_description" class="form-label">Step Three Description</label>
            <textarea wire:model="step_three_description" class="form-control"></textarea>
            @error('step_three_description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>        

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
    </form>

    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>
