@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains system-setting content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1> {{ Breadcrumbs::render('system-setting-create') }}
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.inc.message')
                        <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
                    <form method="post" action="{{ url('/admin/system-setting/store')}}" enctype="multipart/form-data"> 
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> 
                    
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title" class=" control-label">Title</label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{ old('title') }}" name="title" type="text"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="logo" class=" control-label">Logo</label>
                            <div class="row">
                                <div class="@if(isset($systemSetting->logo) && ($systemSetting->logo != ''))col-sm-10 @endif">
                                    <input class="form-control" placeholder="" name="logo" type="file"> 
                                </div>
                                @if(isset($systemSetting->logo) && ($systemSetting->logo != ''))
                                    <div class=" col-sm-2">
                                        <div class="attachment-block clearfix">
                                            <img class="attachment-img" src="{!! asset($systemSetting->logo) !!}"
                                                 alt="Logo Image">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">                            
                            <label for="email_sender_name" class=" control-label">Email Sender Name</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ old('email_sender_name') }}" name="email_sender_name" type="text"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="from_email" class=" control-label">From Email</label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{  old('from_email') }}" name="from_email" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="to_email" class=" control-label">To Email</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{  old('to_email') }}" name="to_email" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_phone" class=" control-label">Contact No</label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{ old('contact_phone') }}" name="contact_phone" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_email" class=" control-label">Contact Email</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{  old('contact_email') }}" name="contact_email" type="text">

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact_address" class=" control-label">Company Addresses</label>
                            <div class="">
                                 <textarea  class="form-control tiny-editor " name="contact_address">{{  old('contact_address') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
<label for="footer" class=" control-label">Footer</label>
						<div class="">
                                 <textarea  class="form-control tiny-editor " name="footer">{{  old('footer') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>

                </div>
                <!-- /.box-body -->


                </form>
            </div>
            <!-- /.box -->
        </div>
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@push('scripts')
@endpush
