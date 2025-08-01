<?php
// App\Providers\ViewServiceProvider.php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Usar un View Composer para compartir datos con todas las vistas
        View::composer('*', function ($view) {
            //$company = Auth::user()->company; // Asumiendo que el usuario está autenticado y tiene una relación con la empresa
            //$reports = $company->reports;
            //$view->with('reports', $reports);
        });
    }

    public function register()
    {
        //
    }
}