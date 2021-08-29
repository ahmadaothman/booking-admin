<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalInfoToTripBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->string('note')->nullable()->after('booking_date');
            $table->time('one_way_time')->nullable()->after('booking_date');

            $table->dateTime('return_date')->nullable()->after('booking_date');
            $table->time('return_time')->nullable()->after('booking_date');
            $table->string('return_note')->nullable()->after('booking_date');
            $table->time('trip_arrival_time')->nullable()->after('booking_date');

        });
    }

    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->dropColumn('one_way_time');
            $table->dropColumn('return_date');
            $table->dropColumn('return_time');
            $table->dropColumn('return_note');
            $table->dropColumn('trip_arrival_time');
        });
    }
}
