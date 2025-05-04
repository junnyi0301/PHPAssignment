<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->string('area');
            $table->text('street_number');
            $table->text('house_number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_orders');
    }
};