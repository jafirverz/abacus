<form id="search-form" action="{{ url('marketplace-search-results') }}" method="get" enctype="multipart/form-data">
    <div class="row mkt-top">
        <div class="col-xl-auto col-lg-6">
            <div class="inrow search-wrap">
                <input type="text" name="search_input" placeholder="Car Make/Model" class="form-control" />
                <i class="fas fa-search"></i>
            </div>
        </div>
        <div class="col-xl-auto col-lg-6">
            <div class="inrow">
                <select name="price" class="selectpicker" id="price_range">
                    <option value="">Price Range</option>
                    @if(getFilterValByType(__('constant.PRICE_RANGE')))
                    @foreach(getFilterValByType(__('constant.PRICE_RANGE')) as $key=>$value)
                    <option value="{{ $value->from_value.'_'.$value->to_value }}">{{ $value->title }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-xl-auto col-lg-8">
            <div class="inrow">
                <select name="depreciation_price" class="selectpicker">
                    <option value="">Depreciation</option>
                    @if(getFilterValByType(__('constant.DEPRECIATION_RANGE')))
                    @foreach(getFilterValByType(__('constant.DEPRECIATION_RANGE')) as $key=>$value)
                    <option value="{{ $value->from_value.'_'.$value->to_value }}">{{ $value->title }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-xl-auto col-lg-4">
            <div class="inrow">
                <select class="selectpicker">
                    <option value="">Year Reg</option>
                    @if(getFilterValByType(__('constant.YEAR_OF_REGISTRATION')))
                    @foreach(getFilterValByType(__('constant.YEAR_OF_REGISTRATION')) as $key=>$value)
                    <option value="{{ $value->title }}">{{ $value->title }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-xl-auto col-lg-4">
            <div class="inrow">
                <select name="vehicle_type" class="selectpicker">
                    <option value="">Vehicle Type</option>
                    @if(getFilterValByType(__('constant.VEHICLE_TYPE')))
                    @foreach(getFilterValByType(__('constant.VEHICLE_TYPE')) as $key=>$value)
                    <option value="{{ $value->title }}">{{ $value->title }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-xl-auto col-lg-4">
            <div class="inrow search-reset">
                <button onclick="myFunction();" type="reset"><i class="fas fa-redo-alt"></i></button>
            </div>
        </div>
        <div class="col-xl-auto col-lg-4">
            <div class="inrow search-btns">
                <button class="btn-3">Search</button>
                {{-- <button class="btn-3">Compare</button> --}}
            </div>
        </div>
    </div>
</form>

<script>
    function myFunction()
    {
        $(".selectpicker").val('');
        $(".selectpicker").selectpicker("refresh");
    }

</script>
