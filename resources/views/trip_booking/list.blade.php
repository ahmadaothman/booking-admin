@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-bookmark-o" aria-hidden="true"></i>  Booking</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Booking</li>
                        </ol>
                    </nav>
                </div>
                
            </div>
        </div>
       
  
        <!-- multiple select row Datatable End -->
        <!-- Export Datatable start -->
        @if(session()->has('status'))
            
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session()->get('status') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        @endif
        
        <form id="from" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <p class="text-right">
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                </a>
            
            </p>

       
                <div class="collapse mb-20 " id="collapseExample">

          
                <div class="card card-body">
                    <div class="row mb-20">
                            <!--Trip Type-->

                            <div class="col-sm-3">
                                <label for="filter_trip_type">Trip Type:</label>
                                <select class="form-control form-control-sm" id="filter_trip_type">
                                    <option value="-1">--none--</option>
                                    @if(app('request')->input('filter_trip_type') == 'one_way')
                                     <option value="one_way" selected="selected">One Way</option>
                                    @else 
                                    <option value="one_way" ">One Way</option>
                                    @endif
                                    @if(app('request')->input('filter_trip_type') == 'round')
                                     <option value="round" selected="selected">Round Trip</option>
                                    @else 
                                    <option value="round" ">Round Trip</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="filter_partner">Pertner:</label>
                                <select class="form-control form-control-sm" id="filter_partner">
                                    <option value="-1">--none--</option>
                                   
                                    @foreach($users as $user)
                                        @if($user->id == app('request')->input('filter_partner'))
                                            <option value="{{ $user->id }}" selected="selected">{{ $user->name }}</option>
                                        @else
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-sm-3">
                                <label for="filter_from">From:</label>
                                <input type="text" class="form-control form-control-sm h-50" id="filter_from" value="{{ app('request')->input('filter_from') }}">
                            </div>

                            <div class="col-sm-3">
                                <label for="filter_to">To:</label>
                                <input type="text" class="form-control form-control-sm h-50" id="filter_to" value="{{ app('request')->input('filter_to') }}">
                            </div>

                        
                        
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <label for="filter_status">Booking Status:</label>
                            <select class="form-control form-control-sm" id="filter_status">
                                <option value="-1">--none--</option>
                                <option value="1">Approved</option>
                                <option value="2">Cancelled</option>
                                <option value="3">Completed</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label for="filter_date">Booking Date:</label>
                            <input type="text" class="form-control form-control-sm h-50" id="filter_date" value="{{ app('request')->input('filter_date') }}">
                        </div>
                    </div>
                    <div class="w-100 text-right ">
                        <button  type="button" id="btn_filter" class="btn btn-info btn-sm"  onclick="filter()"> 
                            <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
           @csrf
            <div class="row">
                <table class="table table-striped  table-hover  data-table-export table-xs w-100" style="font-size:14px !important;">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">ID</th>
                                <th class="table-plus datatable-nosort">From</th>
                                <th class="table-plus datatable-nosort">To</th>
                                <th class="table-plus datatable-nosort">Trip</th>
                                <th class="table-plus datatable-nosort">Partner</th>
                                <th class="table-plus datatable-nosort">Name</th>
                               
                                <th class="table-plus datatable-nosort">Telephone</th>
                                <th class="table-plus datatable-nosort">Booking Date</th>
                                <th class="table-plus datatable-nosort">Status</th>
                                <th class="table-plus datatable-nosort">Created At</th>
                                
                                <th>Action</th>

                            </tr>
                        </thead>
                    <tbody>
                      @foreach ($bookings as $booking)
                          <tr>
                              <td>{{ $booking->id }}</td>
                              <td>{{ $booking->Trip->from_location }}</td>
                              <td>{{ $booking->Trip->to_location }}</td>
                              <td>{{ $booking->trip_type }}</td>
                              <td>{{ $booking->Partner->name }}</td>
                              <td>{{ $booking->firstname }}</td>
                       
                              <td>{{ $booking->telephone }}</td>
                              <td>{{ $booking->booking_date }}</td>
                              <td>
                              @if ($booking->status == 1)
                              <span class="bg-warning p-2 text-white rounded">Approved</span>
                              @elseif($booking->status == 2)
                              <span class="bg-danger p-2 text-white rounded">Cancelled</span>
                              @elseif($booking->status == 3)
                              <span class="bg-success p-2 text-white rounded">Completed</span>
                              @endif
                              </td>
                              <td>{{ $booking->created_at }}</td>
                              
                              <td>
                                <a href="{{ route('EditTripBooking',['id' => $booking['id']]) }}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i> </a>
                              </td>
                          </tr>
                      @endforeach
                    </tbody>
                 
                </table>
                <div class="w-100" >
                   
                    {{ $bookings->appends($_GET)->links('vendor.pagination.default') }}
                    <div class="float-right h-100" style="padding-top: 25px">
                        <strong>
                            Showing {{ $bookings->count() }} From {{ $bookings->total() }} Trips
                        </strong>
                    </div>

                </div>
            </div>
        </form>
        <!-- Export Datatable End -->
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





$('input').on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        filter()
    }
});
</script>
<script type="text/javascript">
      $('#filter_status').val("{{ app('request')->input('filter_status') }}");

    function filter(){
      var url = '';

      if($('#filter_trip_type').val() != "-1"){
          url += '&filter_trip_type=' + $('#filter_trip_type').val();
      }

      if($('#filter_partner').val() != "-1"){
          url += '&filter_partner=' + $('#filter_partner').val();
      }

      if($('#filter_from').val() != ""){
          url += '&filter_from=' + $('#filter_from').val();
      }

      if($('#filter_to').val() != ""){
          url += '&filter_to=' + $('#filter_to').val();
      }


      if($('#filter_status').val() != "-1" && $('#filter_status').val() != null){
          url += '&filter_status=' + $('#filter_status').val();
      }

      if($('#filter_date').val() != ""){
          url += '&filter_date=' + $('#filter_date').val();
      }


      location.href = "{{ route('Tripbooking',) }}/?" + url
  
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
<script type="text/javascript" src="{{ asset('/src/plugins/daterangpicker/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/src/plugins/daterangpicker/js/daterangepicker.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/src/plugins/daterangpicker/css/daterangepicker.css') }}" />

<script type="text/javascript">
    var start = moment("2010-01-01","YYYY-MM-DD").format("YYYY-MM-DD");
    var end = moment();
    
    var filter_date = "{{ app('request')->input('filter_date') }}";
    
    if(filter_date != "") {

        var dates = filter_date.split(" - ");

        start = moment(dates[0],"YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm");
        end = moment(dates[1],"YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm");

    }
        
    $('#filter_date').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'All time': [moment("2010-01-01","YYYY-MM-DD").format("YYYY-MM-DD"), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale:{
            format: 'YYYY-MM-DD HH:mm',
            cancelLabel: 'Clear'
        }
	});

    $('#filter_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm:ss') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('#filter_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

</script>

@endsection
