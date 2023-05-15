<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;
use App\VehicleMain;
use App\VehicleDetail;
use App\ViewCount;
use App\LikeCount;
use App\Filter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\SystemSettingTrait;

class MarketplaceController extends Controller
{
    //use SystemSettingTrait, GetSmartBlock, GetEmailTemplate;
    use SystemSettingTrait;
    public function __construct()
    {
        //$this->middleware('auth:web');
        // $this->system_settings = $this->systemSetting();
        // $this->smart_blocks = $this->smartBlock();
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $slug = 'marketplace-listing';
        $page = get_page_by_slug($slug);
        $user_ip = \Request::ip();

		if (!$page) {
			return abort(404);
		}
        $title = 'Car Marketplace';

        // Most Viewed Vehicles
        // if(!Auth::guest()){
        //     $loggedUserID = Auth::user()->id;
        //     $mostViewedVehicles = ViewCount::with('vehicle.vehicleDetail')
        //                             ->where('vehicle_view_counts.user_id', '=', $loggedUserID)
        //                             ->take(12)
        //                             ->orderBy('view_count', 'desc')
        //                             ->get();
        // }else{
        //     $mostViewedVehicles = ViewCount::with('vehicle.vehicleDetail')
        //                             ->where('vehicle_view_counts.user_ip', '=', $user_ip)
        //                             ->whereNull('vehicle_view_counts.user_id')
        //                             ->take(12)
        //                             ->orderBy('view_count', 'desc')
        //                             ->get();
        // }
        
        // $mostViewedVehicles = ViewCount::with('vehicle.vehicleDetail')
        //                             ->select('view_count','vehicle_id', DB::raw('count(view_count) as total'))
        //                             ->take(12)
        //                             ->groupBy('vehicle_id')
        //                             ->orderBy('total', 'desc')
        //                             ->get();
        
        // Working fine
        // $mostViewedVehicles = ViewCount::has('vehicle.vehicleDetail')
        //                             ->select('view_count','vehicle_id', DB::raw('count(view_count) as total'))
        //                             ->take(12)
        //                             ->groupBy('vehicle_id')
        //                             ->orderBy('total', 'desc')
        //                             ->get();
         $mostViewedVehicles = ViewCount::whereHas('vehicle', function($q)
        {
            $q->whereIn('status',[2,5]);
        
        })->has('vehicle.vehicleDetail')
                                    ->select('view_count','vehicle_id', DB::raw('count(view_count) as total'))
                                    ->take(12)
                                    ->groupBy('vehicle_id')
                                    ->orderBy('total', 'desc')
                                    ->get();
        // dd($mostViewedVehicles);

        // Most Liked Vehicles
        // $mostLikedVehicles = LikeCount::with('vehicle.vehicleDetail')
        //                         ->addSelect('vehicle_like_counts.vehicle_id', DB::raw('count(*) as like_count'))
        //                         ->where('vehicle_like_counts.is_liked', '=', 1)
        //                         ->groupBy('vehicle_like_counts.user_id', 'vehicle_like_counts.vehicle_id')
        //                         ->take(8)
        //                         ->orderBy('like_count', 'desc')
        //                         ->get();
         $mostLikedVehicles = LikeCount::whereHas('vehicle', function($q)
        {
            $q->where('status','!=', 3);
        
        })->has('vehicle.vehicleDetail')
                                ->addSelect('vehicle_like_counts.vehicle_id', DB::raw('count(*) as like_count'))
                                ->where('vehicle_like_counts.is_liked', '=', 1)
                                ->groupBy('vehicle_like_counts.vehicle_id')
                                ->take(8)
                                ->orderBy('like_count', 'desc')
                                ->get();
        //dd($mostLikedVehicles);

        //Price section cars
        $lowestPriceVehicles = DB::table('vehicle_mains as vm')
                                ->join('vehicle_details as vd', 'vm.id', '=', 'vd.vehicle_id')
                                ->whereIn('vm.status', [2,5])
                                ->take(8)
                                ->orderBy('vd.price', 'asc')
                                ->get();

        // Depreciation wise vehicles
        $depreciationWiseVehicles = DB::table('vehicle_mains as vm')
                                    ->join('vehicle_details as vd', 'vm.id', '=', 'vd.vehicle_id')
                                    ->whereIn('vm.status', [2,5])
                                    ->whereNotNull('vd.depreciation_price')
                                    ->take(8)
                                    ->orderBy('vd.depreciation_price', 'asc')
                                    ->get();

        // Age wise vehicles
        $ageWiseVehicles = DB::table('vehicle_mains as vm')
                            ->join('vehicle_details as vd', 'vm.id', '=', 'vd.vehicle_id')
                            ->select('vm.*', 'vd.*', DB::raw('(YEAR(CURDATE()) - vd.year_of_mfg)as age'))
                            ->whereIn('vm.status', [2,5])
                            ->take(8)
                            ->orderBy('age', 'asc')
                            ->get();

        // Sold vehicles
        $soldVehicles = VehicleMain::with('detail')
                        ->where('vehicle_mains.status', '=', '3')
                        ->take(5)
                        ->orderBy('vehicle_mains.updated_at', 'desc')
                        ->get();

        // Auction vehicles
        $auctionVehicles = VehicleMain::with('detail')
                        ->where('vehicle_mains.status', '=', '4')
                        ->take(5)
                        ->orderBy('vehicle_mains.updated_at', 'desc')
                        ->get();

        // New Listing Vehicles
        $latestVehicles = VehicleMain::with('detail')
                            ->whereIn('vehicle_mains.status', [2,5])
                            ->take(8)
                            ->orderBy('vehicle_mains.created_at', 'desc')
                            ->get();

        // Vehicle Types
        $vehicleTypes = Filter::where('type', '=', 4) // vehicle_type
                        ->orderBy('view_order', 'desc')
                        ->take(3)
                        ->get();

        return view('marketplace.index', compact('page', 'title', 'latestVehicles', 'mostViewedVehicles', 'mostLikedVehicles', 'lowestPriceVehicles', 'depreciationWiseVehicles', 'ageWiseVehicles', 'soldVehicles', 'auctionVehicles', 'vehicleTypes'));
    }

