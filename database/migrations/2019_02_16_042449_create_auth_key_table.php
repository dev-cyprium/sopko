<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_keys', function (Blueprint $table) {
            $table->string('hash', 500)->primary();
            $table->unsignedInteger('account_id');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
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
        Schema::dropIfExists('auth_keys');
    }
}
