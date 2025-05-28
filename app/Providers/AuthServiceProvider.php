<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\GroupOfficial;
use App\Policies\ReportPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        GroupOfficial::class => ReportPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
