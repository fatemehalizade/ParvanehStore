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
        Schema::table('product_infos', function (Blueprint $table) {
            $table->index("category_id");
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->index("brand_id");
            $table->foreignId('brand_id')->references('id')->on('brands')->onDelete('cascade')->onUpdate('cascade');
            $table->index("producer_id");
            $table->foreignId('producer_id')->references('id')->on('producers')->onDelete('cascade')->onUpdate('cascade');
            $table->index("package_type_id");
            $table->foreignId('package_type_id')->references('id')->on('package_types')->onDelete('cascade')->onUpdate('cascade');
            $table->index("product_id");
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_infos', function (Blueprint $table) {
            //
        });
    }
};