    public function viewAll($slug){
        $page_slug = 'view-all-marketplace';
        $page = get_page_by_slug($page_slug);
        $user_ip = \Request::ip();

		if (!$page) {
			return abort(404);
		}
        $title = 'View All Marketplace';

        if($slug == 'most-viewed'){
            $section_title = 'Most Viewed';
            // Most Viewed Vehicles
            if(!Auth::guest()){
                $loggedUserID = Auth::user()->id;
                $mostViewedVehicles = ViewCount::with('vehicle.vehicleDetail')
                                        ->where('vehicle_view_counts.user_id', '=', $loggedUserID)
                                        ->take(15)
                                        ->orderBy('view_count', 'desc')
                                        ->get();
                //dd($mostViewedVehicles);
            }else{
                $mostViewedVehicles = ViewCount::with('vehicle.vehicleDetail')
                                        ->where('vehicle_view_counts.user_ip', '=', $user_ip)
                                        ->whereNull('vehicle_view_counts.user_id')
                                        ->take(15)
                                        ->orderBy('view_count', 'desc')
                                        ->get();
                //dd($mostViewedVehicles);
            }

            $all_items = $mostViewedVehicles;
        }
        elseif ($slug == 'most-liked') {
            $section_title = 'Most Liked';
            // Most Liked Vehicles
            $mostLikedVehicles = LikeCount::with('vehicle.vehicleDetail')
                                ->addSelect('vehicle_like_counts.vehicle_id', DB::raw('count(*) as like_count'))
                                ->where('vehicle_like_counts.is_liked', '=', 1)
                                ->groupBy('vehicle_like_counts.user_id', 'vehicle_like_counts.vehicle_id')
                                ->take(10)
                                ->orderBy('like_count', 'desc')
                                ->paginate($this->pagination);

            $all_items = $mostLikedVehicles;
        }
        elseif ($slug == 'lowest-priced') {
            $section_title = 'Price';
            //Price section cars
            $lowestPriceVehicles = DB::table('vehicle_mains as vm')
                                    ->join('vehicle_details as vd', 'vm.id', '=', 'vd.vehicle_id')
                                    ->where('vm.status', '<>', '1')
                                    ->orderBy('vd.price', 'asc')
                                    ->paginate($this->pagination);

            $all_items = $lowestPriceVehicles;
        }
        elseif ($slug == 'depreciation_price') {
            $section_title = 'Depreciation';
            // Depreciation wise vehicles
            $depreciationWiseVehicles = DB::table('vehicle_mains as vm')
                                        ->join('vehicle_details as vd', 'vm.id', '=', 'vd.vehicle_id')
                                        ->where('vm.status', '<>', '1')
                                        ->whereNotNull('vd.depreciation_price')
                                        ->orderBy('vd.depreciation_price', 'asc')
                                        ->paginate($this->pagination);

            $all_items = $depreciationWiseVehicles;
        }
        elseif ($slug == 'age') {
            $section_title = 'Age';
            // Age wise vehicles
            $ageWiseVehicles = DB::table('vehicle_mains as vm')
                                ->join('vehicle_details as vd', 'vm.id', '=', 'vd.vehicle_id')
                                ->select('vm.*', 'vd.*', DB::raw('(YEAR(CURDATE()) - vd.year_of_mfg)as age'))
                                ->where('vm.status', '<>', '1')
                                ->orderBy('age', 'asc')
                                ->paginate($this->pagination);

            $all_items = $ageWiseVehicles;
        }
        elseif ($slug == 'new-listing') {
            $section_title = 'New Listing';
            // New Listing Vehicles
            $latestVehicles = VehicleMain::with('detail')
                                ->where('vehicle_mains.status', '<>', '1')
                                ->orderBy('vehicle_mains.created_at', 'desc')
                                ->paginate($this->pagination);

            $all_items = $latestVehicles;
        }
        elseif ($slug == 'sold') {
            $section_title = 'Vehicle Sold';
            // Sold vehicles
            $soldVehicles = VehicleMain::with('detail')
                            ->where('vehicle_mains.status', '=', '3')
                            ->orderBy('vehicle_mains.updated_at', 'desc')
                            ->paginate($this->pagination);

            $all_items = $soldVehicles;
        }
        elseif ($slug == 'auction') {
            $section_title = 'Auction Vehicles';
            // Auction vehicles
            $auctionVehicles = VehicleMain::with('detail')
                                ->where('vehicle_mains.status', '=', '2')
                                ->orderBy('vehicle_mains.updated_at', 'desc')
                                ->paginate($this->pagination);

            $all_items = $auctionVehicles;
        }
        elseif ($slug == 'vehicle-type') {
            $section_title = 'Vehicle Types';
            // Vehicle Types
            $vehicleTypes = Filter::where('type', '=', 4) // vehicle_type
                            ->orderBy('view_order', 'desc')
                            ->paginate($this->pagination);

            $all_items = $vehicleTypes;
        }
        else{
            return abort(404);
		}
        return view('marketplace.view_all', compact('page', 'title', 'section_title', 'all_items'));
    }

