<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAirportNoteToTrip extends Migration
{
   
    public function up()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->string('airport_note')->nullable()->default(null);
        });
    }

  
    public function down()
    {
        Schema::table('trip', function (Blueprint $table) {
            $table->dropColumn('airport_note');
        });
    }
}
