<?php

namespace App\Providers\Filament;

use DutchCodingCompany\FilamentSocialite\Facades\FilamentSocialite as FilamentSocialiteFacade;
use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class SsoFilamentProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        FilamentSocialiteFacade::class::setCreateUserCallback(
            fn(SocialiteUserContract $oauthUser, FilamentSocialite $socialite) => $socialite->getUserModelClass()::create([
                'name' => $oauthUser->getNickname(),
                'email' => $oauthUser->getEmail(),
                'email_verified_at' => Carbon::now(),
            ])
        );
    }
}