    public function show($id)
    {
        $slug = 'marketplace-details';
        $page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

        $title = 'Marketplace Details';
        $vehicle = VehicleMain::with('detail')
                    ->where('vehicle_mains.id', '=', $id)
                    ->first();

        if(!Auth::guest()){
            $user_ip = \Request::ip();
            $loggedUserID = Auth::user()->id;
            $uniqueUser = ViewCount::where([['user_id', '=', $loggedUserID], ['vehicle_id', '=', $id]])->first();
            if($uniqueUser){
                $uniqueUser->view_count += 1;
                $uniqueUser->updated_at = Carbon::now();
                $uniqueUser->save();
            }else{
                $viewCount = new ViewCount;
                $viewCount->user_id = $loggedUserID;
                $viewCount->vehicle_id = $id;
                $viewCount->view_count = 1;
                $viewCount->user_ip = $user_ip;
                $viewCount->created_at = Carbon::now();
                $viewCount->save();
            }
        }else{
            $loggedUserID='';
            $user_ip = \Request::ip();
            $uniqueUser = ViewCount::where([['vehicle_id', '=', $id], ['user_ip', '=', $user_ip]])->whereNull('user_id')->first();
            if($uniqueUser){
                $uniqueUser->view_count += 1;
                $uniqueUser->updated_at = Carbon::now();
                $uniqueUser->save();
            }else{
                $viewCount = new ViewCount;
                $viewCount->vehicle_id = $id;
                $viewCount->view_count = 1;
                $viewCount->user_ip = $user_ip;
                $viewCount->created_at = Carbon::now();
                $viewCount->save();
            }
        }
        $lowestInt = Bank::where('status', 1)->orderBy('interest', 'asc')->first();
        return view('marketplace.details', compact('page', 'title', 'vehicle', 'loggedUserID', 'lowestInt'));
    }

    public function print($id)
    {
        $slug = 'marketplace-details';
        $page = get_page_by_slug($slug);

		if (!$page) {
			return abort(404);
		}

        $title = 'Marketplace Details';
        $vehicle = VehicleMain::with('detail')
                    ->where('vehicle_mains.id', '=', $id)
                    ->first();

        if(!Auth::guest()){
            $user_ip = \Request::ip();
            $loggedUserID = Auth::user()->id;
            $uniqueUser = ViewCount::where([['user_id', '=', $loggedUserID], ['vehicle_id', '=', $id]])->first();
            if($uniqueUser){
                $uniqueUser->view_count += 1;
                $uniqueUser->updated_at = Carbon::now();
                $uniqueUser->save();
            }else{
                $viewCount = new ViewCount;
                $viewCount->user_id = $loggedUserID;
                $viewCount->vehicle_id = $id;
                $viewCount->view_count = 1;
                $viewCount->user_ip = $user_ip;
                $viewCount->created_at = Carbon::now();
                $viewCount->save();
            }
        }else{
            $loggedUserID='';
            $user_ip = \Request::ip();
            $uniqueUser = ViewCount::where([['vehicle_id', '=', $id], ['user_ip', '=', $user_ip]])->whereNull('user_id')->first();
            if($uniqueUser){
                $uniqueUser->view_count += 1;
                $uniqueUser->updated_at = Carbon::now();
                $uniqueUser->save();
            }else{
                $viewCount = new ViewCount;
                $viewCount->vehicle_id = $id;
                $viewCount->view_count = 1;
                $viewCount->user_ip = $user_ip;
                $viewCount->created_at = Carbon::now();
                $viewCount->save();
            }
        }
        $lowestInt = Bank::where('status', 1)->orderBy('interest', 'asc')->first();
        return view('marketplace.print', compact('page', 'title', 'vehicle', 'loggedUserID', 'lowestInt'));
    }
}
