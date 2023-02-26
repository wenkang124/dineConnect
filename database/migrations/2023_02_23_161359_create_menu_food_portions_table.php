<?php

use App\Models\MenuFood;
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
        Schema::create('menu_food_portions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MenuFood::class);
            $table->string('size');
            $table->string('portion_serving');
            $table->string('description');
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
        Schema::dropIfExists('menu_food_portions');
    }
};
