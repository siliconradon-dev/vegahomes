<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DesignInquiryController;
use App\Http\Controllers\Admin\DesignPackageController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DesignEstimateController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/projects', [PageController::class, 'projects'])->name('projects');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.store');

Route::post('/newsletter', [NewsletterController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('newsletter.store');

// Dream Home estimator (package popup) - submits enquiry to the admin panel
Route::post('/estimate', [EstimateController::class, 'store'])
    ->middleware('throttle:8,1')
    ->name('estimate.store');

// Architectural design-fee estimator (design package popup)
Route::post('/design-estimate', [DesignEstimateController::class, 'store'])
    ->middleware('throttle:8,1')
    ->name('design-estimate.store');

/*
|--------------------------------------------------------------------------
| TEMPORARY: Run migrations on server (no SSH access)
|--------------------------------------------------------------------------
| Usage:  https://vegahomes.lk/run-migrations
| Optional: ?seed=1 to run seeders, ?link=1 to create the storage link.
| !!! DELETE THIS BLOCK right after running it !!!
*/
Route::get('/run-migrations', function () {
    $output = [];

    Artisan::call('migrate', ['--force' => true]);
    $output[] = "== migrate ==\n" . Artisan::output();

    if (request()->boolean('seed')) {
        Artisan::call('db:seed', ['--force' => true]);
        $output[] = "== db:seed ==\n" . Artisan::output();
    }

    if (request()->boolean('link')) {
        Artisan::call('storage:link');
        $output[] = "== storage:link ==\n" . Artisan::output();
    }

    Artisan::call('optimize:clear');
    $output[] = "== optimize:clear ==\n" . Artisan::output();

    return response(implode("\n", $output), 200)
        ->header('Content-Type', 'text/plain');
})->middleware('throttle:3,1');

/*
|--------------------------------------------------------------------------
| Admin panel
|--------------------------------------------------------------------------
*/
// Named "login" because the Authenticate middleware redirects guests to route('login').
Route::get('/admin/login', [AuthController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware(['guest', 'throttle:10,1'])->name('login.attempt');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/export', [InquiryController::class, 'export'])->name('inquiries.export');
    Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/{inquiry}', [InquiryController::class, 'update'])->name('inquiries.update');
    Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');
    Route::get('/inquiries/{inquiry}/attachments/{attachment}', [InquiryController::class, 'attachment'])->name('inquiries.attachment');

    Route::resource('packages', PackageController::class)->except('show');

    Route::get('/design-inquiries', [DesignInquiryController::class, 'index'])->name('design-inquiries.index');
    Route::get('/design-inquiries/export', [DesignInquiryController::class, 'export'])->name('design-inquiries.export');
    Route::get('/design-inquiries/{inquiry}', [DesignInquiryController::class, 'show'])->name('design-inquiries.show');
    Route::patch('/design-inquiries/{inquiry}', [DesignInquiryController::class, 'update'])->name('design-inquiries.update');
    Route::delete('/design-inquiries/{inquiry}', [DesignInquiryController::class, 'destroy'])->name('design-inquiries.destroy');

    Route::resource('design-packages', DesignPackageController::class)
        ->parameters(['design-packages' => 'designPackage'])
        ->except('show');

    Route::resource('projects', ProjectController::class)->except('show');
    Route::patch('/projects/{project}/status', [ProjectController::class, 'status'])->name('projects.status');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}', [MessageController::class, 'toggle'])->name('messages.toggle');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
});

/*
|--------------------------------------------------------------------------
| Old static-site URLs -> new routes (keeps Google rankings / old links alive)
|--------------------------------------------------------------------------
*/
Route::redirect('/index.html', '/', 301);
Route::redirect('/about.html', '/about', 301);
Route::redirect('/Services.html', '/services', 301);
Route::redirect('/services.html', '/services', 301);
Route::redirect('/projects.html', '/projects', 301);
Route::redirect('/ContactUs.html', '/contact', 301);
Route::redirect('/contactus.html', '/contact', 301);
