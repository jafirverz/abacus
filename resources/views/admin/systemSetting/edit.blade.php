@extends('admin.layout.dashboard') @section('content')
        <!-- Content Wrapper. Contains system-setting content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}
        </h1>{{ Breadcrumbs::render('system-setting-edit', $systemSetting->id) }}
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
                    <form method="post" action="{{ url('/admin/system-setting/update/'.$systemSetting->id)}}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title" class=" control-label">Title</label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{ $systemSetting->title }}" name="title" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="logo" class=" control-label">Logo</label>
                            <div class="@if(isset($systemSetting->logo)) row @endif">
                                <div class="@if(isset($systemSetting->logo) && ($systemSetting->logo != ''))col-sm-10 @endif">
                                    <input class="form-control" placeholder="" name="logo" type="file">
                                    <span class="text-muted">Note: Logo size should be 100*60 for better display.</span>
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
                            <label for="logo" class=" control-label">Email Template Logo</label>
                            <div class="@if(isset($systemSetting->email_template_logo)) row @endif">
                                <div class="@if(isset($systemSetting->email_template_logo) && ($systemSetting->email_template_logo != ''))col-sm-10 @endif">
                                    <input class="form-control" placeholder="" name="email_template_logo" type="file">
                                    <span class="text-muted">Note: Email Template Logo size should be 120*72 for better display.</span>
                                </div>
                                @if(isset($systemSetting->email_template_logo) && ($systemSetting->email_template_logo != ''))
                                    <div class=" col-sm-2">
                                        <div class="attachment-block clearfix">
                                            <img class="attachment-img" src="{!! asset($systemSetting->email_template_logo) !!}"
                                                 alt="Email Template Logo Image">
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="email_sender_name" class=" control-label">Email Sender Name</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $systemSetting->email_sender_name }}" name="email_sender_name" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="from_email" class=" control-label">From Email</label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{ $systemSetting->from_email }}" name="from_email" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="to_email" class=" control-label">To Email</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $systemSetting->to_email }}" name="to_email" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="membership_emailid" class=" control-label">Membership Emailid</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $systemSetting->membership_emailid }}" name="membership_emailid" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="general_emailid" class=" control-label">General Emailid</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $systemSetting->general_emailid }}" name="general_emailid" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="regulatory_emailid" class=" control-label">Regulatory Emailid</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $systemSetting->regulatory_emailid }}" name="regulatory_emailid" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_phone" class=" control-label">Contact No</label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{ $systemSetting->contact_phone }}" name="contact_phone" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_email" class=" control-label">Contact Email</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $systemSetting->contact_email }}" name="contact_email" type="text">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_email" class=" control-label">Feedback Email</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $systemSetting->feedback_emailid }}" name="feedback_emailid" type="text">

                            </div>
                        </div>

                        <!--<div class="form-group">
                            <label for="contact_address" class=" control-label">Company Addresses</label>
                            <div class="">
                                 <textarea class="form-control tiny-editor " name="contact_address">{{ $systemSetting->contact_address }}</textarea>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label for="pagination_limit" class=" control-label">Pagination Limit</label>
                            <div class="">
                                 <input class="form-control" placeholder="" value="{{ $systemSetting->pagination_limit }}" name="pagination_limit" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="linkedin_link" class=" control-label">Linkedin</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $systemSetting->linkedin_link }}" name="linkedin_link" type="text">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="twitter_link" class=" control-label">Twitter</label>
                            <div class="">
                                <input class="form-control" placeholder="" value="{{ $systemSetting->twitter_link }}" name="twitter_link" type="text">

                            </div>
                        </div>
                        <div class="form-group">
<label for="footer" class=" control-label">Footer</label>
						<div class="">
                                 <textarea class="form-control tiny-editor " name="footer">{{ $systemSetting->footer }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
<label for="footer" class=" control-label">Footer Copyright</label>
						<div class="">
                                 <textarea class="form-control tiny-editor " name="footer_copyright">{{ $systemSetting->footer_copyright }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
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
