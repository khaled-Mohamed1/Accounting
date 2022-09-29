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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('transaction_NO')->nullable();
            $table->string('remittance_type')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('currency_type')->nullable();
            $table->float('amount')->nullable();
            $table->float('delivery_ILS')->default('0');
            $table->float('delivery_USD')->default('0');
            $table->float('profit_ILS')->default('0');
            $table->float('profit_USD')->default('0');
            $table->float('percent')->default('0');
            $table->float('numerical')->default('0');
            $table->float('dollar')->default('0');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('reports');
    }
};
