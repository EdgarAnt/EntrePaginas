<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->foreignId('requester_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('owner_user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('year', 4)->nullable();
            $table->integer('pages')->nullable();
            $table->string('isbn', 13)->nullable();
            $table->string('image_path', 2048)->nullable(); // Asumiendo que quieres almacenar la ruta de la imagen
            $table->string('condition');
            $table->string('status')->default('pending');
            $table->text('offer_message')->nullable();
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
        Schema::dropIfExists('book_exchanges');
    }
}
