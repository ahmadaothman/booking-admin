<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceDescriptionInUserBalance extends Migration
{
    public function up()
    {
        Schema::table('user_balance', function($table) {
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_balance', function($table) {
            $table->dropColumn('description');
        });
    }
}
