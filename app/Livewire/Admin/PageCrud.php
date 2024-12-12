<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Page;

class PageCrud extends Component
{
    public $title, $slug, $content, $meta_title, $meta_description, $status, $pageId;
    public $updateMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:pages,slug',
        'content' => 'nullable|string',
        'meta_title' => 'nullable|string',
        'meta_description' => 'nullable|string',
        'status' => 'boolean',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->edit($id);
        }
    }

    public function render()
    {
        return view('livewire.admin.page-crud')->layout('layouts.vendor');
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->slug = '';
        $this->content = '';
        $this->meta_title = '';
        $this->meta_description = '';
        $this->status = '';
    }

    public function store()
    {
        $this->validate();

        Page::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Page created successfully.');
        return redirect()->route('admin.page');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $this->pageId = $id;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->content = $page->content;
        $this->meta_title = $page->meta_title;
        $this->meta_description = $page->meta_description;
        $this->status = $page->status;
        $this->updateMode = true;
    }

    public function update()
    {
        $page = Page::find($this->pageId);

        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'boolean',
        ];

        if ($this->slug !== $page->slug) {
            $rules['slug'] = 'required|string|max:255|unique:pages,slug';
        } else {
            $rules['slug'] = 'required|string|max:255';
        }

        $this->validate($rules);

        $page->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'status' => $this->status,
        ]);

        $this->updateMode = false;
        session()->flash('message', 'Page updated successfully.');
        return redirect()->route('admin.page');
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        return redirect()->route('admin.page');
    }
}
