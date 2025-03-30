<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Auth\AuthenticateController;


// Route::prefix('admin')->group(function (): void {
//     Route::get('/', fn () => redirect()->route('admin.campaigns.index'));
//     Route::prefix('campaigns')->group(function (): void {
//         Route::get('/', [CampaignController::class, 'index'])->name('admin.campaigns.index');
//     });
// });

Route::get('/auth/callback', [AuthenticateController::class, 'handleCallback'])->name('sso.callback');
Route::get('/auth/redirect', [AuthenticateController::class, 'redirectToSSO'])->name('sso.redirect');
Route::post('/logout', [AuthenticateController::class, 'logout'])->name('handleLogout');

Route::middleware('auth.sso')->get('/', [CampaignController::class, 'index']); 



