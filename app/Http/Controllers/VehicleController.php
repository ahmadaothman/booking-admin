<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Countries\Package\Countries;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
      
    }


    public function index(Request $request){
        $data = array();

        $vehicles =  Vehicle::orderBy('id');
  
    
      
        if($request->get('filter_name')){
            $vehicles->where('name', 'LIKE','%' . $request->get('filter_name') . '%');
        }

        if($request->get('filter_description')){
            $vehicles->where('description', 'LIKE','%' . $request->get('filter_description') . '%');
        }

        if($request->get('filter_max_people')){
            if(str_contains($request->get('filter_max_people'), '<') && !str_contains($request->get('filter_max_people'), '<=')){
                $vehicles->where('max_people','<', str_replace('<','',$request->get('filter_max_people')) );
            }else if(str_contains($request->get('filter_max_people'), '>') && !str_contains($request->get('filter_max_people'), '>=')){
                $vehicles->where('max_people','>', str_replace('>','',$request->get('filter_max_people')));
            }else if(str_contains($request->get('filter_max_people'), '!=')){
                $vehicles->where('max_people','!=', str_replace('!=','',$request->get('filter_max_people')));
            }else if(str_contains($request->get('filter_max_people'), '>=')){
                $vehicles->where('max_people','>=', str_replace('>=','',$request->get('filter_max_people')));
            }else if(str_contains($request->get('filter_max_people'), '<=')){
                $vehicles->where('max_people','<=', str_replace('<=','',$request->get('filter_max_people')));
            }else{
                $vehicles->where('max_people', $request->get('filter_max_people'));
            }
        }



        $data['vehicles'] = $vehicles->paginate(15);

        return view("vehicles.list",$data);

    }

    public function form(Request $request){
        $data = array();
 

        if($request->path() == 'vehicles/add'){
            $data['action'] = route('addVehicle');
        }else if($request->path() == 'vehicles/edit'){
            $data['action'] = route('editVehicle',['id'=>$request->get('id')]);
        }

        switch ($request->method()) {
            case 'POST':

                $validation_data =  array();

                $validation_data['name'] = 'required|min:3';


                $image = $request->file('image');

                $original_name = $image->getClientOriginalName();
                $extension = explode(".",$original_name);
                $extension = $extension[count($extension) - 1];

                $new_name =  rand() . "_" . $original_name;

             //   dd($new_name);

                $path = $image->move(public_path('images'), $new_name);


                $validated = $request->validate($validation_data);

                // inser/edit data
                $vehicle_data = [
                    'name'          =>  $request->input('name'),
                    'description'   =>  $request->input('description'),
                    'max_people'    =>  $request->input('max_people'),
                    'price'         =>  $request->input('price'),
                    'image'         =>  'images/' . $new_name,
                    'sort_order'    =>  $request->input('sort_order'),
                    'updated_at'    =>   now()
                ];

                try { 
                    if($request->path() == 'vehicles/add'){

                        Vehicle::insert($vehicle_data);

                    }else if($request->path() == 'vehicles/edit'){
                        Vehicle::where('id', $request->get('id'))
                        ->update($vehicle_data);
                    }
                    
                }catch(\Illuminate\Database\QueryException $ex){
                    dd($ex->getMessage()); 
                }
               
                if($request->path() == 'vehicles/add'){
                    return redirect('vehicles')->with('status', '<strong>Success:</strong> New Vehicle added!');
                }else{
                    return redirect('vehicles')->with('status', '<strong>Success:</strong> Vehicle info updated!');
                }

                break;
    
            case 'GET':
                if ($request->has('id')) {
                    $vehicle = Vehicle::where('id',$request->id)->first();
                    $data['vehicle'] = $vehicle;
                }
                // do anything in 'get request';
                break;
    
            default:
                // invalid request
                break;
        }

        return view('vehicles.form',$data);
    }

    public function remove(Request $request){
        $i = 0;
        if($request->input('selected')){
            foreach($request->input('selected') as $id){
                Vehicle::where('id', $id)->update(['status'=>false]);
                
                $i = $i +1;
            }
        }

        return redirect('vehicles')->with('status', '<strong>Success:</strong> ' . $i . ' Vehicles Removed!');
    }
}
