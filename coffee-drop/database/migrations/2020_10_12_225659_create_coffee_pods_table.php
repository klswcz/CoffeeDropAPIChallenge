<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoffeePodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffee_pods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('value_below_50_items');
            $table->integer('value_between_50_and_500_items');
            $table->integer('value_above_500_items');
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
        Schema::dropIfExists('coffee_pods');
    }
}
