<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comic_id')->constrained();
            $table->string('identificator', 10);
            $table->string('name', 150)->nullable();
            $table->string('distributor_sku', 15)->nullable();
            $table->string('upc', 20)->nullable();
            $table->string('cover_path')->nullable();
            $table->float('cover_price')->nullable();
            $table->string('release_date', 7)->nullable();
            $table->timestamps();

            $table->unique(['comic_id', 'identificator']);
            $table->unique('distributor_sku');
            $table->unique('upc');
            $table->unique('cover_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('covers');
    }
}
