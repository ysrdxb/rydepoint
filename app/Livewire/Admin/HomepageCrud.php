<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\HomePageContent;
use Livewire\WithFileUploads;

class HomepageCrud extends Component
{
    use WithFileUploads;

    public $logo, $hero_title, $hero_description, $search_placeholder;
    public $button_text, $signup_text, $how_to_use_title, $how_to_use_description;
    public $step_one_title, $step_two_title, $step_three_title;
    public $step_one_description, $step_two_description, $step_three_description;

    public function mount()
    {
        $content = HomePageContent::first();

        if ($content) {
            $this->logo = $content->logo;
            $this->hero_title = $content->hero_title;
            $this->hero_description = $content->hero_description;
            $this->search_placeholder = $content->search_placeholder;
            $this->button_text = $content->button_text;
            $this->signup_text = $content->signup_text;
            $this->how_to_use_title = $content->how_to_use_title;
            $this->how_to_use_description = $content->how_to_use_description;

            $this->step_one_title = $content->step_one_title;
            $this->step_two_title = $content->step_two_title;
            $this->step_three_title = $content->step_three_title;
            $this->step_one_description = $content->step_one_description;
            $this->step_two_description = $content->step_two_description;
            $this->step_three_description = $content->step_three_description;
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'logo' => 'nullable|image|max:1024', // max 1MB
            'hero_title' => 'required|string|max:255',
            'hero_description' => 'required|string',
            'search_placeholder' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
            'signup_text' => 'required|string|max:255',
            'how_to_use_title' => 'required|string|max:255',
            'how_to_use_description' => 'required|string',
            'step_one_title' => 'required|string|max:255',
            'step_one_description' => 'required|string',
            'step_two_title' => 'required|string|max:255',
            'step_two_description' => 'required|string',
            'step_three_title' => 'required|string|max:255',
            'step_three_description' => 'required|string',
        ]);

        $content = HomePageContent::first() ?? new HomePageContent;

        $content->hero_title = $this->hero_title;
        $content->hero_description = $this->hero_description;
        $content->search_placeholder = $this->search_placeholder;
        $content->button_text = $this->button_text;
        $content->signup_text = $this->signup_text;
        $content->how_to_use_title = $this->how_to_use_title;
        $content->how_to_use_description = $this->how_to_use_description;

        $content->step_one_title = $this->step_one_title;
        $content->step_one_description = $this->step_one_description;
        $content->step_two_title = $this->step_two_title;
        $content->step_two_description = $this->step_two_description;
        $content->step_three_title = $this->step_three_title;
        $content->step_three_description = $this->step_three_description;

        if ($this->logo) {
            $content->logo = $this->logo->store('logos', 'public');
        }

        $content->save();

        session()->flash('message', 'Homepage content updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.homepage-content')->layout('layouts.vendor');
    }
}
