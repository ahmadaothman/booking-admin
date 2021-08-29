@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-car" aria-hidden="true"></i> Booking</h4>
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
       
  
        
        <form id="from" method="POST" class="pd-20 bg-white border-radius-4 box-shadow mb-30">
           @csrf
         
        </form>
        <!-- Export Datatable End -->
    </div>
</div>



@endsection
