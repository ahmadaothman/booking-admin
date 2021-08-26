<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BookingIdBookingPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_people', function($table) {
            $table->bigInteger('booking_id');
        });

        Schema::table('booking', function($table) {
            $table->bigInteger('trip_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_people', function($table) {
            $table->dropColumn('booking_id');
        });

        Schema::table('booking', function($table) {
            $table->dropColumn('trip_id');
        });
    }
}
