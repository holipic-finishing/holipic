<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(255);

        URL::forceScheme('https');

        /*
           Register custom validators
        */
        try{

            // Check data request with image64 data type
            Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
                try{
                    $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];

                    if (in_array($type, $parameters)) {
                        return true;
                    }
                } catch (\Exception $e){
                    return false;
                }

                return false;
            });

            Validator::replacer('image64', function($message, $attribute, $rule, $parameters) {
                return str_replace(':values',join(",",$parameters), $message);
            });

        } catch (\Exception $e){

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }
}
