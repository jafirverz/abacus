<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\VehicleMain;
use App\VehicleDetail;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Attributes;
use App\Chat;
use App\ChatMessage;
use App\Specifications;
use Illuminate\Support\Facades\DB;
use App\ViewCount;
use App\LikeCount;

class MarketplaceController extends Controller
{
    use SystemSettingTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('Car Marketplace');
        $this->module = 'MARKETPLACE';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $cars = VehicleMain::with('detail')
                    ->orderBy('vehicle_mains.created_at', 'desc')
                    ->paginate($this->pagination);

        return view('admin.marketplace.index', compact('title', 'cars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        return view('admin.marketplace.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_make'  =>  'required',
            'vehicle_model'   =>  'required',
            'year_of_mfg'   =>  'required|numeric',
            'coe_expiry_date'   =>  'required|date|after:tomorrow',
            'vehicle_type'   =>  'required',
            'co2_emission_rate'   =>  'required',
            'engine_cc'   =>  'required',
            'open_market_value'   =>  'required',
            'no_of_transfers'   =>  'required',
            'coe_category'   =>  'required',
            'propellant'   =>  'required',
            'max_unladden_weight'   =>  'required',
            'road_tax_expiry_date' => 'required|date|after:tomorrow',
            'primary_color'   =>  'required',
            'orig_reg_date'   =>  'required|date',
            'first_reg_date'   =>  'required|date',
            'min_parf_benefit'   =>  'required',
            'quota_premium'   =>  'required',
            'power_rate'   =>  'required',
            'vehicle_scheme'   =>  'required',
            'seller'    =>  'required',
            'full_name' => 'required',
			'country' => 'required',
			'contact_number' => 'required',
			'email' => 'required',
			'vehicle_number' => 'required',
			'nric' => 'required',
			'price' => 'required',
			'mileage' => 'required',
            'gender' => 'required',
			// 'specification.*' => 'required',
			// 'additional_accessories.*' => 'required',
			// 'upload_file' => 'required',
            // 'seller_comment' => 'required'
        ]);

        $today_date = date("Y-m-d");
        $vehicleMain = new VehicleMain;
        $vehicleMain->seller_id = $request->seller;
        $vehicleMain->full_name = $request->full_name;
        $vehicleMain->email = $request->email;
        $vehicleMain->country = $request->country;
        $vehicleMain->contact_number = $request->contact_number;
        $vehicleMain->specification = json_encode($request->specification);
        $vehicleMain->additional_accessories = json_encode($request->additional_accessories);
        $vehicleMain->seller_comment = $request->seller_comment;
        $vehicleMain->gender = $request->gender;
		$vehicleMain->status = $request->status;
        $vehicleMain->save();

        $vehicleDetail = new VehicleDetail;
        $vehicleDetail->vehicle_id  = $vehicleMain->id;
        $vehicleDetail->vehicle_make = $request->vehicle_make;
        $vehicleDetail->vehicle_model = $request->vehicle_model;
        $vehicleDetail->vehicle_number = $request->vehicle_number;
        $vehicleDetail->year_of_mfg = $request->year_of_mfg;
        $vehicleDetail->coe_expiry_date = date('Y-m-d', strtotime($request->coe_expiry_date));
        $vehicleDetail->vehicle_type = $request->vehicle_type;
        $vehicleDetail->co2_emission_rate = $request->co2_emission_rate;
        $vehicleDetail->engine_cc =str_replace(',','', $request->engine_cc);
        $vehicleDetail->open_market_value = str_replace(',','',$request->open_market_value);
        $vehicleDetail->no_of_transfers = $request->no_of_transfers;
        $vehicleDetail->coe_category = $request->coe_category;
        $vehicleDetail->propellant = $request->propellant;
        $vehicleDetail->max_unladden_weight = str_replace(',','',$request->max_unladden_weight);
        $vehicleDetail->road_tax_expiry_date = date('Y-m-d', strtotime($request->road_tax_expiry_date));
        $vehicleDetail->primary_color = $request->primary_color;
        $vehicleDetail->orig_reg_date = date('Y-m-d', strtotime($request->orig_reg_date));
        $vehicleDetail->first_reg_date = date('Y-m-d', strtotime($request->first_reg_date));
        $vehicleDetail->min_parf_benefit = str_replace(',','', $request->min_parf_benefit);
        $vehicleDetail->quota_premium = str_replace(',','',$request->quota_premium);
        $vehicleDetail->power_rate = $request->power_rate;
        $vehicleDetail->vehicle_scheme = $request->vehicle_scheme;

