@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-group" aria-hidden="true"></i> <strong>{{ $user->name}}'s</strong> Balance</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Balance</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a type="button" class="btn btn-primary " href="/users/balance/add?user_id={{ app('request')->input('user_id') }}"><i class="icon-copy fi-plus"></i> Add Balance</a>
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
        
        <form id="from" action="" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
        

            
           @csrf
            <div class="row">
                <table class="table table-striped  table-hover  data-table-export table-xs " style="font-size: 14px !important">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort"><input id="select-all" type="checkbox"/></th>
                            <th class="table-plus datatable-nosort">ID</th>
                            <th class="table-plus datatable-nosort">Description</th>
                            <th class="table-plus datatable-nosort text-center">Balance</th>
                            <th class="table-plus datatable-nosort">Action</th>
                       
                            <th class="table-plus datatable-nosort">Created At</th>
                            <th class="table-plus datatable-nosort">Modified At</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($balances->items() as $balance)
                            <tr>
                                <td class="text-center align-middle">
                                    <input type="checkbox" name="selected[]" value="{{ $balance->id }}" />
                                </td>
                                <td class="text-center align-middle">
                                    {{ $balance->id  }}
                                </td>
                                <td class="align-middle">
                                    {{ $balance->description }}
                                </td>
                                @if($balance->action == '+')
                                <td class="align-middle text-center text-success">
                                @else
                                <td class="align-middle text-center text-danger">
                                @endif 
                                    <strong>{{ $balance->action }}{{ $balance->balance }}$</strong>
                                </td>
                              
                                @if($balance->action == '+')
                                <td class="text-center align-middle text-success">
                                    <i class="icon-copy fa fa-arrow-circle-down" aria-hidden="true"></i>
                                </td>
                                @else
                                <td class="text-center align-middle text-danger">
                                    <i class="icon-copy fa fa-arrow-circle-up" aria-hidden="true"></i>
                                </td>
                                @endif
                          
                                <td class="align-middle">
                                    {{ $balance->created_at }}
                                </td>
                                <td class="align-middle">
                                    {{ $balance->updated_at }}
                                </td>
                        
                            </tr>
                        @endforeach
                    </tbody>
                 
                </table>
                <div class="w-100" >
                   
                    {{ $balances->appends($_GET)->links('vendor.pagination.default') }}
                    <div class="float-right h-100" style="padding-top: 25px">
                        <strong>
                            Showing {{ $balances->count() }} From {{ $balances->total() }} User Transactions
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
        text: "Your will not be able to recover deleted users!",
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






</script>
@endsection
