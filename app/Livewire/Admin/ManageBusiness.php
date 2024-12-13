<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Business;
use App\Models\User;
use Livewire\WithFileUploads;

class BusinessManager extends Component
{
    use WithPagination, WithFileUploads;

    public $showForm = false, $businessId, $user_id, $business_name, $description, $email, $phone_number, $whatsapp_number, $address, $latitude, $longitude, $logo, $existingLogo;

    protected $rules = [
        'user_id' => 'required',
        'business_name' => 'required',
        'email' => 'required|email',
        'phone_number' => 'required',
        'address' => 'required',
    ];

    public function render()
    {
        return view('livewire.business-manager', [
            'businesses' => Business::paginate(10),
            'vendors' => User::all(),
        ]);
    }

    public function showForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function saveBusiness()
    {
        $this->validate();
        $data = [
            'user_id' => $this->user_id,
            'business_name' => $this->business_name,
            'description' => $this->description,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'whatsapp_number' => $this->whatsapp_number,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];

        if ($this->logo) {
            $data['logo'] = $this->logo->store('logos', 'public');
        }

        if ($this->businessId) {
            Business::find($this->businessId)->update($data);
        } else {
            Business::create($data);
        }

        $this->cancelForm();
    }

    public function editBusiness($id)
    {
        $business = Business::findOrFail($id);
        $this->businessId = $business->id;
        $this->user_id = $business->user_id;
        $this->business_name = $business->business_name;
        $this->description = $business->description;
        $this->email = $business->email;
        $this->phone_number = $business->phone_number;
        $this->whatsapp_number = $business->whatsapp_number;
        $this->address = $business->address;
        $this->latitude = $business->latitude;
        $this->longitude = $business->longitude;
        $this->existingLogo = $business->logo;
        $this->showForm = true;
    }

    public function deleteBusiness($id)
    {
        Business::findOrFail($id)->delete();
        $this->render();
    }

    public function cancelForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    private function resetForm()
    {
        $this->reset([
            'businessId', 'user_id', 'business_name', 'description', 'email', 'phone_number',
            'whatsapp_number', 'address', 'latitude', 'longitude', 'logo', 'existingLogo'
        ]);
    }
}
