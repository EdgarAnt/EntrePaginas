<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // El usuario que ofrece el libro
            $table->string('title');
            $table->text('description');
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('year', 4)->nullable();
            $table->integer('pages')->nullable();
            $table->string('isbn', 13)->nullable();
            $table->string('image_path', 2048)->nullable(); // Ruta de la imagen de la portada del libro
            $table->string('condition'); // Condición del libro
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_offers');
    }
}
