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

        $trips =  Trip::orderBy('id');

        $data['trips'] = $trips->paginate(15);

        return view('trips.list',$data);
    }

    public function form(Request $request){
        $data = array();

        $data['country_code'] = '';
        $countries = new Countries();

        $data['countries'] = $countries->all()->toArray();


        $vehicles = Vehicle::get();
        $vehicles = $vehicles->toArray();

        if($request->path() == 'trips/edit'){
            $data['trip'] = Trip::where('id', $request->get('id'))->first();

            $trip_vehicles = DB::table('trip_vehicle_pricing')->where('trip_id', $request->get('id'))->get();
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
                'updated_at'    =>   now()
            ];

            if($request->path() == 'trips/add'){
               
                $id = Trip::insertGetId($trip_data);
              
                foreach($request->input('vehicle') as $key => $value){
                    $vehicle_data = [
                        'trip_id'       =>  $id,
                        'vehicle_id'    =>  $key,
                        'public_price'  => $value['public_price'],
                        'private_price' => $value['private_price']
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
                        'public_price'  => $value['public_price'],
                        'private_price' => $value['private_price']
                    ]; 

                    DB::table('trip_vehicle_pricing')->insert($vehicle_data);
                }

                return redirect('/trips')->with('status', '<strong>Success:</strong> New Trip Added!');

            }else if($request->path() == 'trips/edit'){
                Trip::where('id',$request->get('id'))->update($trip_data);

                DB::table('trip_vehicle_pricing')->where('trip_id',$request->get('id'))->delete();

                foreach($request->input('vehicle') as $key => $value){
                    $vehicle_data = [
                        'trip_id'       =>  $request->get('id'),
                        'vehicle_id'    =>  $key,
                        'public_price'  => $value['public_price'],
                        'private_price' => $value['private_price']
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
                Trip::where('id', $id)->delete($id);
    
                $i = $i +1;
            }
        }

        return redirect('trips')->with('status', '<strong>Success:</strong> ' . $i . ' Trips Removed!');
    }
}
