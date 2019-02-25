<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('path', 300);
            $table->timestamps();
        });

        Schema::create('imaggables', function (Blueprint $table) {
            $table->unsignedInteger('image_id');
            $table->unsignedInteger('imaggable_id');
            $table->string('imaggable_type');
            $table->primary(['image_id', 'imaggable_id']);
            $table->foreign('image_id')
                  ->references('id')
                  ->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('imaggables');
    }
}
