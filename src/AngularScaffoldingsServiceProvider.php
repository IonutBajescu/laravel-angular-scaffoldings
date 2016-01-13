<?php

namespace Ionut\LaravelAngularScaffoldings;


use Illuminate\Support\ServiceProvider;
use Ionut\LaravelAngularScaffoldings\Console\MakeCommand;

class AngularScaffoldingsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(MakeCommand::class);
    }
}