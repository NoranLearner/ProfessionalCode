<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Offers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Offers', function (Blueprint $table){
            $table->id();
            $table->char('name_ar', 100);
            $table->char('name_en', 100);
            $table->char('price', 20);
            $table ->text('details_ar');
            $table ->text('details_en');
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
        Schema::dropIfExists('Offers');
    }
}
