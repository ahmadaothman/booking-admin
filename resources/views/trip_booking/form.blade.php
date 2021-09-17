@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-bookmark-o" aria-hidden="true"></i> Booking</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Booking</li>
                        </ol>
                    </nav>
                </div>

                @if ($booking->status != 2 )
                <div class="col-md-6 text-right">
                    @if($booking->status != 3)
                    <button type="button" class="btn btn-success" onclick="$('#complete_form').submit()"><i class="icon-copy fa fa-check" aria-hidden="true"></i> Complete</button>

                    @endif
                    <button type="button" class="btn btn-danger" onclick="$('#cancel_form').submit()"><i class="icon-copy fa fa-trash-o" aria-hidden="true"></i> Cancel Booking</button>
                    <button type="button" class="btn btn-primary" onclick="$('#from').submit()"><i class="icon-copy fa fa-save" aria-hidden="true"></i> Save</button>
                </div>
                @endif
            </div>
        </div>

        <form id="complete_form" action="{{ route('completeTripBooking') }}" method="POST">
            
            <input type="hidden" name="complete_id" value="{{ $booking->id }}" />

            @csrf
        </form>

       <form id="cancel_form" action="{{ route('cancelTripBooking') }}" method="POST">
        @csrf    
        <input type="hidden" name="id" value="{{ $booking->id }}" />
       </form>
       @if ($booking->status == 2 || $booking->status == 3)
           <style>
               #from {
                pointer-events: none;
                opacity: 0.4;
            }
            </style>
       @endif
        <form id="from" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            @csrf
            <div class="row">
                <div class="col-sm-12 text-center">
                    @if ($booking->trip_type == 'round')
                        <h3>Round Trip</h3>
                    @else
                        <h3>One Way Trip</h3>
                    @endif
                   
                    <hr>
                </div>
            </div>
            <h4>Contact Info</h4>
            <hr>
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group ">
                        <label for="firstname" >Full Name:</label>
                        <input type="text"  class="form-control" id="firstname" name="firstname" value="{{ $booking->firstname }}" />
                    </div>
                </div>
                <div class="col-md-3 d-none">
                    <div class="form-group ">
                        <label for="middlename" >Middle Name:</label>
                        <input type="text"  class="form-control" id="middlename" name="middlename" value="{{ $booking->middlename }}" />
                    </div>
                </div>
                <div class="col-md-3 d-none">
                    <div class="form-group ">
                        <label for="lastname" >Last Name:</label>
                        <input type="text"  class="form-control" id="lastname" name="lastname" value="{{ $booking->lastname }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <label for="nationality" >Nationality:</label>
                        <input type="text"  class="form-control" id="nationality" name="nationality" value="{{ $booking->nationality }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 d-none">
                    <div class="form-group d-none">
                        <label for="sex" >Sex:</label>
                        <input type="text"  class="form-control" id="sex" name="sex" value="{{ $booking->sex }}" />
                    </div>
                </div>
                <div class="col-md-3 d-none">
                    <div class="form-group ">
                        <label for="date_of_birthday" >Date Of Birthday:</label>
                        <input type="text"  class="form-control" id="date_of_birthday" name="date_of_birthday" value="{{ $booking->date_of_birthday }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="telephone" >Telephone:</label>
                        <input type="text"  class="form-control" id="telephone" name="telephone" value="{{ $booking->telephone }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="email" >Email:</label>
                        <input type="text"  class="form-control" id="email" name="email" value="{{ $booking->email }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="passport_number" >Passport Number:</label>
                        <input type="text"  class="form-control" id="passport_number" name="passport_number" value="{{ $booking->passport_number }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="number_of_people" >Number Of Pessengers:</label>
                        <input type="text" readonly  class="form-control" id="number_of_people" name="number_of_people" value="{{ $booking->number_of_people }}" />
                    </div>
                </div>
            </div>

            <h4>Trip Info</h4>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group ">
                        <label for="booking_date" >Pickup Date:</label>
                        <input type="text"  class="form-control" id="booking_date" name="booking_date" value="{{ $booking->booking_date }}" />
                    </div>
                    
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <label for="one_way_time" >Pickup Time:</label>
                        <input type="text"  class="form-control" id="one_way_time" name="one_way_time" value="{{ $booking->one_way_time }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <label for="one_way_from" >From:</label>
                        <input type="text" readonly  class="form-control" id="one_way_from" name="one_way_from" value="{{ $one_way_trip->from_location }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group ">
                        <label for="one_way_to" >To:</label>
                        <input type="text"  readonly class="form-control" id="one_way_to" name="one_way_to" value="{{ $one_way_trip->to_location }}" />
                    </div>
                </div>
            </div>
            @if ($one_way_trip->is_airport == 1)
                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="fly_number" >Fly Number:</label>
                                <input type="text"  class="form-control" id="fly_number" name="fly_number" value="{{ $booking->trip_number_main }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="fly_arrival_time" >Fly Arrival Time:</label>
                                <input type="text"  class="form-control" id="fly_arrival_time" name="fly_arrival_time" value="{{ $booking->trip_arrival_time }}" />
                            </div>
                        </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="one_way_pickup_note" >Pickup location note:</label>
                        <input type="text"  class="form-control" id="one_way_pickup_note" name="one_way_pickup_note" value="{{ $booking->one_way_pickup_note }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group ">
                        <label for="one_way_dropoff_note" >Dropoff location note:</label>
                        <input type="text"  class="form-control" id="one_way_dropoff_note" name="one_way_dropoff_note" value="{{ $booking->one_way_dropoff_note }}" />
                    </div>
                </div>
            </div>
           @if ($booking->trip_type == 'round')
           <h4>Return Trip Info</h4>
           <hr>
           <div class="row">
               <div class="col-md-3">
                   <div class="form-group ">
                       <label for="return_date" >Pickup Date:</label>
                       <input type="text"  class="form-control" id="return_date" name="return_date" value="{{ $booking->return_date }}" />
                   </div>
                   
               </div>
               <div class="col-md-3">
                   <div class="form-group ">
                       <label for="return_time" >Pickup Time:</label>
                       <input type="text"  class="form-control" id="return_time" name="return_time" value="{{ $booking->return_time }}" />
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="form-group ">
                       <label for="return_from_location" >From:</label>
                       <input type="text" readonly class="form-control" id="return_from_location" name="return_from_location" value="{{ $round_trip->from_location }}" />
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="form-group ">
                       <label for="return_to_location" >To:</label>
                       <input type="text" readonly class="form-control" id="return_to_location" name="return_to_location" value="{{ $round_trip->to_location }}" />
                   </div>
               </div>
           </div>
           @if ($round_trip->is_airport == 1)
               <div class="row">
                       <div class="col-md-6">
                           <div class="form-group ">
                               <label for="fly_number" >Fly Number:</label>
                               <input type="text" readonly class="form-control" id="fly_number" name="fly_number" value="{{ $booking->trip_number_main }}" />
                           </div>
                       </div>

                       <div class="col-md-6">
                           <div class="form-group ">
                               <label for="fly_arrival_time" >Fly Arrival Time:</label>
                               <input type="text" readonly class="form-control" id="fly_arrival_time" name="fly_arrival_time" value="{{ $booking->trip_arrival_time }}" />
                           </div>
                       </div>
               </div>
           @endif
           <div class="row d-none">
               <div class="col-md-6">
                   <div class="form-group ">
                       <label for="return_pickup_note" >Pickup location note:</label>
                       <input type="text"  class="form-control" id="return_pickup_note" name="return_pickup_note" value="{{ $booking->return_pickup_note }}" />
                   </div>
               </div>

               <div class="col-md-6">
                <div class="form-group ">
                    <label for="return_dropoff_note" >Dropoff location note:</label>
                    <input type="text"  class="form-control" id="return_dropoff_note" name="return_dropoff_note" value="{{ $booking->return_dropoff_note }}" />
                </div>
            </div>
           </div>
           @endif
           <h4>Vehicles Info</h4>
           <hr>
           <table class="table table-bordered table-sm">
               <tr>
                   <td>Vehicle:</td>
                   <td>{{ $one_way_vehicle->name }}</td>
                   <td>Description:</td>
                   <td>{{ $one_way_vehicle->description }}</td>
                   <td>Max People:</td>
                   <td>{{ $one_way_vehicle->max_people }}</td>
                   <td>Price:</td>
                   @if ($booking->trip_type == 'round')
                   <td>{{ $one_way_price*2 }}$</td>
                  @else
                  <td>{{ $one_way_price }}$</td>
                  @endif
               </tr>
              
           </table>
           <h4>Pessengers Info</h4>
           <hr>
           <table class="table table-bordered">
               <thead>
                   <tr>
                       <th>First Name</th>
                       <th>Nationality</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <tbody id="pessengers_tbody">
                   <div class="d-none">
                       {{ $row_count = 0}}
                   </div>

                   @foreach ($pessengers as $pessenger)
                       <tr id="pers_row_{{ $row_count }}">
                            <td>
                                <input class="form-control" name="pessenger[{{ $row_count }}][firstname]" value="{{ $pessenger->firstname }}"/>
                            </td>
                           
                          
                            <td>
                                <div class="d-none">
                                    {{ isset($pessenger->nationality) ? $country = $pessenger->nationality :  $country = '' }}
                                </div>
                                <select class="form-control selectpicker" name="pessenger[{{ $row_count }}][nationality]" data-live-search="true">
                                   
                                    @foreach ($countries as $key => $value)
                                        @if ((isset($value['name_en']) && !empty($value['name_en'])) && (isset($value['cca2']) && !empty($value['cca2'])))
                                            @if ($value['cca2'] == $country)
                                                <option value="{{ $value['cca2'] }}" selected="selected">{{ $value['name_en'] }}</option>
                                            @else
                                                <option value="{{ $value['cca2'] }}">{{ $value['name_en'] }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                           
                            <td>
                                <button type="button" class="btn btn-danger" onclick="$('#pers_row_{{ $row_count }}').remove()"><i class="icon-copy fa fa-trash-o" aria-hidden="true"></i></button>
                            </td>
                       </tr>
                       <div class="d-none">
                        {{ $row_count++ }}
                    </div>
                   @endforeach
                
               </tbody>
               <tr>
                    <td colspan="2"></td>
                    <td><button type="button" class="btn btn-primary" onclick="addRow()"><i class="icon-copy fa fa-plus" aria-hidden="true"></i></button></td>
                </tr>
           </table>
          
        </form>
        <!-- Export Datatable End -->
    </div>
</div>

<script type="text/javascript">
    var row_count = {{ $row_count }}
    function addRow(){
        var html = '<tr id="pers_row_'+row_count+'">'
            html += '<td><input class="form-control" name="pessenger['+row_count+'][firstname]" value=""></td>'
            html += '<td><select class="form-control " name="pessenger['+row_count+'][nationality]" data-live-search="true">'
            "@foreach ($countries as $key => $value)"
                "@if ((isset($value['name_en']) && !empty($value['name_en'])) && (isset($value['cca2']) && !empty($value['cca2'])))"
                
                    html += '<option value="{{ $value["cca2"] }}">{{ $value["name_en"] }}</option>'
               
                "@endif"
            "@endforeach"
            html += '</select></td>'
            html += '<td><button class="btn btn-danger" onclick="$(\'#pers_row_'+row_count+'\').remove()"><i class="icon-copy fa fa-trash-o" aria-hidden="true"></i></button></td>'
        html += '</tr>'
        $('#pessengers_tbody').append(html)
        
        row_count++;
    }
</script>

@endsection
