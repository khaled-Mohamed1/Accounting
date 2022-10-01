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
        Schema::create('notify_funds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fund_id')->unsigned();
            $table->foreign('fund_id')->references('id')->on('financial_funds')->onDelete('cascade');
            $table->float('old_amount_USD')->nullable();
            $table->float('new_amount_USD')->nullable();
            $table->float('old_amount_ILS')->nullable();
            $table->float('new_amount_ILS')->nullable();
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
        Schema::dropIfExists('notify_funds');
    }
};
