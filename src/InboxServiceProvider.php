<?php

namespace drhd\inbox;

use Illuminate\Support\ServiceProvider;

class InboxServiceProvider extends ServiceProvider {

    public function boot() {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/views', 'inbox');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
                             // Views
                             __DIR__.'/views/newMessage.blade.php' => resource_path('views/drhd/inbox/newMessage.blade.php'),
                             __DIR__.'/views/index.blade.php' => resource_path('views/drhd/inbox/index.blade.php'),
                             __DIR__.'/views/createForm.blade.php' => resource_path('views/drhd/inbox/createForm.blade.php'),
                             __DIR__.'/views/conversation.blade.php' => resource_path('views/drhd/inbox/conversation.blade.php'),
                             __DIR__.'/views/conversations.blade.php' => resource_path('views/drhd/inbox/conversations.blade.php'),
                             
                             __DIR__ . '/config' => config_path('inboxErrorMessages'),
                         ]);


    }

    public function register() {

        $this->mergeConfigFrom(
            __DIR__ . '/config/errorMessages.php', 'inboxErrorMessages'
        );


    }

}