<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('marca')->nullable();
            $table->string('modelo');
            $table->string('titulo');
            $table->integer('precio');
            $table->string('peso')->nullable();
            $table->integer('tramos')->nullable();
            $table->integer('tramos_mts')->nullable();
            $table->integer('pcs')->nullable();
            $table->foreignId('subcategoria_id')->constrained('subcategorias');
            $table->foreignId('sobremodelo_id')->constrained('sobremodelos');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
