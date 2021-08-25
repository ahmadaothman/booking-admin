<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SomeFixesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname',64);
            $table->string('middlename',64);
            $table->string('lastname',64);
            $table->string('nationality',8);
            $table->string('sex',6);
            $table->date('date_of_birthday')->nullable();
            $table->string('passport_number',64);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::table('booking', function($table) {
            $table->date('date_of_birthday')->after('sex')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_people');

        Schema::table('booking', function($table) {
            $table->dropColumn('date_of_birthday');
        });
    }
}
