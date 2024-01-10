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
        // Schema::table('topics', function (Blueprint $table) {
        //     //
        // });
        Schema::table('topics', function (Blueprint $table) {
            $table->integer('provided_feedback')->nullable();
            $table->integer('remaining_feedback')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn(['provided_feedback', 'remaining_feedback']);
        });
    }
};
