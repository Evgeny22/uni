<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Composers\MessageListComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        view()->composer(['pages.dashboard', 'messages.index'], MessageListComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
