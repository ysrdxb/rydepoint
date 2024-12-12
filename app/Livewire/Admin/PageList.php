<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Page;
use Livewire\WithPagination;

class PageList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $pages = Page::where('title', 'like', '%' . $this->search . '%')
                     ->paginate(12);
        return view('livewire.admin.page-list', [
            'pages' => $pages,
        ])->layout('layouts.vendor');
    }

    public function delete($id)
    {
        $page = Page::find($id);
        if ($page) {
            $page->delete();
            session()->flash('message', 'Page deleted successfully.');
        }
    }
}
