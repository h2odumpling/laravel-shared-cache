<?php

namespace H2o\SharedCache;

use H2o\SharedCache\Events\ModelSaved;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class SharedCacheServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/shared-cache.php',
            'shared-cache'
        );
        //
        $this->app->singleton('shared_cache', function($app) {
            return new SharedCache();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/shared-cache.php' => config_path('shared-cache.php'),
        ], 'config');

        Event::listen(function (ModelSaved $event) {
            $model = $event->model;
            foreach ($model->getSharedChannels() as $channel){
                $channel = new $channel;

                $key_name = implode('_', $model->only($channel->getKeys()));

                $channel->forget($key_name);
            }
        });
    }

}
