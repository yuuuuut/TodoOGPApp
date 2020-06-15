<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class DateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'user.show', function($view) {
                $tomorrow = Carbon::tomorrow();
                $min_date = $tomorrow->format('Y-m-d');
                $view->with('min_date', $min_date);
            }
        );
    }
}
