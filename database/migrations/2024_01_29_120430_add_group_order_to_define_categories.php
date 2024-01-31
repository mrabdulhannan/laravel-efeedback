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
        Schema::table('define_categories', function (Blueprint $table) {
            //
            $table->integer('group_order')->after('group')->nullable(); // Replace 'existing_column_name' with the column after which you want to add 'group_order'
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('define_categories', function (Blueprint $table) {
            //
            $table->dropColumn('group_order');
        });
    }
};
