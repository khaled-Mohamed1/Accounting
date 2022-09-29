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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('ID_NO')->unique();
            $table->string('phone_NO')->unique();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->boolean('c_update')->default(false);
            $table->boolean('c_delete')->default(false);
            $table->boolean('status_log')->default(false);
            $table->time('start_log')->nullable();
            $table->time('end_log')->nullable();
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
