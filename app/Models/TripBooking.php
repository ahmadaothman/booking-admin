<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TripBooking extends Model
{
    protected $table = 'booking';

    public function getTripAttribute(){
        $trip = DB::table('trip')->where('id', $this->trip_id)->first();

        return $trip;
    }

    public function getPartnerAttribute(){
        $agent = DB::table('users')->where('id', $this->agent_id)->first();

        return $agent;
    }
}
