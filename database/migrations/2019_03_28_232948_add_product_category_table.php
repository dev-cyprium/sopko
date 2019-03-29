<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories_pivot', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('product_id');

            $table->primary(['category_id', 'product_id']);
            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });

        Schema::table('products', function(Blueprint $table) {
            $table->dropForeign('products_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories_pivot');
        Schema::table('products', function(Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories');
        });
    }
}
