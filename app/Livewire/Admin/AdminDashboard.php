<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessDetail;
use App\Models\BusinessRate;

class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.vendor');
    }
}