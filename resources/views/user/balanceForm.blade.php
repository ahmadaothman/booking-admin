@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4><i class="icon-copy fa fa-group" aria-hidden="true"></i> Add Balance For <strong>{{ $user->name}}</strong></h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Balance</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary " onclick="event.preventDefault();
                    document.getElementById('user-form').submit();"><i class="icon-copy fi-save"></i> Save</button>
                    <a href="{{ route('userBalance') }}" type="submit" class="btn btn-secondary text-white" ><i class="icon-copy fi-x"></i> Cancel</a>

                </div>
            </div>
        </div>
       
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">Add New Balance</h5>
                </div>
            </div>
            <div class="container">
               
                <form id="user-form" action="{{ $action }}" method="POST" >
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user_id }}" />
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Balance*</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="balance" type="text" placeholder="Balance" required value="{{ old('name') }}">
                           
                            @error('balance')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Note</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="note" type="text" placeholder="Note" value="{{ old('note') }}">
                           
                            @error('note')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                  
                </form>
							
            </div>
        </div>
        <!-- Export Datatable End -->
    </div>
</div>

@endsection
