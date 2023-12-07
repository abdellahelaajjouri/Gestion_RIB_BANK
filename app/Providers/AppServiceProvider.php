<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Rules\RibFormatRule;
use Illuminate\Support\Facades\Validator;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('rib_format', function ($attribute, $value, $parameters, $validator) {
            $longueur = $parameters[0];
            $chaine = $value;
            $rule = new RibFormatRule($longueur, $chaine);
            return $rule->passes($attribute, $value);
        });
    }   
}
