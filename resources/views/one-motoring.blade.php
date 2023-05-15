@extends('layouts.app')

@section('content')            
            
            <div class="main-wrap">				
				@include('inc.banner')   
				<div class="container main-inner">
					<h1 class="title-1 text-center">{!! $page->title !!}</h1>
                    @include('inc.breadcrumb')
                    {!! $page->content !!}
                    <?php /*
                    @if($categories->count())
                    <?php  $i=0;?>
                    @foreach($categories as $key=> $item)
                    <?php  $i++;?>
					<div class="list-1 @if($i==1) mt-0 @endif">
						<h2 class="title">{!! $item->title !!}</h2>
                        
                        @if(get_one_motoring_by_category($item->id))
                        <?php  $j=0;?>
						<ol>
							@foreach(get_one_motoring_by_category($item->id) as $key=>$val)
                            <?php  $j++;?>
                            <li><a target="_blank" href="{!! $val->link !!}"><em class="number" style='font-size:20px;top: 4px;'>&#9679;</em> {!! $val->title !!}<span class="view">view link<span></a></li>
							@endforeach
                        </ol>
                        @endif
					</div>
                     @endforeach 
                    @else
				     <h2> Sorry! records not available</h2>
				    @endif
				    
				    */ ?>
				    
				    <div class="container" id="vehicle-matters-container">
				        <a name="vehicle-matters"></a>
                        <div class="row">
                            <div class="col p-3" style="border:0;"><h2>Road Tax Renewal, PARF Rebate Enquiry & Other VEHICLE MATTERS</h2></div>
                        </div>
                        <div class="row">
                            <div class="col pb-4">
                                <div class="row">
                                    <div class="col py-3 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=RoadTaxEnquiryDT" target="_blank">Renew Road Tax</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-3 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc2?ID=EnquireRoadTaxExpDtProxy" target="_blank">Enquire Road Tax Expiry Date</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-3 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=EnquireRoadTaxPayable" target="_blank">Enquire Road Tax Amount By Vehicle Number</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-3 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=EnquireRoadTaxByEngCap" target="_blank">Enquire Road Tax Amount By Engine Capacity</a></div>
                                </div>
                            </div>
                            <div class="col pb-4">
                                <div class="row">
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://onemotoring.lta.gov.sg/content/onemotoring/home/selling-deregistering/retain-replace-vrn.html" target="_blank">Retain/Replace a Vehicle Registration Number</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=SubmitEBid" target="_blank">Submit Bid for Vehicle Registration Number</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=BuyEDayLicenceDT" target="_blank">Purchase E-Day License</a></div>
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://onemotoring.lta.gov.sg/content/onemotoring/home/digitalservices/de-register-vehicle.html" target="_blank">Deregister Vehicle</a></div>
                                </div>
                            </div>
                            <div class="col pb-4">
                                <div class="row">
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=EnquireTransferFee" target="_blank">Enquire Vehicle Transfer Fee</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=EnquireRebateBeforeDeReg" target="_blank">Enquire PARF/COE Rebate</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://onemotoring.lta.gov.sg/content/onemotoring/home/digitalservices/transfer-of-ownership.html" target="_blank">Transfer Vehicle</a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container" id="coe-matters-container">
				        <a name="traffic-offence-coe-matters"></a>
                        <div class="row">
                            <div class="col py-3 px-0" style="border:0;"><h4>TRAFFIC OFFENCE/COE MATTERS</h4></div>
                        </div>
                        <div class="row">
                            <div class="col-8 pb-4">
                                <div class="row">
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=EnquireOffence" target="_blank">Enquire Fines & Notices</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://onemotoring.lta.gov.sg/content/onemotoring/home/digitalservices/pay_fines_and_fees.html" target="_blank">Pay LTA Fines & Fees</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-4 px-2 d-flex align-items-center justify-content-center"><a href="https://onemotoring.lta.gov.sg/content/onemotoring/home/digitalservices/Furnish_Driver's_Particulars_for_Offences.html" target="_blank">Furnish Driver's Particulars for Offences</a></div>
                                </div>
                            </div>
                            <div class="col pb-4">
                                <div class="row">
                                    <div class="col py-3 px-2 d-flex align-items-center justify-content-center"><a href="https://onemotoring.lta.gov.sg/content/onemotoring/home/buying/coe-open-bidding.html" target="_blank">Latest COE Results</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-3 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=EnquirePQPRates" target="_blank">Enquire PQP Rate to Renew COE</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-3 px-2 d-flex align-items-center justify-content-center"><a href="https://vrl.lta.gov.sg/lta/vrl/action/pubfunc?ID=RenewCOE" target="_blank">Renew COE</a></div>
                                </div>
                                <div class="row">
                                    <div class="col py-3 px-2 d-flex align-items-center justify-content-center"><a href="https://onemotoring.lta.gov.sg/content/onemotoring/home/owning/coe-renewal.html" target="_blank">Certificate of Entitlement (COE) Renewal</a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container" id="other-matters-container">
				        <a name="all-other-matters"></a>
                        <div class="row">
                            <div class="col py-3 px-0" style="border:0;"><h4>ALL OTHER MATTERS</h4></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col py-3 px-2 d-flex align-items-center justify-content-center"><a href="https://www.onemotoring.lta.gov.sg" target="_blank">www.onemotoring.lta.gov.sg</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
@endsection