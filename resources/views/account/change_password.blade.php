@extends('layouts.app')

@section('content')
<div class="main-wrap">
				@include('inc.banner')      
				
				<div class="main-inner container">
					<div class="row">
						@include('inc.profile_sidebar')
						<div class="col-lg-9">
                @include('inc.messages')
                <form action="{{ route('change-password.update') }}" method="post">
                    @csrf
                                    <label class="dblock mt-25">Current Password <span class="required">*</span></label>
                                    <input id="password-field" name="current_password" type="password" class="form-control" placeholder="Enter Password" />
                                    
                                    @if ($errors->has('current_password'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                    @endif
                                    <label class="dblock mt-25">NEW PASSWORD <span class="required">*</span></label>
                                    <input id="password-field-2" name="password" type="password" class="form-control shownote" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 and special characters" />
                                    
                                    @if ($errors->has('password'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                    
                                    <label class="dblock mt-25">CONFIRM PASSWORD <span class="required">*</span></label>
                                    <input id="password-field-3" name="password_confirmation" type="password" class="form-control" placeholder="Enter Password" />
                                    
                               
                                    @if ($errors->has('password_confirmation'))
                                    <span class="text-danger d-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                    <div class="mt-25 mb-30 text-center output">
									<button class="btn-1" type="submit">Save</button>
								    </div>
                        
                </form>
						</div>
					</div>
				</div>
				
			
</div>

<form id="delete-form" action="{{ route('my-profile.account.delete') }}" method="POST" style="display: none;">

    @csrf

</form>

<script>

$(document).ready(function() {

    $("body").on("click", "a.delete_account", function() {

        var r = confirm("Are you sure you want to delete account?");

        if(r==true)

        {

            $("form#delete-form").submit();

        }

    });

});
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#preview').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#profile_picture").change(function() {
  readURL(this);
});
</script>
@endsection
