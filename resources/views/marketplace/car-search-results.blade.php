@extends('layouts.app')
@section('content')

@php
$string='';
$result=getMakeModel();
if($result)
{

    foreach($result as $preference)
    {
        $string.='"'.$preference.'",';
    }

    $string=html_entity_decode(htmlentities($string));
}

@endphp
    <div class="main-wrap">
        <div class="bn-inner bg-get-image">
            @include('inc.banner')
        </div>
        <div class="container main-inner about-wrap-1">

            <div class="clearfix"></div>
            <div class="marketplace-holder mt-20 marketplace-search-result">
                <form id="search-form" action="" method="get" enctype="multipart/form-data">
                <div class="row mkt-top align-items-center">
                    <div class="col-xl-auto col-lg-6">
                        <div class="inrow big-search search-wrap">
                            <input type="text" name="search_input" id="myInput" value="@if(request()->get('search_input')!="") {{ request()->get('search_input') }} @endif" placeholder="Car Make/Model" class="form-control" />
                            <i class="fas fa-search"></i>
                        </div>
                    </div>

                    <div class="col-xl-auto col-lg-4">
                        <div class="inrow search-reset">
                            @if(request()->get('search_input')!="")
                            <a href="{{ url('marketplace-search-results') }}"><i class="fas fa-redo-alt"></i></a>
                            @else
                            <button id="reset_button" type="reset"><i class="fas fa-redo-alt"></i></button>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-auto col-lg-4">
                        <div class="inrow search-btns">
                            <button class="btn-3">Search</button>

                        </div>
                    </div>
                    <div class="col-xl-auto col-lg-4">
                        <div class="inrow search-btns">

                            <select name="listing_status" class="selectpicker" onchange="get_filter(this.value,'listing_status');">
                                <option value="">Type</option>
                                @if(getlistingStatus())
                                @foreach(getlistingStatus() as $key =>$value)
                                <option @if(request()->get('listing_status')==$key) selected @endif value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                </form>
                <div class="row search-result-wrap">
                    <div class="table-responsive result-table">
                        <table id="myTable">
                            <thead>
                                <tr class="tr1">
                                    <th>

                                    </th>
                                    <th>
                                        <div class="inrow">
                                            <select name="make" class="selectpicker" onchange="get_filter(this.value,'make');">
                                                <option value="">Make</option>
                                                 @if(getFilterValByType(__('constant.MAKE')))
                                                 @foreach(getFilterValByType(__('constant.MAKE')) as $key=>$value)
                                                 <option value="{{ $value->title }}">{{ $value->title }}</option>
                                                 @endforeach
                                                 @endif
                                            </select>
                                        </div>

                                    </th>
                                    <th>
                                        <div class="inrow">
                                            <select name="model" class="selectpicker" onchange="get_filter(this.value,'model');">
                                                <option value="">Model</option>
                                                 @if(getFilterValByType(__('constant.MODEL')))
                                                 @foreach(getFilterValByType(__('constant.MODEL')) as $key=>$value)
                                                 <option value="{{ $value->title }}">{{ $value->title }}</option>
                                                 @endforeach
                                                 @endif
                                            </select>
                                        </div>

                                    </th>
                                    <th>
                                        <div class="inrow">
                                            <select name="price" class="selectpicker" onchange="get_filter(this.value,'price');">
                                                <option value="">Price</option>
                                                 @if(getFilterValByType(__('constant.PRICE_RANGE')))
                                                 @foreach(getFilterValByType(__('constant.PRICE_RANGE')) as $key=>$value)
                                                 <option value="{{ $value->from_value.'_'.$value->to_value }}">{{ $value->title }}</option>
                                                 @endforeach
                                                 @endif
                                            </select>
                                        </div>

                                    </th>
                                    <th>
                                        <div class="inrow">
                                            <select name="depreciation_price" class="selectpicker" onchange="get_filter(this.value,'depreciation_price');">
                                                <option value="">DEPR</option>
                                                 @if(getFilterValByType(__('constant.DEPRECIATION_RANGE')))
                                                 @foreach(getFilterValByType(__('constant.DEPRECIATION_RANGE')) as $key=>$value)
                                                 <option value="{{ $value->from_value.'_'.$value->to_value }}">{{ $value->title }}</option>
                                                 @endforeach
                                                 @endif
                                            </select>
                                        </div>

                                    </th>
                                    <th>
                                        <div class="inrow">
                                            <select name="orig_reg_date" class="selectpicker" onchange="get_filter(this.value,'orig_reg_date');">
                                                <option value="">REG</option>
                                                 @if(getFilterValByType(__('constant.YEAR_OF_REGISTRATION')))
                                                 @foreach(getFilterValByType(__('constant.YEAR_OF_REGISTRATION')) as $key=>$value)
                                                 <option value="{{ $value->title }}">{{ $value->title }}</option>
                                                 @endforeach
                                                 @endif
                                            </select>
                                        </div>

                                    </th>
                                    <th>
                                        <div class="inrow">
                                            <select name="engine_cc" class="selectpicker" onchange="get_filter(this.value,'engine_cc');">
                                                <option value="">ENG CAP</option>
                                                 @if(getFilterValByType(__('constant.ENGINE_CAPACITY')))
                                                 @foreach(getFilterValByType(__('constant.ENGINE_CAPACITY')) as $key=>$value)
                                                 <option value="{{ $value->from_value.'_'.$value->to_value }}">{{ $value->title }}</option>
                                                 @endforeach
                                                 @endif
                                            </select>
                                        </div>

                                    </th>
                                    <th>
                                        <div class="inrow">
                                            <select name="mileage" class="selectpicker" onchange="get_filter(this.value,'mileage');">
                                                <option value="">MIL</option>
                                                 @if(getFilterValByType(__('constant.MILEAGE')))
                                                 @foreach(getFilterValByType(__('constant.MILEAGE')) as $key=>$value)
                                                 <option value="{{ $value->from_value.'_'.$value->to_value }}">{{ $value->title }}</option>
                                                 @endforeach
                                                 @endif
                                            </select>
                                        </div>

                                    </th>
                                    <th>
                                        <div class="inrow">
                                            <select name="vehicle_type" class="selectpicker" onchange="get_filter(this.value,'vehicle_type');">
                                                <option>Type</option>
                                                 @if(getFilterValByType(__('constant.VEHICLE_TYPE')))
                                                 @foreach(getFilterValByType(__('constant.VEHICLE_TYPE')) as $key=>$value)
                                                 <option value="{{ $value->title }}">{{ $value->title }}</option>
                                                 @endforeach
                                                 @endif
                                            </select>
                                        </div>

                                    </th>
                                    <th>
                                        <div class="inrow">
                                            <select name="status" class="selectpicker" onchange="get_filter(this.value,'status');">
                                                <option value="">Status</option>
                                                @if(getVehicleStatus())
                                                @foreach(getVehicleStatus() as $key=>$value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tr2">
                                    <td></td>
                                    <td>
                                        @if(request()->get('make')!="")
                                        {{ request()->get('make') }}
                                        @else
                                        Any
                                        @endif
                                    </td>
                                    <td>
                                        @if(request()->get('model')!="")
                                        {{ request()->get('model') }}
                                        @else
                                        Any
                                        @endif
                                    </td>
                                    <td>
                                        @if(request()->get('price')!="")
                                        {{ getFilterValByVal(__('constant.PRICE_RANGE'),request()->get('price')) ?? '' }}
                                        @else
                                        Any
                                        @endif
                                    </td>
                                    <td>
                                        @if(request()->get('depreciation_price')!="")
                                        {{ getFilterValByVal(__('constant.DEPRECIATION_RANGE'),request()->get('depreciation_price')) ?? '' }}
                                        @else
                                        Any
                                        @endif
                                    </td>
                                    <td>
                                        @if(request()->get('orig_reg_date')!="")
                                        {{ request()->get('orig_reg_date') }}
                                        @else
                                        Any
                                        @endif
                                    </td>
                                    <td>
                                        @if(request()->get('engine_cc')!="")
                                        {{ getFilterValByVal(__('constant.ENGINE_CAPACITY'),request()->get('engine_cc')) ?? '' }}
                                        @else
                                        Any
                                        @endif

                                    </td>
                                    <td>
                                        @if(request()->get('mileage')!="")
                                        {{ getFilterValByVal(__('constant.MILEAGE'),request()->get('mileage')) ?? '' }}
                                        @else
                                        Any
                                        @endif
                                    </td>
                                    <td>
                                        @if(request()->get('vehicle_type')!="")
                                        {{ request()->get('vehicle_type') }}
                                        @else
                                        Any
                                        @endif
                                    </td>
                                    <td>
                                        @if(request()->get('status')!="")
                                        {{ request()->get('status')>0?getVehicleStatus( request()->get('status')): '' }}
                                        @else
                                        Any
                                        @endif
                                    </td>
                                </tr>
                                @if($cars)
                                @foreach($cars as $key => $value)
                                <tr>
                                    <td>
                                        <div class="product-s-photo">
                                            {{-- <div class="met-compare">
                                                <a href="#"><img src="images/material-compare.png" class="icon-normal"
                                                        alt=""><img src="images/material-compare-hover.png"
                                                        class="icon-hover" alt=""></a>
                                            </div> --}}
                                            @php
                                            $upload_file=json_decode($value->upload_file);
                                            @endphp
                                            @if(isset($upload_file['0']))
                                            <figure class="imgwrap"><a href="{{ url('car/'.$value->vehicle_id.'/marketplace-details')}}"><img src="{{ url($upload_file[0]) }}" alt=""></a>
                                            </figure>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{ $value->vehicle_make ?? '' }}
                                    </td>
                                    <td>
                                        {{ $value->vehicle_model ?? '' }}
                                    </td>
                                    <td>
                                        <div class="prod-tb-price bdr"><strong>${{ number_format($value->price) ?? '' }} </strong></div>
                                    </td>
                                    <td>
                                        <div class="prod-tb-depr bdr">${{ number_format($value->depreciation_price) ?? '' }}/yr</div>
                                    </td>
                                    <td>
                                        <div class="prod-tb-reg bdr">{{ date('d M Y', strtotime($value->first_reg_date)) ?? '' }}</div>
                                    </td>
                                    <td>
                                        <div class="prod-tb-engcap bdr">{{ $value->engine_cc ?? '' }} cc</div>
                                    </td>
                                    <td>
                                        <div class="prod-tb-mil bdr">{{ number_format($value->mileage) ?? '' }} km</div>
                                    </td>
                                    <td>
                                        <div class="prod-tb-type bdr">{{ $value->vehicle_type ?? '' }}</div>
                                    </td>
                                    <td>
                                        <div class="prod-tb-status av">{{ $value->status>0?getVehicleStatus( $value->status): '' }}</div>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('footer-scripts')
    <script>
        $(document).ready(function() {
            // $('#myTable').DataTable({
            //     searching: false,
            //     paging: false,
            //     info: false
            // });
            
            var $tr = $('#myTable tr.tr2'); //get the reference of row with the class no-sort
            var mySpecialRow = $tr.prop('outerHTML'); //get html code of tr
            $tr.remove(); //remove row of table
            $('#myTable').DataTable({
                "fnDrawCallback": function(){
                    //add the row with 'prepend' method: in the first children of TBODY
                    $('#myTable tbody').prepend(mySpecialRow);

                } ,
                searching: false,
                paging: false,
                info: false
            });

            $('#reset_btn').click(function(){
                $('#search-form')[0].reset();
            });
        });

        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        /*An array containing all the country names in the world:*/
        var make_model = [<?=$string?>];

        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        autocomplete(document.getElementById("myInput"), make_model);
        function get_filter(filter,type)
        {
            var url= '{{ url()->full() }}';
            var current= '{{ url()->current() }}';
            //alert(type);
            if(type=='make')
            {
                var custom_url=current+'?make='+filter+'&model={{ request()->get("model") }}&price={{ request()->get("price") }}&depreciation_price={{ request()->get("depreciation_price") }}&orig_reg_date={{ request()->get("orig_reg_date") }}&engine_cc={{ request()->get("engine_cc") }}&mileage={{ request()->get("mileage") }}&vehicle_type={{ request()->get("vehicle_type") }}&status={{ request()->get("status") }}&listing_status={{ request()->get("listing_status") }}';
            }
            else if(type=='model')
            {
                var custom_url=current+'?make={{ request()->get("make") }}&model='+filter+'&price={{ request()->get("price") }}&depreciation_price={{ request()->get("depreciation_price") }}&orig_reg_date={{ request()->get("orig_reg_date") }}&engine_cc={{ request()->get("engine_cc") }}&mileage={{ request()->get("mileage") }}&vehicle_type={{ request()->get("vehicle_type") }}&status={{ request()->get("status") }}&listing_status={{ request()->get("listing_status") }}';
            }
            else if(type=='price')
            {
                var custom_url=current+'?make={{ request()->get("make") }}&model={{ request()->get("model") }}&price='+filter+'&depreciation_price={{ request()->get("depreciation_price") }}&orig_reg_date={{ request()->get("orig_reg_date") }}&engine_cc={{ request()->get("engine_cc") }}&mileage={{ request()->get("mileage") }}&vehicle_type={{ request()->get("vehicle_type") }}&status={{ request()->get("status") }}&listing_status={{ request()->get("listing_status") }}';
            }
            else if(type=='depreciation_price')
            {
                var custom_url=current+'?make={{ request()->get("make") }}&model={{ request()->get("model") }}&price={{ request()->get("price") }}&depreciation_price='+filter+'&orig_reg_date={{ request()->get("orig_reg_date") }}&engine_cc={{ request()->get("engine_cc") }}&mileage={{ request()->get("mileage") }}&vehicle_type={{ request()->get("vehicle_type") }}&status={{ request()->get("status") }}&listing_status={{ request()->get("listing_status") }}';
            }
            else if(type=='orig_reg_date')
            {
                var custom_url=current+'?make={{ request()->get("make") }}&model={{ request()->get("model") }}&price={{ request()->get("price") }}&depreciation_price={{ request()->get("depreciation_price") }}&orig_reg_date='+filter+'&engine_cc={{ request()->get("engine_cc") }}&mileage={{ request()->get("mileage") }}&vehicle_type={{ request()->get("vehicle_type") }}&status={{ request()->get("status") }}&listing_status={{ request()->get("listing_status") }}';
            }
            else if(type=='engine_cc')
            {
                var custom_url=current+'?make={{ request()->get("make") }}&model={{ request()->get("model") }}&price={{ request()->get("price") }}&depreciation_price={{ request()->get("depreciation_price") }}&orig_reg_date={{ request()->get("orig_reg_date") }}&engine_cc='+filter+'&mileage={{ request()->get("mileage") }}&vehicle_type={{ request()->get("vehicle_type") }}&status={{ request()->get("status") }}&listing_status={{ request()->get("listing_status") }}';
            }
            else if(type=='mileage')
            {
                var custom_url=current+'?make={{ request()->get("make") }}&model={{ request()->get("model") }}&price={{ request()->get("price") }}&depreciation_price={{ request()->get("depreciation_price") }}&orig_reg_date={{ request()->get("orig_reg_date") }}&engine_cc={{ request()->get("engine_cc") }}&mileage='+filter+'&vehicle_type={{ request()->get("vehicle_type") }}&status={{ request()->get("status") }}&listing_status={{ request()->get("listing_status") }}';
            }
            else if(type=='vehicle_type')
            {
                var custom_url=current+'?make={{ request()->get("make") }}&model={{ request()->get("model") }}&price={{ request()->get("price") }}&depreciation_price={{ request()->get("depreciation_price") }}&orig_reg_date={{ request()->get("orig_reg_date") }}&engine_cc={{ request()->get("engine_cc") }}&mileage={{ request()->get("mileage") }}&vehicle_type='+filter+'&status={{ request()->get("status") }}&listing_status={{ request()->get("listing_status") }}';
            }
            else if(type=='status')
            {
                var custom_url=current+'?make={{ request()->get("make") }}&model={{ request()->get("model") }}&price={{ request()->get("price") }}&depreciation_price={{ request()->get("depreciation_price") }}&orig_reg_date={{ request()->get("orig_reg_date") }}&engine_cc={{ request()->get("engine_cc") }}&mileage={{ request()->get("mileage") }}&vehicle_type={{ request()->get("vehicle_type") }}&status='+filter+'&listing_status={{ request()->get("listing_status") }}';
            }
            else if(type=='listing_status')
            {
                var custom_url=current+'?make={{ request()->get("make") }}&model={{ request()->get("model") }}&price={{ request()->get("price") }}&depreciation_price={{ request()->get("depreciation_price") }}&orig_reg_date={{ request()->get("orig_reg_date") }}&engine_cc={{ request()->get("engine_cc") }}&mileage={{ request()->get("mileage") }}&vehicle_type={{ request()->get("vehicle_type") }}&status={{ request()->get("status") }}&listing_status='+filter;
            }
            window.location=custom_url;
        }
    </script>
@endpush
