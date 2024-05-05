<?php

namespace App\Providers;

use App\Services\SMSService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SMSServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SMSService::class, function (Application $app) {
            $smsProviderName = config('services.sms_provider','first_sms_provider');
            return new SMSService(config("services.$smsProviderName.url"));
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [SMSService::class];
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
