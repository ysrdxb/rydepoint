<div class="container-fluid">
    @include('message')
    @section('page_title', 'Pages')

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group">
                        <input type="text" wire:model.live="search" class="form-control" placeholder="Search pages...">
                    </div>
                </div>
                <a href="{{ route('admin.page.create') }}" class="btn btn-primary">Add New Page</a>
            </div>

            @if($pages->count())
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th class="text-center" width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{ $page->id }}</td>
                                    <td>{{ $page->title }}</td>
                                    <td>{{ $page->slug }}</td>
                                    <td>{{ $page->status ? 'Active' : 'Inactive' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.page.edit', $page->id) }}" class="btn btn-sm btn-info">Edit</a>
                                        <button wire:click="delete({{ $page->id }})" class="btn btn-sm btn-danger" onclick="confirm('Are you sure you want to delete this page?') || event.stopImmediatePropagation()">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $pages->links() }}
                </div>
            @else
                <div class="alert alert-warning text-center">No pages found.</div>
            @endif
        </div>
    </div>
</div>
