<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Subsubcategoria;
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
        $subsubcategorias = Subsubcategoria::get()->all();

        $subcategorias = Subcategoria::get()->all();
        
        $categorias = Categoria::get()->all();

        View::share('subsubcategorias', $subsubcategorias);
        View::share('subcategorias', $subcategorias);
        View::share('categorias', $categorias);
    }
}
