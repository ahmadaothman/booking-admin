<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripBooking;
use Illuminate\Support\Facades\DB;

class TripBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = array();

        $bookings =  TripBooking::orderBy('id','DESC');

        $data['bookings'] = $bookings->paginate(15);

        return view('trip_booking.list',$data);
    }

    public function form(Request $request){
        $data = array();
        $booking = TripBooking::where('id',$request->get('id'))->first();
        
        $data['booking'] = $booking;

        $vehicles_price = DB::table('booking_vehicles')->where('booking_id',$request->get('id'))->get();

        $data['one_way_trip'] = DB::table('trip')->where('id',$booking->trip_id)->first();
        $data['round_trip'] = DB::table('trip')->where('id',$booking->return_trip_id)->first();

        foreach($vehicles_price as $price){
            $vehicle_price = $price->price;
            $vehicle_id = $price->vehicle_id;

            $trip_type = $price->trip_type;

            if($trip_type == 'one_way'){
                $data['one_way_vehicle'] = DB::table('vehicle')->where('id',$vehicle_id)->first();
                $data['one_way_price'] = $vehicle_price;
            }

            if($trip_type == 'return'){
                $data['return_vehicle'] = DB::table('vehicle')->where('id',$vehicle_id)->first();
                $data['return_price'] = $vehicle_price;
            }
        }

        $data['pessengers'] = DB::table('booking_people')->where('booking_id',$request->get('id'))->first();
        
        dd($data);

        return view('trip_booking.form',$data);
    }
}
