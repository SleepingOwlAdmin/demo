<?php

namespace App\Providers;

use SleepingOwl\Admin\Facades\AdminTemplate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Model\Contact::class => \App\Policies\ContactPolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        view()->composer(AdminTemplate::getTemplateViewPath('_partials.header'), function($view) {
            $view->getFactory()->inject(
                'navbar.right', view('auth.partials.navbar')
            );
        });
    }
}
