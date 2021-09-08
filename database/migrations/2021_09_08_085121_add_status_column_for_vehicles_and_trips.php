<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnForVehiclesAndTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle', function (Blueprint $table) {
            $table->boolean('status')->nullable()->default(true);
          
        });
         Schema::table('trip', function (Blueprint $table) {
            $table->boolean('status')->nullable()->default(true);
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
