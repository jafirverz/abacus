@extends('layouts.app')

@section('content')
<div class="main-wrap">
    @include('inc.banner')
    <div class="container main-inner">
        <h1 class="title-1 text-center">{{ $page->title ?? '' }}</h1>
        @include('inc.breadcrumb')
        {!! $page->content ?? '' !!}
    </div>
</div>
<div class="modal fade" id="messagepp" tabindex="-1" aria-labelledby="messagepp" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p>Oops, we noticed you are not logged in.</p>
                <p>Please login to view the S&P Agreement Form.</p>
                <div class="mt-20">
                    <a href="{{ url('login') }}" class="btn-1" style="margin-right:10px; padding-right: 30px;">Login</a>
                    <a href="{{ url('register') }}" class="btn-1"
                        style="margin-left:10px; padding-right: 30px;">Signup</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });

                var auth_check = '{{ Auth::check() }}';
                if(auth_check==false)
                {
                    $("#sp_form").attr("href",'javascript:void(0)');
                }else{
                    $("#sp_form").attr("href",'{{ url("forms/form-details") }}');
                }
                $("#sp_form").on("click", function() {
                    if(auth_check==false)
                    {
                    $("#messagepp").modal("show");
                    }
                   
                });

                });
</script>
@endsection