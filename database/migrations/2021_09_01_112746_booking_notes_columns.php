<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BookingNotesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->string('one_way_pickup_note')->after('note')->nullable();
            $table->string('one_way_dropoff_note')->after('note')->nullable();
            $table->string('return_pickup_note')->after('note')->nullable();
            $table->string('return_dropoff_note')->after('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn('one_way_pickup_note');
            $table->dropColumn('one_way_dropoff_note');
            $table->dropColumn('return_pickup_note');
            $table->dropColumn('return_dropoff_note');
        });
    }
}
