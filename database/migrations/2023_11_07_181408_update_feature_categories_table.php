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
        //
        Schema::table('feature_categories', function (Blueprint $table) {
            $table->integer("sequence")->after('name');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('feature_categories', function (Blueprint $table) {
            $table->dropColumn('sequence');
            $table->dropColumn('deleted_at');
        });
    }
};
