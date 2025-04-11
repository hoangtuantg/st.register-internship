<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\RoleController;


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
            Route::get('/{campaign}', [CampaignController::class, 'show'])->name('admin.campaigns.show');
        });

        Route::prefix('plans')->group(function (): void {
            Route::get('/', [PlanController::class, 'index'])->name('admin.plans.index');
            Route::get('/create', [PlanController::class, 'create'])->name('admin.plans.create');
            Route::get('/{plan}/edit', [PlanController::class, 'edit'])->name('admin.plans.edit');
            Route::get('/{plan}', [PlanController::class, 'show'])->name('admin.plans.show');
            Route::get('/{plan}/detail/create', [PlanController::class, 'createPlanDetail'])->name('admin.plans.createPlanDetail');
            Route::get('/{planDetail}/detail/edit', [PlanController::class, 'editPlanDetail'])->name('admin.plans.editPlanDetail');
        });

        Route::prefix('companies')->group(function (): void {
            Route::get('/', [CompanyController::class, 'index'])->name('admin.companies.index');
            Route::get('/create', [CompanyController::class, 'create'])->name('admin.companies.create');
            Route::get('/edit/{company}', [CompanyController::class, 'edit'])->name('admin.companies.edit');
        });

        Route::prefix('company-campaigns')->group(function (): void {
            Route::get('/', [CompanyController::class, 'companyCampaignIndex'])->name('admin.company-campaign.index');
            Route::get('/{campaign}/show', [CompanyController::class, 'companyCampaignShow'])->name('admin.company-campaign.show');
            Route::get('/{campaign}/edit/{company}', [CompanyController::class, 'companyCampaignEdit'])->name('admin.company-campaign.edit');
        });
        Route::resource('roles', RoleController::class)->only(['index','create','edit']);
    });

    Route::get('/faculty/select', function () {
        return view('livewire.commons.faculty-selected');
    })->name('faculty.select');
});
