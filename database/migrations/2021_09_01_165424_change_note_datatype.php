<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNoteDatatype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->string('one_way_pickup_note')->after('note')->nullable()->change();
            $table->string('one_way_dropoff_note')->after('note')->nullable()->change();
            $table->string('return_pickup_note')->after('note')->nullable()->change();
            $table->string('return_dropoff_note')->after('note')->nullable()->change();
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
    }
}
