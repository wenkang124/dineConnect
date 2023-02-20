<?php

use App\Models\MenuCategory;
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
        Schema::create('menu_food_menu_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MenuFood::class);
            $table->foreignIdFor(MenuCategory::class);
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
        Schema::dropIfExists('menu_food_menu_categories');
    }
};
