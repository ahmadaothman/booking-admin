<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('telephone', 32)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->double('balance',8,2)->nullable()->default(0);
            $table->bigInteger('user_type_id')->references('id')->on('user_type')->nullable()->default(0);
            $table->string('password');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('user_type', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('name',64);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('vehicle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',64);
            $table->string('description')->nullable();
            $table->bigInteger('max_people');
            $table->double('price',8,2)->nullable()->default(0);
            $table->bigInteger('sort_order');
            $table->string('image')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('vehicle_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->integer('vehicle_id');
            $table->integer('sort_order');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

   
        Schema::create('trip', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('country',8);
            $table->string('from_location');
            $table->string('to_location');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('trip_vehicle_pricing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trip_id');
            $table->bigInteger('vehicle_id');
            $table->double('public_price',8,2);
            $table->double('private_price',8,2);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('booking', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname',64);
            $table->string('middlename',64);
            $table->string('lastname',64);
            $table->string('nationality',8);
            $table->string('address');
            $table->string('sex',6);
            $table->string('telephone',64);
            $table->string('passport_number',64);
            $table->string('id_image');
            $table->bigInteger('number_of_people');
            $table->timestamp('booking_date');
            $table->string('status',64);
            $table->string('booking_type',64);
            $table->bigInteger('agent_id')->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('booking_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_id');
            $table->bigInteger('trip_id');
            $table->double('amount');
            $table->string('notes');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

    }
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_type');
        Schema::dropIfExists('vehicle');
        Schema::dropIfExists('vehicle_image');
        Schema::dropIfExists('trip');
        Schema::dropIfExists('trip_vehicle_pricing');
        Schema::dropIfExists('booking');
        Schema::dropIfExists('booking_trips');

    }
}
