<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class repositoryServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
            'App\Http\Interfaces\AuthInterface',
            'App\Http\Repositories\AuthRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\forgetPasswordInterface',
            'App\Http\Repositories\forgetPasswordRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\AdminInterface',
            'App\Http\Repositories\AdminRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\TypesInterface',
            'App\Http\Repositories\TypesRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\CasesInterface',
            'App\Http\Repositories\CasesRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\CompanyInterface',
            'App\Http\Repositories\CompanyRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\TaskInterface',
            'App\Http\Repositories\TaskRepository'
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
