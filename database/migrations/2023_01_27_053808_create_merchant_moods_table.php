<?php

use App\Models\Merchant;
use App\Models\Mood;
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
        Schema::create('merchant_moods', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Merchant::class);
            $table->foreignIdFor(Mood::class);
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
        Schema::dropIfExists('merchant_moods');
    }
};
