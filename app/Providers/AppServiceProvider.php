<?php

namespace App\Providers;

use App\View\Components\Money;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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
        Paginator::useBootstrapFour();
        Relation::enforceMorphMap([
            'subcategory' => 'App\Models\SubCategory',
            'category' => 'App\Models\Category',
        ]);

        Blade::component('money', Money::class);
    }
}
