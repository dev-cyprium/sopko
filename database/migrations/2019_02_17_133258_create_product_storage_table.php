<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_storages', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('storage_id');
            $table->unsignedInteger('quantity');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->foreign('storage_id')
                ->references('id')
                ->on('storages');
            $table->primary(['product_id', 'storage_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_storages');
    }
}
