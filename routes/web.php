<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Vendor\VendorDashboard;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\SettingsManager;
use App\Http\Controllers\HomeController;
use App\Livewire\SearchVendors;
use App\Livewire\Admin\PageCrud;
use App\Livewire\Admin\PageList;
use App\Http\Controllers\PageController;
use App\Livewire\Admin\HomepageCrud;
use Illuminate\Support\Facades\File;
use App\Livewire\Chat;

Livewire::setScriptRoute(function($handle) {
    return Route::get('/rydepoint/public/livewire/livewire.js', $handle);
});

Livewire::setUpdateRoute(function($handle) {
    return Route::get('/rydepoint/public/livewire/update', $handle);
});

Route::get('/chat/{vendorId?}', Chat::class)->name('chat')->middleware('auth');

Route::get('/generate-link', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');

    // Check if the symbolic link exists and remove it using system commands
    if (File::exists($link)) {
        // If it's a symlink, delete it using system command
        if (is_link($link)) {
            exec('rm ' . escapeshellarg($link)); // Remove symlink
        } else {
            // If it's not a symlink (but maybe a directory), delete it
            exec('rm -rf ' . escapeshellarg($link)); // Remove file or directory
        }
    }

    // Now recreate the symlink using the system command
    try {
        exec('ln -s ' . escapeshellarg($target) . ' ' . escapeshellarg($link));
        return 'The storage link has been successfully recreated!';
    } catch (\Exception $e) {
        return 'Error creating symbolic link: ' . $e->getMessage();
    }
});

Route::get('/getRate/{vendorId}', [SearchVendors::class, 'getVendorRate'])->name('getRate');

Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/search-vendors', [HomeController::class, 'search'])->name('search.vendors');

Route::get('/vendor-results', SearchVendors::class)->name('vendor.results');

Route::get('/dashboard', VendorDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/vendor/dashboard', VendorDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('vendor.dashboard');

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', AdminDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard'); 

    Route::get('/settings', SettingsManager::class)->name('admin.settings');

    Route::get('/page', PageList::class)->name('admin.page');
    Route::get('/page/create', PageCrud::class)->name('admin.page.create');
    Route::get('/page/edit/{id}', PageCrud::class)->name('admin.page.edit'); 
    Route::get('/homepage-content', HomepageCrud::class)->name('admin.homepage');

});
   

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';