@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                  
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Setting</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary " onclick="event.preventDefault();
                    document.getElementById('vehicle-form').submit();"><i class="icon-copy fi-save"></i> Save</button>

                </div>
            </div>
        </div>
       
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">Setting</h5>
                </div>
            </div>
            <div class="container">
               
                <form id="vehicle-form" action="{{ $action }}" method="POST" enctype="multipart/form-data" hidden>
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Note:</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="airport_port_number" type="text" placeholder="Note" value="{{ $airport_port_number ? $airport_port_number :  old('airport_port_number') }}">
                        </div>
                    </div>
                  
                   
                   
                   
                  
                </form>
							
            </div>
        </div>
        <!-- Export Datatable End -->
    </div>
</div>


@endsection
