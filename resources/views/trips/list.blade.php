@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-map-pin" aria-hidden="true"></i> Trips</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Trips</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a type="button" class="btn btn-primary " href="{{ route('AddTrip') }}"><i class="icon-copy fi-plus"></i> Add Trip</a>
                    <button id="sa-warning" type="button" class="btn btn-danger" onclick="remove();"><i class="icon-copy fi-trash"></i> Remove</button>
                </div>
            </div>
        </div>
        @if(session()->has('status'))
                
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session()->get('status') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        <form id="from" action="{{ route('removeTrips') }}" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <p class="text-right">
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                </a>
            
            </p>

            @if (app('request')->input('filter_name') || app('request')->input('filter_description') || app('request')->input('filter_max_people') || app('request')->input('filter_price') )
                <div class="collapse mb-20 show" id="collapseExample">
            @else
                <div class="collapse mb-20 " id="collapseExample">
            @endif
          
                <div class="card card-body">
                    <div class="row mb-20">
                         <!--Filter From -->
                         <div class="col-sm-4">
                            <label for="filter_from">From:</label>
                            <input type="text" id="filter_from" class="form-control form-control-sm" placeholder="Filter From" value="{{ app('request')->input('filter_from') }}" autocomplete="off"/>
                        </div>

                        <!--Filter Name-->

                        <div class="col-sm-4">
                            <label for="filter_to">Filter To:</label>
                            <input type="text" id="filter_to" class="form-control form-control-sm" placeholder="Filter To" value="{{ app('request')->input('filter_to') }}" autocomplete="off"/>
                        </div>

                        <div class="col-sm-4">
                            <label for="filter_is_airport">Is Airport:</label>
                            <select class="form-control" id="filter_is_airport">
                                <option value="-1">--none--</option>
                                <option value="1" @if(app('request')->input('filter_is_airport') == 1) selected @endif>Yes</option>
                                <option value="0" @if(app('request')->input('filter_is_airport') != null &&  app('request')->input('filter_is_airport') != 1) selected @endif>No</option>
                            </select>
                        </div>
          
                        
                    </div>
                    <div class="w-100 text-right ">
                        <button  type="button" id="btn_filter" class="btn btn-danger btn-sm"  onclick="ClearFilter()"> 
                            <i class="icon-copy fa fa-times" aria-hidden="true"></i> Clear Filters
                        </button>

                        <button  type="button" id="btn_filter" class="btn btn-info btn-sm"  onclick="filter()"> 
                            <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
           @csrf
           <div class="row">
            <table class="table table-striped  table-hover  data-table-export table-xs">
                <thead>
                    <tr>
                        <th class="table-plus datatable-nosort "><input  id="select-all" type="checkbox"/></th>
                        <th class="table-plus datatable-nosort">ID</th>
                        <th class="table-plus datatable-nosort">Country</th>
                        <th class="table-plus datatable-nosort">From</th>
                        <th class="table-plus datatable-nosort">To</th>
                        <th class="table-plus datatable-nosort">Available Vehicles For Agency</th>
                        <th class="table-plus datatable-nosort">Available Vehicles For Public</th>
                        <th class="table-plus datatable-nosort">Is Airport</th>
                        <th class="table-plus datatable-nosort">Created At</th>
                        <th class="table-plus datatable-nosort">Modified At</th>
                        <th class="table-plus datatable-nosort">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($trips as $trip)
                       <tr>
                           <td class="align-middle"> <input type="checkbox" name="selected[]" value="{{ $trip->id }}" /></td>
                           <td class="align-middle">{{ $trip->id }}</td>
                           <td class="align-middle text-center">
                               <div>
                                {{ $trip->countryFlagImoji }}
                              <br/>
                                {{ $trip->countryName }}
                               </div>
                            </td>
                            <td class="align-middle">{{ $trip->from_location }}</td>
                            <td class="align-middle">{{ $trip->to_location }}</td>
                            <td class="align-middle text-center">{{ $trip->CountAgencyVehicle }}</td>
                            <td class="align-middle text-center">{{ $trip->CountPublicVehicle }}</td>
                            @if($trip->is_airport == 1)
                            <td class="align-middle text-center text-success">Yes</td>
                            @else
                            <td class="align-middle text-center text-danger">No</td>
                            @endif
                            <td class="align-middle">{{ $trip->created_at }}</td>
                            <td class="align-middle">{{ $trip->updated_at }}</td>
                            <td class="align-middle">
                                <a href="{{ route('EditTrip',['id' => $trip['id']]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="icon-copy fa fa-edit" aria-hidden="true"></i> Edit</a>
                            </td>
                       </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="w-100" >
                   
                {{ $trips->appends($_GET)->links('vendor.pagination.default') }}
                <div class="float-right h-100" style="padding-top: 25px">
                    <strong>
                        Showing {{ $trips->count() }} From {{ $trips->total() }} Trips
                    </strong>
                </div>

            </div>
           </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;                       
            });
        }
    });

    function remove(){
    
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover deleted trips!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        },
        function(confirn){
            
        }).then(function (isConfirm) {
            if(isConfirm.value){
                document.getElementById('from').submit();
            }
            //success method
            },function(){
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    $('#filter_from').typeahead({

       source: function (query, process) {
           return $.getJSON(
               "{{ route('search_pickup') }}",
               {
                   query: query,
                   to_location:  $('#to_location').val()
               },
               function (data) {
                   var newData = [];

                   $.each(data, function(){

                       newData.push(this.from_location);

                   });

                   return process(newData);
               });
       },
       afterSelect: function(args){
               $.ajax({
                   url: "{{ route('getAriportNote') }}",
                   type:'GET',
                   data:{
                       location: $('#from_location').val()
                   },
                   success:function(ress){
                    
                   }
               })
           }

       });

       $('#filter_to').typeahead({

           source: function (query, process) {
               return $.getJSON(
                   "{{ route('searh_destination') }}",
                   {
                       query: query,
                       from_location: $('#from_location').val()
                   },
                   function (data) {
                       var newData = [];

                       $.each(data, function(){

                           newData.push(this.to_location);

                       });

                       return process(newData);
                   });
           }
          

       });
</script>
<script type="text/javascript">
    $('#filter_status').val("{{ app('request')->input('filter_status') }}");

  function filter(){
    var url = '';

    if($('#filter_from').val() != ""){
        url += '&filter_from=' + $('#filter_from').val();
    }

    if($('#filter_to').val() != ""){
        url += '&filter_to=' + $('#filter_to').val();
    }

    if($('#filter_is_airport').val() != "-1"){
        url += '&filter_is_airport=' + $('#filter_is_airport').val();
    }


    location.href = "{{ route('trips',) }}/?" + url
  }

  function ClearFilter(){
      location.href = "{{ route('trips',) }}"
  }
</script>

@endsection