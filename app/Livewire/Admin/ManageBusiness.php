<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\BusinessDetail;
use App\Models\User;

class ManageBusiness extends Component
{
    use WithPagination, WithFileUploads;

    public $business_id, $user_id, $business_name, $description, $email, $address, $logo, $phone_number, $whatsapp_number, $latitude, $longitude, $existingLogo;
    public $showModal = false;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'business_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:255',
        'logo' => 'nullable|image|max:1024',
        'phone_number' => 'nullable|string|max:20',
        'whatsapp_number' => 'nullable|string|max:20',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ];

    // Reset fields after every action
    public function resetFields()
    {
        $this->reset(['business_id', 'user_id', 'business_name', 'description', 'email', 'address', 'logo', 'phone_number', 'whatsapp_number', 'latitude', 'longitude', 'existingLogo']);
    }

    // Open modal for creating or editing
    public function openModal($id = null)
    {
        $this->resetFields();
        if ($id) {
            $business = BusinessDetail::findOrFail($id);
            $this->business_id = $business->id;
            $this->user_id = $business->user_id;
            $this->business_name = $business->business_name;
            $this->description = $business->description;
            $this->email = $business->email;
            $this->address = $business->address;
            $this->existingLogo = $business->logo;
            $this->phone_number = $business->phone_number;
            $this->whatsapp_number = $business->whatsapp_number;
            $this->latitude = $business->latitude;
            $this->longitude = $business->longitude;
        }
        $this->showModal = true;
    }

    // Save business detail
    public function saveBusiness()
    {
        $this->validate();

        $data = [
            'user_id' => $this->user_id,
            'business_name' => $this->business_name,
            'description' => $this->description,
            'email' => $this->email,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'whatsapp_number' => $this->whatsapp_number,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('logos', 'public');
        }

        if ($this->business_id) {
            BusinessDetail::findOrFail($this->business_id)->update($data);
            session()->flash('message', 'Business updated successfully!');
        } else {
            BusinessDetail::create($data);
            session()->flash('message', 'Business created successfully!');
        }

        $this->resetFields();
        $this->showModal = false;
    }

    // Delete a business detail
    public function deleteBusiness($id)
    {
        BusinessDetail::findOrFail($id)->delete();
        session()->flash('message', 'Business deleted successfully!');
    }

    public function render()
    {
        $businesses = BusinessDetail::paginate(10);
        $vendors = User::where('role', 'vendor')->get();

        return view('livewire.admin.manage-business', [
            'businesses' => $businesses,
            'vendors' => $vendors,
        ])->layout('layouts.vendor');
    }
}
