<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PlanController;


// Route::prefix('admin')->group(function (): void {
//     Route::get('/', fn () => redirect()->route('admin.campaigns.index'));
//     Route::prefix('campaigns')->group(function (): void {
//         Route::get('/', [CampaignController::class, 'index'])->name('admin.campaigns.index');
//     });
// });

Route::get('/auth/callback', [AuthenticateController::class, 'handleCallback'])->name('sso.callback');
Route::get('/auth/redirect', [AuthenticateController::class, 'redirectToSSO'])->name('sso.redirect');
Route::post('/logout', [AuthenticateController::class, 'logout'])->name('handleLogout');

Route::middleware('auth.sso')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->group(function (): void {
        Route::prefix('campaigns')->group(function (): void {
            Route::get('/', [CampaignController::class, 'index'])->name('admin.campaigns.index');
            Route::get('/create', [CampaignController::class, 'create'])->name('admin.campaigns.create');
            Route::get('/{campaign}/edit', [CampaignController::class, 'edit'])->name('admin.campaigns.edit');
        });

        Route::prefix('plans')->group(function (): void {
            Route::get('/', [PlanController::class, 'index'])->name('admin.plans.index');
            Route::get('/create', [PlanController::class, 'create'])->name('admin.plans.create');
            Route::get('/{plan}/edit', [PlanController::class, 'edit'])->name('admin.plans.edit');
            Route::get('/{plan}', [PlanController::class, 'show'])->name('admin.plans.show');
            Route::get('/{plan}/detail/create', [PlanController::class, 'createPlanDetail'])->name('admin.plans.createPlanDetail');
            Route::get('/{planDetail}/detail/edit', [PlanController::class, 'editPlanDetail'])->name('admin.plans.editPlanDetail');
        });
        
    });

    Route::get('/faculty/select', function () {
        return view('livewire.commons.faculty-selected');
    })->name('faculty.select');
});
