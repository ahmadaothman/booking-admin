<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripBooking;

class TripBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = array();

        $bookings =  TripBooking::orderBy('id');

        $data['bookings'] = $bookings->paginate(15);

        return view('trip_booking.list',$data);
    }
}
