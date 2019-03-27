<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('product_id');
            $table->string('group_slug')->nullable();
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products');
            $table->foreign('group_slug')
                  ->references('slug')
                  ->on('user_groups');
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
        Schema::dropIfExists('product_prices');
    }
}
