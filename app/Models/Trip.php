<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PragmaRX\Countries\Package\Countries;

use Illuminate\Support\Facades\DB;

ini_set('memory_limit','1024M');

class Trip extends Model
{
    protected $table = 'trip';

    public function getcountryNameAttribute()
    {

        return Countries::where('cca2', $this->country)->first()->name_en;
    }

    public function getcountryFlagImojiAttribute()
    {

         return Countries::where('cca2', $this->country)->first()->flag->emoji;
    }

    public function getCountAgencyVehicleAttribute(){
        $vehicles = DB::table('trip_vehicle_pricing')
        ->where('trip_id', $this->id)
        ->where('private_price', "!=",0)
        ->get();

        return $vehicles->count();
    }

    public function getCountPublicVehicleAttribute(){
        $vehicles = DB::table('trip_vehicle_pricing')
        ->where('trip_id', $this->id)
        ->where('public_price', "!=",0)
        ->get();
        return $vehicles->count();
    }
}
