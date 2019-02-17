<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('brand_id');
            $table->unsignedInteger('category_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands');
            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories');
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
        Schema::dropIfExists('products');
    }
}
