<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Vehicle;

use Illuminate\Support\Facades\Hash;
use PragmaRX\Countries\Package\Countries;
use Stevebauman\Location\Facades\Location;

use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request){
        $data = array();

        $trips =  Trip::where('status',true)->orderBy('id');

        if($request->get('filter_from')){

            $trips->where('from_location','LIKE','%'.$request->get('filter_from') . '%');
        }

        if($request->get('filter_to')){

            $trips->where('to_location','LIKE','%'.$request->get('filter_to') . '%');
        }

        if($request->get('filter_is_airport') != null){
            
           if($request->get('filter_is_airport') == "1"){
            $trips->where('is_airport',1);
           }else{
            $trips->where('is_airport','!=',1);
           }
        }

        $data['trips'] = $trips->paginate(25);

        return view('trips.list',$data);
    }

    public function form(Request $request){
        $data = array();

        $data['country_code'] = '';
        $countries = new Countries();

        $data['countries'] = $countries->all()->toArray();


        $vehicles = Vehicle::where('status',true)->get();
        $vehicles = $vehicles->toArray();

        if($request->path() == 'trips/edit'){
            $data['trip'] = Trip::where('id', $request->get('id'))->first();

            $trip_vehicles = DB::table('trip_vehicle_pricing')
            ->join('vehicle', 'trip_vehicle_pricing.vehicle_id', '=', 'vehicle.id')
            ->where('vehicle.status',true)
            ->where('trip_id', $request->get('id'))->get();
            
            $trip_vehicles = $trip_vehicles->toArray();
        

            foreach($trip_vehicles as $trip_vehicle){
               
                foreach($vehicles as $key => $value){
                    if($trip_vehicle->vehicle_id == $value['id']){
                      
                        $vehicles[$key]['public_price'] = $trip_vehicle->public_price;
                        $vehicles[$key]['private_price'] = $trip_vehicle->private_price;
                    }
                }
            }

        }

        $data['vehicles'] = $vehicles;

        if($request->method() == 'POST'){
            $validation_data =  array();
            
            $validation_data['from_location'] = 'required|min:3';
            $validation_data['to_location'] = 'required|min:3';
            $validated = $request->validate($validation_data);

            $trip_data = [
                'country'       =>  $request->input('country'),
                'from_location' =>  $request->input('from_location'),
                'to_location'   =>  $request->input('to_location'),
                'is_airport'    =>  $request->input('is_airport') ? true : false,
                'airport_note'  =>  $request->input('airport_note'),
                'updated_at'    =>  now()
            ];

            if($request->path() == 'trips/add'){
               
                $id = Trip::insertGetId($trip_data);
              
                foreach($request->input('vehicle') as $key => $value){
                    $vehicle_data = [
                        'trip_id'       =>  $id,
                        'vehicle_id'    =>  $key,
                        'public_price'  => empty($value['public_price']) ? 0 : $value['public_price'],
                        'private_price' => empty($value['private_price']) ? 0 : $value['private_price']
                    ]; 

                    DB::table('trip_vehicle_pricing')->insert($vehicle_data);
                }
                
                $trip_data = [
                    'country'       =>  $request->input('country'),
                    'from_location' =>  $request->input('to_location'),
                    'to_location'   =>  $request->input('from_location'),
                    'updated_at'    =>   now()
                ];

                $id = Trip::insertGetId($trip_data);

                foreach($request->input('vehicle') as $key => $value){
                    $vehicle_data = [
                        'trip_id'       =>  $id,
                        'vehicle_id'    =>  $key,
                        'public_price'  => empty($value['public_price']) ? 0 : $value['public_price'],
                        'private_price' => empty($value['private_price']) ? 0 : $value['private_price']
                    ]; 

                    DB::table('trip_vehicle_pricing')->insert($vehicle_data);
                }

                return redirect('/trips')->with('status', '<strong>Success:</strong> New Trip Added!');

            }else if($request->path() == 'trips/edit'){
                $trip_data = [
                    'country'       =>  $request->input('country'),
                    'from_location' =>  $request->input('from_location'),
                    'to_location'   =>  $request->input('to_location'),
                    'is_airport'    =>  $request->input('is_airport') ? true : false,
                    'airport_note'  =>  $request->input('airport_note'),
                    'updated_at'    =>  now()
                ];
                
                Trip::where('id',$request->get('id'))->update($trip_data);
                Trip::where('from_location',$request->input('from_location'))->update(['airport_note'=>$request->input('airport_note')]);
                DB::table('trip_vehicle_pricing')->where('trip_id',$request->get('id'))->delete();

                foreach($request->input('vehicle') as $key => $value){
                    $vehicle_data = [
                        'trip_id'       =>  $request->get('id'),
                        'vehicle_id'    =>  $key,
                        'public_price'  => empty($value['public_price']) ? 0 : $value['public_price'],
                        'private_price' => empty($value['private_price']) ? 0 : $value['private_price']
                    ]; 

                    DB::table('trip_vehicle_pricing')->insert($vehicle_data);
                }
                return redirect('/trips')->with('status', '<strong>Success:</strong> Trip Information Updated!');
            }
        }

        if($request->path() == 'trips/add'){
            $data['action'] = route('AddTrip');
        }else if($request->path() == 'trips/edit'){
            $data['action'] = route('EditTrip',['id'=>$request->get('id')]);
        }

        return view('trips.form',$data);
    }

    public function remove(Request $request){
        $i = 0;
        if($request->input('selected')){
            foreach($request->input('selected') as $id){
                Trip::where('id', $id)->update(['status'=>false]);
    
                $i = $i +1;
            }
        }

        return redirect('trips')->with('status', '<strong>Success:</strong> ' . $i . ' Trips Removed!');
    }

    public function getPickappLocations(Request $request){
        $trips = Trip::select('id','from_location')
        ->where('from_location','LIKE','%' . $request->get('query') . '%')
        ->where('from_location','!=',$request->get('to_location'))
        ->where('status', true)
        ->skip(0)
        ->take(15)
        ->get()->unique('from_location');
        return $trips;
    }

    public function getDestinations(Request $request){
        $trips = Trip::select('id','to_location')
        ->where('to_location','LIKE','%' . $request->get('query') . '%')
        ->where('to_location','!=',$request->get('from_location'))
        ->where('status', true)
        ->skip(0)
        ->take(15)
        ->get()->unique('to_location');
        return $trips;
    }

    public function getNote(Request $request){
        $trip = Trip::where('from_location',$request->get('location'))
        ->where('airport_note','<>','')
        ->whereNotNull('airport_note')
        ->first();

        return $trip;

    }
}
