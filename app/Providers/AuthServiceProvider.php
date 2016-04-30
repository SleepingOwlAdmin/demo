<?php

namespace App\Providers;

use AdminTemplate;
use App\Permission;
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
        \App\Model\Contact::class => \App\Policies\ContactPolicy::class,
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Role::class => \App\Policies\RolePolicy::class
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

        // Dynamically register permissions with Laravel's Gate.
        //
        // foreach ($this->getPermissions() as $permission) {
        //    $gate->define($permission->name, function ($user) use ($permission) {
        //        return $user->hasPermission($permission);
        //    });
        // }

        /**
         * HACK This kills all tests. No idea as to why.
         */
        //view()->composer(AdminTemplate::getViewPath('_partials.header'), function($view) {
        //    $view->getFactory()->inject(
        //        'navbar.right', view('auth.partials.navbar')
        //    );
        //});
    }

    /**
     * Fetch the collection of site permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
