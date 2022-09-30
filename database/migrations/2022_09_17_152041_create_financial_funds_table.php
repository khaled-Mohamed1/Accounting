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
        Schema::create('financial_funds', function (Blueprint $table) {
            $table->id();
            $table->float('financial_amount_ILS')->default(0);
            $table->float('financial_amount_USD')->default(0);
            $table->float('financial_ILS')->default(0);
            $table->float('financial_USD')->default(0);
            $table->boolean('is_delete')->default(false);
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
        Schema::dropIfExists('financial_funds');
    }
};
