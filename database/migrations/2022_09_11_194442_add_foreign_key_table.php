<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factor_order', function (Blueprint $table) {
            $table->index("factor_id");
            $table->foreignId('factor_id')->references('id')->on('factors')->onDelete('cascade')->onUpdate('cascade');
            $table->index("order_id");
            $table->foreignId('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factor_order', function (Blueprint $table) {
            //
        });
    }
};
