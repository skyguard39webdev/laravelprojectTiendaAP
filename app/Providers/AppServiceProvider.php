<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Subcategoria;
use App\Models\Categoria;
use View;

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
    public function boot() //con esta funcion compartimos datos en todas las Views
    {
        $subcategorias = Subcategoria::get()->all();
        
        $categorias = Categoria::get()->all();

        View::share('subcategorias', $subcategorias);
        View::share('categorias', $categorias);
    }
}
