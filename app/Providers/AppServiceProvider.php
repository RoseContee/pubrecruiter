<?php

namespace App\Providers;

use App\Models\Setting;
use App\Rules\Metric;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('metric', function ($attribute, $value, $parameters, $validator) {
            $validator->addReplacer('metric', function($message, $attribute, $rule, $parameters) {
                return str_replace(':metric', $parameters[0], $message);
            });
            return (new Metric())->passes($attribute, $value);
        });
        /*Validator::replacer('metric', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':metric', $parameters[0], $message);
        });*/

        View::share('setting', Setting::getSetting());
    }
}
