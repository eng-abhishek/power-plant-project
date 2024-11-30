<?php

namespace App\Providers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* Load api services credentials */
        $this->app->singleton('api_services', function () {
            $api_services = \App\Models\ApiService::get();

            $credentials_arr = [];
            foreach($api_services as $value){
                $credentials_arr[$value->slug] = json_decode($value->credentials, true);
            }

            return $credentials_arr;
        });

        /* Index now */
        $this->app->singleton('indexnow', \App\Libraries\IndexNow::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        //Validate current password
        \Validator::extend('match_current_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, auth()->user()->password);
        },'Current password does not match with existing password.');

        //Validate letters and spaces
        \Validator::extend('alpha_spaces', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[\pL\s]+$/u', $value);
        },'The :attribute may only contain letters and spaces.');

        //Validate white spaces
        \Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
    }
}