        // $no_of_days_left_from_coe_expiry = dateDiff($request->coe_expiry_date, $today_date);
        // $vehicleDetail->depreciation_price = ($request->price - $request->min_parf_benefit) / ($no_of_days_left_from_coe_expiry * 365);
        $no_of_days_left_from_coe_expiry = dateDiff(date('Y-m-d', strtotime($request->coe_expiry_date)), $today_date);
        $forDepreciation = dateDiff(date('Y-m-d', strtotime($request->orig_reg_date. ' + 3652 days')), $today_date);
        //$car_detail->depreciation_price = (str_replace(',','',$request->price) - str_replace(',','',$request->min_parf_benefit)) / ($no_of_days_left_from_coe_expiry);
        // $car_detail->depreciation_price = ((str_replace(',','',$request->price) - str_replace(',','',$request->min_parf_benefit)) / ($no_of_days_left_from_coe_expiry))*365;
        if($forDepreciation > 0){
            $vehicleDetail->depreciation_price = ((str_replace(',','',$request->price) - str_replace(',','',$request->min_parf_benefit)) / ($no_of_days_left_from_coe_expiry))*365;
        }else{
            $vehicleDetail->depreciation_price = round((str_replace(',','',$request->price) / $no_of_days_left_from_coe_expiry)*365, 2);
        }

        $vehicleDetail->nric = $request->nric;
        $vehicleDetail->price = str_replace(',','',$request->price);
        $vehicleDetail->mileage = str_replace(',','',$request->mileage);
        $files = [];
        if($request->hasfile('upload_file'))
        {
            foreach($request->file('upload_file') as $file)
            {
                $filename = time().rand(1,50).'.'.$file->extension();
                $filepath = 'storage/upload-file/';
							Storage::putFileAs(
								'public/upload-file',
								$file,
								$filename
							);
                $files[] = $filepath.$filename;
            }
        }
        $vehicleDetail->upload_file  = json_encode($files);
        $vehicleDetail->save();

        // Add New Specification(s)
        foreach($request->specification as $key=>$spec){
            $sp = Specifications::where('specification', '=', $spec)->first();
            if(!isset($sp)){
                $specification = new Specifications;
                $specification->specification = $spec;
                $specification->position = 1;
                $specification->status = 1;
                $specification->save();
            }
        }
        // Add New Accessories
        foreach($request->additional_accessories as $key=>$accessories){
            $attr = Attributes::where('attribute_title', '=', $accessories)->first();
            if(!isset($attr)){
                $attribute = new Attributes;
                $attribute->attribute_title = $accessories;
                $attribute->position = 1;
                $attribute->status = 1;
                $attribute->save();
            }
        }

