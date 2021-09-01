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

            @if (app('request')->input('filter_name') || app('request')->input('filter_description') || app('request')->input('filter_max_people') || app('request')->input('filter_price') )
                <div class="collapse mb-20 show" id="collapseExample">
            @else
                <div class="collapse mb-20 " id="collapseExample">
            @endif
          
                <div class="card card-body">
                    <div class="row mb-20">
                        <!--Filter Name-->

                        <div class="col-sm-4">
                            <label for="filter_name">Filter Name:</label>
                            <input type="text" id="filter_name" class="form-control form-control-sm" placeholder="Filter Name" value="{{ app('request')->input('filter_name') }}"/>
                        </div>
          
                         <!--Filter Desc -->
                         <div class="col-sm-4">
                            <label for="filter_city">Filter Description:</label>
                            <input type="text" id="filter_description" class="form-control form-control-sm" placeholder="Filter Description" value="{{ app('request')->input('filter_description') }}"/>
                        </div>
                         <!--Filter Max -->
                         <div class="col-sm-4">
                            <label for="filter_city">Filter Max Peape:</label>
                            <input type="text" id="filter_max_people" class="form-control form-control-sm" placeholder="You can you <, >, !=, >= and <=" value="{{ app('request')->input('filter_max_people') }}"/>
                        </div>
                  
                        
                        
                    </div>
                    <div class="w-100 text-right ">
                        <button  type="button" id="btn_filter" class="btn btn-info btn-sm"> 
                            <i class="icon-copy fa fa-filter" aria-hidden="true"></i> Filters
                        </button>
                    </div>
                </div>
            </div>
           @csrf
            <div class="row">
                <table class="table table-striped  table-hover  data-table-export table-xs table-responsive" style="font-size:14px !important;">
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
                                <th class="table-plus datatable-nosort">Modified At</th>
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
                              <span class="bg-success p-2 text-white rounded">Approved</span>
                              @elseif($booking->status == 2)
                              <span class="bg-danger p-2 text-white rounded">Cancelled</span>
                              @endif
                              </td>
                              <td>{{ $booking->created_at }}</td>
                              <td>{{ $booking->updated_at }}</td>
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



$('#btn_filter').on('click',function(){
    filter()
})

function filter(){
    var url = '';
    if($('#filter_name').val() != '' ){
        url += '&filter_name=' + $('#filter_name').val();
    }

    if($('#filter_description').val() != '' ){
        url += '&filter_description=' + $('#filter_description').val();
    }

    if($('#filter_max_people').val() != '' ){
        url += '&filter_max_people=' + $('#filter_max_people').val();
    }

    



    location.href = "{{ route('vehicles',) }}/?" + url
}

$('input').on('keyup', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        filter()
    }
});
</script>
@endsection
