@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-car" aria-hidden="true"></i> Vehicles</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Vehicles</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a type="button" class="btn btn-primary " href="/vehicles/add"><i class="icon-copy fi-plus"></i> Add Vehicle</a>
                    <button id="sa-warning" type="button" class="btn btn-danger" onclick="remove();"><i class="icon-copy fi-trash"></i> Remove</button>
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
        
        <form id="from" action="{{ route('removeVehicles') }}" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
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
                <table class="table table-striped  table-hover  data-table-export table-xs">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort"><input id="select-all" type="checkbox"/></th>
                                <th class="table-plus datatable-nosort">ID</th>
                                <th class="table-plus datatable-nosort">Name</th>
                                <th class="table-plus datatable-nosort">Description</th>
                                <th class="table-plus datatable-nosort">Max People</th>
                                <th class="table-plus datatable-nosort">Sort Order</th>
                                <th class="table-plus datatable-nosort">Created At</th>
                                <th class="table-plus datatable-nosort">Modified At</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                    <tbody>
                        @foreach ($vehicles->items() as $vehicle)
                            <tr>
                                <td class="text-center align-middle">
                                    <input type="checkbox" name="selected[]" value="{{ $vehicle['id'] }}" />
                                </td>
                                <td class="text-center align-middle">
                                    {{ $vehicle['id'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $vehicle['name'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $vehicle['description'] }}
                                </td>

                                <td class="align-middle">
                                    {{ $vehicle['max_people'] }}
                                </td>

                       
                             
                                <td class="align-middle">
                                    {{ $vehicle['sort_order'] }}
                                </td>
                              
                                <td class="align-middle">
                                    {{ $vehicle['created_at'] }}
                                </td>
                                <td class="align-middle">
                                    {{ $vehicle['updated_at'] }}
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('editVehicle',['id' => $vehicle['id']]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="icon-copy fa fa-edit" aria-hidden="true"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                 
                </table>
                <div class="w-100" >
                   
                    {{ $vehicles->appends($_GET)->links('vendor.pagination.default') }}
                    <div class="float-right h-100" style="padding-top: 25px">
                        <strong>
                            Showing {{ $vehicles->count() }} From {{ $vehicles->total() }} Vehicles
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


function remove(){
    
    swal({
        title: "Are you sure?",
        text: "Your will not be able to recover deleted vehicles!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    },
    function(confirn){
        alert('ok')
    }).then(function (isConfirm) {
               if(isConfirm.value){
                document.getElementById('from').submit();
               }
               //success method
            },function(){});
 //   document.getElementById('from').submit();
}

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
