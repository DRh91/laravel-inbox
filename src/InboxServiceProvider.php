<?php

namespace drhd\inbox;

use Illuminate\Support\ServiceProvider;

class InboxServiceProvider extends ServiceProvider {

    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

//        $this->loadViewsFrom($this->app->resourcePath('views/drhd/inbox'), 'drhd\inbox');

        $this->loadViewsFrom(__DIR__ . '/views', 'inbox');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
                             __DIR__ . '/views' => base_path('resources/views/drhd/inbox'),
                             __DIR__ . '/config' => config_path('inboxErrorMessages'),
                         ]);


    }

    public function register() {

        $this->mergeConfigFrom(
            __DIR__ . '/config/errorMessages.php', 'inboxErrorMessages'
        );


    }

}