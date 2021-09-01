<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripBooking;
use Illuminate\Support\Facades\DB;
use PragmaRX\Countries\Package\Countries;

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

        $data['pessengers'] = DB::table('booking_people')->where('booking_id',$request->get('id'))->get();
        
       // dd($data);

       $countries = new Countries();
       //dd($countries->all()->toArray());
       $data['countries'] = $countries->all()->toArray();

       if($request->method() == 'POST'){
           $booking_data = [
               'firstname'  =>  $request->input('firstname'),
               'middlename'  =>  'none',
               'lastname'  =>  'none',
               'nationality'  =>  $request->input('nationality'),
               'sex'  =>  'none',
               'date_of_birthday'  =>  $request->input('date_of_birthday'),
               'telephone'  =>  $request->input('telephone'),
               'email'  =>  $request->input('email'),
               'passport_number'  =>  $request->input('passport_number'),
               'number_of_people'  =>  $request->input('number_of_people'),
               'booking_date'  =>  $request->input('booking_date'),
               'one_way_time'  =>  $request->input('one_way_time'),
               'trip_number_main'  =>  $request->input('fly_number'),
               'trip_arrival_time'    =>   $request->input('fly_arrival_time'),
               'one_way_pickup_note'    => $request->input('one_way_pickup_note'),
               'one_way_dropoff_note'    => $request->input('one_way_dropoff_note'),
               'return_pickup_note'    => $request->input('return_pickup_note'),
               'return_dropoff_note'    => $request->input('return_dropoff_note'),
               'return_date'    =>   $request->input('return_date'),
               'return_time'    =>   $request->input('return_time'),
           ];
           TripBooking::where('id',$request->get('id'))->update($booking_data);
           DB::table('booking_people')->where('booking_id',$request->get('id'))->delete();
           foreach($request->input('pessenger') as $key => $value){
               $pessenger_data = [
                   'firstname'          =>  $request->input('pessenger')[$key]['firstname'],
                   'middlename'         =>  'none',
                   'lastname'           =>  'none',
                   'nationality'        =>  $request->input('pessenger')[$key]['nationality'],
                   'sex'                =>  'none',
                   'passport_number'    =>  'none',
                   'booking_id'         =>  $request->get('id')
               ];
               DB::table('booking_people')->insert($pessenger_data);
           }
           return redirect(route('Tripbooking'));
       }

        return view('trip_booking.form',$data);
    }

    public function cancel(Request $request){
        $booking = TripBooking::where('id',$request->input('id'))->first();
        $vehicles =  DB::table('booking_vehicles')->where('booking_id',$request->input('id'))->get();

        $total = 0;

        foreach($vehicles as $vehicle){
            $total = $total + $vehicle->price;
        }

        $user = DB::table('users')->where('id',$booking->agent_id)->first();
        $user_balance = $user->balance + $total;

        DB::table('user_balance')->insert([
            'user_id'       =>  $user->id,
            'balance'       =>  $total,
            'action'        =>  '+',
            'description'   =>  'Booking Number ' . $booking->id . ' Cancelled'
        ]);
        
        DB::table('users')->where('id',$booking->agent_id)->update(['balance'=>$user_balance]);

        TripBooking::where('id',$request->input('id'))->update(['status'=>2]);


        return redirect(route('Tripbooking'));
    }
}