        return redirect()->route('marketplace.index')->with('success',  __('constant.CREATED', ['module'   =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $car = VehicleMain::with('detail')
                ->where('vehicle_mains.id', '=', $id)->first();

        if(isset($car))
        return view('admin.marketplace.show', compact('title', 'car'));
        else
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $car = VehicleMain::with('detail')
                ->where('vehicle_mains.id', '=', $id)->first();
        
        if(isset($car))
        return view('admin.marketplace.edit', compact('title', 'car'));
        else
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'vehicle_make'  =>  'required',
            'vehicle_model'   =>  'required',
            'year_of_mfg'   =>  'required|numeric',
            'coe_expiry_date'   =>  'required|date|after:tomorrow',
            'vehicle_type'   =>  'required',
            'co2_emission_rate'   =>  'required',
            'engine_cc'   =>  'required',
            'open_market_value'   =>  'required',  /////////
            'no_of_transfers'   =>  'required|numeric',
            'coe_category'   =>  'required',
            'propellant'   =>  'required',
            'max_unladden_weight'   =>  'required',//ddd
            'road_tax_expiry_date' => 'required|date|after:tomorrow',
            'primary_color'   =>  'required',
            'orig_reg_date'   =>  'required|date',
            'first_reg_date'   =>  'required|date',
            'min_parf_benefit'   =>  'required',  ///////////
            'quota_premium'   =>  'required', //ddd
            'power_rate'   =>  'required',
            'vehicle_scheme'   =>  'required',
            // 'seller'   =>  'required',
            'full_name' => 'required',
			// 'country' => 'required',
			'contact_number' => 'required',
			'email' => 'required',
			'vehicle_number' => 'required',
			'nric' => 'required',
			'price' => 'required',
			// 'specification.*' => 'required',
			// 'additional_accessories.*' => 'required',
			// 'upload_file' => 'required',
			'mileage' => 'required'
        ]);
        $today_date = date("Y-m-d");
        $car = VehicleMain::where('id', '=', $id)->first();
        $car_detail = VehicleDetail::where('vehicle_id', '=', $id)->first();

        $car->seller_id = $request->seller;
        $car->full_name = $request->full_name;
        $car->email = $request->email;
        $car->country = $request->country;
        $car->gender = $request->gender;
        $car->contact_number = $request->contact_number;
        $car->specification = json_encode($request->specification);
        $car->additional_accessories = json_encode($request->additional_accessories);
        $car->status = $request->status;
        $car->seller_comment = $request->sellercomment;
        $car->updated_at = Carbon::now();
        $car->save();

        $car_detail->vehicle_make = $request->vehicle_make;
        $car_detail->vehicle_model = $request->vehicle_model;
        $car_detail->year_of_mfg = $request->year_of_mfg;
        $car_detail->coe_expiry_date = date('Y-m-d', strtotime($request->coe_expiry_date));
        $car_detail->vehicle_type = $request->vehicle_type;
        $car_detail->co2_emission_rate = $request->co2_emission_rate;
        $car_detail->engine_cc = str_replace(',','',$request->engine_cc);
        $car_detail->open_market_value = str_replace(',','', $request->open_market_value);
        $car_detail->no_of_transfers = $request->no_of_transfers;
        $car_detail->coe_category = $request->coe_category;
        $car_detail->propellant = $request->propellant;
        $car_detail->max_unladden_weight = str_replace(',','',$request->max_unladden_weight);
        $car_detail->road_tax_expiry_date = date('Y-m-d', strtotime($request->road_tax_expiry_date));
        $car_detail->primary_color = $request->primary_color;
        $car_detail->orig_reg_date = date('Y-m-d', strtotime($request->orig_reg_date));
        $car_detail->first_reg_date = date('Y-m-d', strtotime($request->first_reg_date));
        $car_detail->min_parf_benefit = str_replace(',','',$request->min_parf_benefit);
        $car_detail->quota_premium = str_replace(',','',$request->quota_premium);
        $car_detail->power_rate = $request->power_rate;
        $car_detail->vehicle_scheme = $request->vehicle_scheme;
        $no_of_days_left_from_coe_expiry = dateDiff(date('Y-m-d', strtotime($request->coe_expiry_date)), $today_date);
        $forDepreciation = dateDiff(date('Y-m-d', strtotime($request->orig_reg_date. ' + 3652 days')), $today_date);
        //$car_detail->depreciation_price = (str_replace(',','',$request->price) - str_replace(',','',$request->min_parf_benefit)) / ($no_of_days_left_from_coe_expiry);
        // $car_detail->depreciation_price = ((str_replace(',','',$request->price) - str_replace(',','',$request->min_parf_benefit)) / ($no_of_days_left_from_coe_expiry))*365;
        if($forDepreciation > 0){
            $car_detail->depreciation_price = ((str_replace(',','',$request->price) - str_replace(',','',$request->min_parf_benefit)) / ($no_of_days_left_from_coe_expiry))*365;
        }else{
            $car_detail->depreciation_price = round((str_replace(',','',$request->price) / $no_of_days_left_from_coe_expiry)*365, 2);
        }
        // dd($no_of_days_left_from_coe_expiry);
        // dd(round((str_replace(',','',$request->price) / $no_of_days_left_from_coe_expiry)*365, 2));
        $car_detail->nric = $request->nric;
        $car_detail->price = str_replace(',','',$request->price);
        $car_detail->mileage = str_replace(',','',$request->mileage);
        $car_detail->vehicle_number = $request->vehicle_number;
        $files = [];
        $old_files_arr = json_decode($car_detail->upload_file);
        if($request->hasfile('upload_file'))
        {
            foreach($request->file('upload_file') as $file)
            {
                $filename = time().rand(1,50).'.'.$file->extension();
                $filepath = 'storage/upload-file/';
							Storage::putFileAs(
								'public/upload-file',
								$file,
								$filename
							);
                $files[] = $filepath.$filename;
            }
        }
        if(isset($old_files_arr)){
            $files = array_merge($files, $old_files_arr);
        }
        $car_detail->upload_file  = json_encode($files);
        $car_detail->updated_at = Carbon::now();
        $car_detail->save();

        // Add New Specification(s)
        if(isset($request->specification) && sizeof($request->specification) > 0){
            foreach($request->specification as $key=>$spec){
                $sp = Specifications::where('specification', '=', $spec)->first();
                if(!isset($sp)){
                    $specification = new Specifications;
                    $specification->specification = $spec;
                    $specification->position = 1;
                    $specification->status = 1;
                    $specification->save();
                }
            }
        }
        
        // Add New Accessories
        if(isset($request->additional_accessories) && sizeof($request->additional_accessories) > 0){
            foreach($request->additional_accessories as $key=>$accessories){
                $attr = Attributes::where('attribute_title', '=', $accessories)->first();
                if(!isset($attr)){
                    $attribute = new Attributes;
                    $attribute->attribute_title = $accessories;
                    $attribute->position = 1;
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
        }
        
        if(!empty($request->previousUrll)){
            return redirect($request->previousUrll)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }else{
            return redirect()->route('marketplace.index', $id)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }
        // return redirect()->route('marketplace.index', $id)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        $chats = Chat::whereIn('vehicle_main_id', $id)->pluck('id')->toArray();
        if(sizeof($chats) > 0){
            ChatMessage::whereIn('chat_id', $chats)->delete();
            Chat::whereIn('vehicle_main_id', $id)->delete();
        }
        
        VehicleDetail::whereIn('vehicle_id', $id)->delete();
        ViewCount::whereIn('vehicle_id', $id)->delete();
        LikeCount::whereIn('vehicle_id', $id)->delete();
        VehicleMain::whereIn('id', $id)->delete();
        // VehicleMain::destroy($id);
        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $query = DB::table('vehicle_mains as vm')
                    ->join('vehicle_details as vd', 'vm.id', '=', 'vd.vehicle_id');
                    
        if($request->search!="")
		{
		    $query->where('vd.vehicle_number', 'like', '%'.$request->search.'%')
                    ->orWhere('vm.full_name', 'like', '%'.$request->search.'%');
		}

        if($request->status!="")
		{
		    $query->where('vm.status', $request->status);
		}
        
		if($request->type!="")
		{
		    $query->where('vd.vehicle_type', $request->type);
		}

        if($request->make!="")
		{
		    $query->where('vd.vehicle_make', $request->make);
		}

        if($request->model!="")
		{
		    $query->where('vd.vehicle_model', $request->model);
		}
        $cars = $query->orderBy('vm.created_at', 'desc')
                ->paginate($this->systemSetting()->pagination);
        
        return view('admin.marketplace.index', compact('title', 'cars'));
    }

    public function deleteImage(Request $request){
        $id = $request->carId;
        $imageName = $request->imageName;
        $vehicleDetails = VehicleDetail::where('id', $id)->first();
        if($vehicleDetails){
            $allImages = json_decode($vehicleDetails->upload_file);
            if (($key = array_search($imageName, $allImages)) !== false) {
                unset($allImages[$key]);
            }
            $allImages = array_values($allImages);
            $vehicleDetails->upload_file = json_encode($allImages, true);
            $vehicleDetails->save();
            return response()->json(array('success' => true));
        }else{
            return response()->json(array('success' => false));
        }
    }
}
