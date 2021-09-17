@extends('index')
@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                  
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vehicle</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary " onclick="event.preventDefault();
                    document.getElementById('vehicle-form').submit();"><i class="icon-copy fi-save"></i> Save</button>
                    <a href="/vehicles" class="btn btn-secondary text-white" ><i class="icon-copy fi-x"></i> Cancel</a>

                </div>
            </div>
        </div>
       
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">Vehicle Information</h5>
                </div>
            </div>
            <div class="container">
               
                <form id="vehicle-form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="name" type="text" placeholder="Vehicle Name" value="{{ isset($vehicle->name) ? $vehicle->name :  old('name') }}">
                           
                            @error('name')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Description</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="description" type="text" placeholder="Vehicle Description" value="{{ isset($vehicle->description) ? $vehicle->description :  old('description') }}">
                           
                            @error('description')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Max People</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="max_people" type="text" placeholder="Vehicle Max People" value="{{ isset($vehicle->max_people) ? $vehicle->max_people :  old('max_people') }}">
                           
                            @error('max_people')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row d-none">
                        <label class="col-sm-12 col-md-2 col-form-label">Price</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="price" type="text" placeholder="Vehicle Price" value="{{ isset($vehicle->price) ? $vehicle->price :  old('price') }}">
                           
                            @error('price')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Sort Order</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" name="sort_order"  type="number" placeholder="Vehicle Sort Order" value="{{ isset($vehicle->sort_order) ? $vehicle->sort_order :  old('sort_order',0) }}">
                           
                            @error('sort_order')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Image</label>
                        <div class="col-sm-12 col-md-10">
                            <img id="vehicle_image"  src="{{ isset($vehicle->image) ? asset($vehicle->image)  : '/no_image.jpeg' }}" onclick="selectimage(0)">
                            <input type="file" id="input_image_0" class="form-control-file ml-5 d-none" name="image" accept="image/*" onchange="readURL(this,0);">
                            @error('image')
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
<script type="text/javascript">
   

    function selectimage(row_index){
        $('#input_image_'+row_index).trigger('click');   
    }

    function readURL(input,target_index) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#vehicle_image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

 
</script>

<style>
    img{
        max-height: 75px;
        cursor: pointer;
    }
</style>

@endsection
