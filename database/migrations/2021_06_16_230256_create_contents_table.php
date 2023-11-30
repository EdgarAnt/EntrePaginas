<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Cambiado de 'name' a 'title' para mayor claridad
            $table->text('description');
            $table->string('author')->nullable(); // Agregado campo para el autor
            $table->string('publisher')->nullable(); // Agregado campo para la editorial
            $table->string('year', 4)->default('2000'); // Año de publicación
            $table->integer('pages')->nullable(); // Número de páginas
            $table->string('isbn', 13)->nullable(); // Número ISBN
            $table->string('image_path', 2048)->nullable(); // Portada del libro
            $table->string('link_path', 2048)->nullable(); // Enlace a más información o compra
            $table->decimal('price', 8, 2);
            $table->timestamp('updated_at')->nullable();        
            $table->timestamp('created_at')->default(Carbon::now()->toDateTimeString());
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
