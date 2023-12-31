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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('full_name');
            $table->string('national_code',10);
            $table->string('mobile_number',13);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('user_name',20)->unique();
            $table->string('password',20)->unique();
            $table->string("api_token")->unique();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
