<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferedBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offered_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('year', 4)->default('2000');
            $table->integer('pages')->nullable();
            $table->string('isbn', 13)->nullable();
            $table->string('image_path', 2048)->nullable();
            $table->string('condition'); // Agregar opciones específicas si es necesario
            $table->timestamps(); // Incluye created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offered_books');
    }
}
