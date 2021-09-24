<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripBooking;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;

use Illuminate\Support\Facades\DB;
use PragmaRX\Countries\Package\Countries;

class TripBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $data = array();
        $data['users'] = User::where('user_type_id',2)->get();
        $bookings =  TripBooking::orderBy('id','DESC');

        if($request->get('filter_trip_type')){
            $bookings->where('trip_type',$request->get('filter_trip_type'));
        }

        if($request->get('filter_partner')){
            $bookings->where('agent_id',$request->get('filter_partner'));
        }

        if($request->get('filter_from')){
            $trip_ids = Trip::where('from_location',$request->get('filter_from'))->pluck('id')->toArray();

            $bookings->whereIn('trip_id',$trip_ids);
        }

        if($request->get('filter_to')){
            $trip_ids = Trip::where('to_location',$request->get('filter_to'))->pluck('id')->toArray();

            $bookings->whereIn('trip_id',$trip_ids);
        }

        if($request->get('filter_status')){
            $bookings->where('status',$request->get('filter_status'));
        }

    


        $data['bookings'] = $bookings->paginate(100);

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
    public function complete(Request $request){
        TripBooking::where('id',$request->input('complete_id'))->update(['status'=>3]);
        return redirect(route('Tripbooking'));
    }


    public function print(Request $request){
        $data = array();

        $booking_data = TripBooking::where('id',$request->get('id'))->first();
        

        if(!$booking_data){
          $data['trip_not_found'] = true;
          return view('trip_booking.print',$data);
        }

        $data['booking_data'] = $booking_data;
        $data['booking_number'] = $booking_data->id;
        $data['from']   = $booking_data->Trip->from_location;
        $data['to']   = $booking_data->Trip->to_location;
        $data['pickup_date'] = $booking_data->booking_date;
        $data['pickup_time'] = $booking_data->one_way_time;

        $data['return_from']   = isset($booking_data->RoundTrip->from_location ) ? $booking_data->RoundTrip->from_location : '';
        $data['return_to']   = isset($booking_data->RoundTrip->to_location) ? $booking_data->RoundTrip->to_location : '';
        $data['return_date'] = $booking_data->return_date;
        $data['return_time'] = $booking_data->return_time;

        $vehicle_price = $booking_data->Vehicle;
        $return_vehicle_price = $booking_data->ReturnVehicle;

        $vehicle = Vehicle::where('id',$vehicle_price->vehicle_id)->first();
        
        if($return_vehicle_price){
            $return_vehicle = Vehicle::where('id',$return_vehicle_price->vehicle_id)->first();
          
            $data['round_vehicle'] = $return_vehicle->name . " - " . $return_vehicle->description . " Max people " . $return_vehicle->max_people;
            $data['round_vehicle_price'] = $return_vehicle_price->price;
        }

        $data['one_way_vehicle'] = $vehicle->name . " - " . $vehicle->description . " Max people " . $vehicle->max_people;
        $data['one_way_vehicle_price'] = $vehicle_price->price;
        $data['pessengers'] = $booking_data->GetPessengers;

        $data['total'] = $vehicle_price->price + ($return_vehicle_price ? $return_vehicle_price->price : 0);
        $data['view'] = true;

        $data['user'] =  DB::table('users')->where('id', auth()->id())->first();

      

        $data['booking_trip'] = DB::table('trip')->where('id',$booking_data->trip_id)->first();
      
        $data['booking_return_trip'] = DB::table('trip')->where('id',$booking_data->return_trip_id)->first();

        return view('trip_booking.print',$data);
    }
}
