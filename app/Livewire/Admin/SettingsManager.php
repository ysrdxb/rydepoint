<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;
use Livewire\WithFileUploads;

class SettingsManager extends Component
{
    use WithFileUploads;

    public $site_name;
    public $logo;
    public $meta_title;
    public $meta_description;
    public $address;
    public $phone;
    public $email;
    public $facebook;
    public $twitter;
    public $google;
    public $pinterest;
    public $existingLogo;

    protected $rules = [
        'site_name' => 'required|string|max:255',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string',
        'logo' => 'nullable|image|max:1024',
        'address' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'facebook' => 'nullable|url',
        'twitter' => 'nullable|url',
        'google' => 'nullable|url',
        'pinterest' => 'nullable|url',
    ];

    public function mount()
    {
        // Load existing settings
        $this->site_name = Setting::where('key', 'site_name')->value('value');
        $this->meta_title = Setting::where('key', 'meta_title')->value('value');
        $this->meta_description = Setting::where('key', 'meta_description')->value('value');
        $this->address = Setting::where('key', 'address')->value('value');
        $this->phone = Setting::where('key', 'phone')->value('value');
        $this->email = Setting::where('key', 'email')->value('value');
        $this->facebook = Setting::where('key', 'facebook')->value('value');
        $this->twitter = Setting::where('key', 'twitter')->value('value');
        $this->google = Setting::where('key', 'google')->value('value');
        $this->pinterest = Setting::where('key', 'pinterest')->value('value');
        $this->existingLogo = Setting::where('key', 'logo')->value('value');
    }

    public function saveSettings()
    {
        $this->validate();

        // Save each setting
        Setting::updateOrCreate(['key' => 'site_name'], ['value' => $this->site_name]);
        Setting::updateOrCreate(['key' => 'meta_title'], ['value' => $this->meta_title]);
        Setting::updateOrCreate(['key' => 'meta_description'], ['value' => $this->meta_description]);
        Setting::updateOrCreate(['key' => 'address'], ['value' => $this->address]);
        Setting::updateOrCreate(['key' => 'phone'], ['value' => $this->phone]);
        Setting::updateOrCreate(['key' => 'email'], ['value' => $this->email]);
        Setting::updateOrCreate(['key' => 'facebook'], ['value' => $this->facebook]);
        Setting::updateOrCreate(['key' => 'twitter'], ['value' => $this->twitter]);
        Setting::updateOrCreate(['key' => 'google'], ['value' => $this->google]);
        Setting::updateOrCreate(['key' => 'pinterest'], ['value' => $this->pinterest]);

        // Handle logo upload if there's a new one
        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            Setting::updateOrCreate(['key' => 'logo'], ['value' => $path]);
            $this->existingLogo = $path;
        }

        session()->flash('message', 'Settings saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.settings-manager')->layout('layouts.vendor');
    }
}
