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
                            <li class="breadcrumb-item active" aria-current="page">Trip</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary " onclick="event.preventDefault();
                    document.getElementById('trip-form').submit();"><i class="icon-copy fi-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary text-white" ><i class="icon-copy fi-x"></i> Cancel</a>

                </div>
            </div>
        </div>
        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h5 class="text-blue">Trip Information</h5>
                </div>
            </div>
            <div class="container">
                <form id="trip-form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-1 col-md-1 col-form-label">Country</label>
                        <div class="col-sm-2 col-md-2">
                            <div class="d-none">
                                {{ isset($trip->country) ? $country = $trip->country :  $country = old('country', $country_code ) }}
                                
                            </div>
                            <select class="form-control selectpicker" name="country" data-live-search="true">
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
                        </div>
                        <label class="col-sm-1 col-md-1 col-form-label">From</label>
                        <div class="col-sm-3 col-md-3">
                            <div class="d-none">
                                <!-- from location  -->
                                {{ isset($trip->from_location) ? $from_location = $trip->from_location :  $from_location = old('from_location') }}
                            </div>
                            <input type="text" class="form-control" name="from_location" id="from_location" placeholder="From" autocomplete="off" value="{{ $from_location }}"/>
                            @error('from_location')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                        <label class="col-sm-1 col-md-1 col-form-label">To</label>
                        <div class="col-sm-3 col-md-3">
                            <div class="d-none">
                                <!-- to location  -->
                                {{ isset($trip->to_location) ? $to_location = $trip->to_location :  $to_location = old('to_location') }}
                            </div>
                            <input type="text" class="form-control" name="to_location" id="to_location" placeholder="To" autocomplete="off" value="{{ $to_location }}"/>
                            @error('to_location')
                                <span class="text-danger font-weight-bold">* {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-1 col-md-1">
                            Airport
                            @if (isset($trip->is_airport) && $trip->is_airport)
                            <input type="checkbox" name="is_airport" id="is_airport" value="Ariport" checked/>
                            @else
                            <input type="checkbox" name="is_airport" id="is_airport" value="Ariport"/>
                            @endif
                           
                        </div>
                    </div>
                    <hr/>
                    <div class="container">
                        <h5 class="mb-20"><i class="icon-copy fa fa-car" aria-hidden="true"></i> Vehicles</h5>
                    </div>
                    <table class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="align-middle">Vehicle</th>
                                <th class="align-middle">Description</th>
                                <th class="align-middle text-center">Max people</th>
                                <th class="align-middle">Public Price </th>
                                <th class="align-middle">Agency Price </th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach ($vehicles as $vehicle)
                                <tr>
                                    <td class="align-middle">{{ $vehicle['name'] }}</td>
                                    <td class="align-middle">{{ $vehicle['description'] }}</td>
                                    <td class="align-middle text-center">{{ $vehicle['max_people'] }}</td>
                                    <td class="align-middle">
                                        <input type="text" class="form-control" name="vehicle[{{ $vehicle['id'] }}][public_price]" value="{{ isset($vehicle['public_price']) ? $vehicle['public_price'] : 0 }}" placeholder="Public Price"/>
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" class="form-control" name="vehicle[{{ $vehicle['id'] }}][private_price]" value="{{ isset($vehicle['private_price']) ? $vehicle['private_price'] : 0  }}" placeholder="Private Price"/>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script type="text/javascript">
     $('#from_location').typeahead({

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
        }

        });

        $('#to_location').typeahead({

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

@endsection