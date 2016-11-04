<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SleepingOwl\Admin\Contracts\Widgets\WidgetsRegistryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $widgets = [
        \App\Widgets\DashboardMap::class,
        \App\Widgets\NavigationUserBlock::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var WidgetsRegistryInterface $widgetsRegistry */
        $widgetsRegistry = $this->app[WidgetsRegistryInterface::class];

        foreach ($this->widgets as $widget) {
            $widgetsRegistry->registerWidget($widget);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
