<?php

use App\Models\Merchant;
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
        Schema::create('merchant_operation_day_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Merchant::class);
            $table->integer('day');
            $table->time('start_time')->default('08:00');
            $table->time('end_time')->default('22:00');
            $table->unique(['merchant_id', 'day']);
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
        Schema::dropIfExists('merchant_operation_day_settings');
    }
};
