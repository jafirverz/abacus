@extends('layouts.app')



@section('content')

<div class="main-wrap">
				@include('inc.banner')

				<div class="main-inner container">
					<div class="row">
						@include('inc.profile_sidebar')
						<div class="col-lg-9">
                        @include('inc.messages')
							<form action="{{ route('my-profile.update') }}" method="post" enctype="multipart/form-data">
                             @csrf
								<label class="dblock mt-25">Profile Picture <em class="note">(Please note that your profile picture will be displayed on the event results leader board)</em></label>
								<div class="row picture align-items-center">
									<div class="col-auto">
										<div class="image"><img src="{{asset($users->profile_picture)}}" class="img-fluid" id="preview" alt="" /></div>
									</div>
									<div class="col">
										<div class="custom-file">
                                            <input name="profile_picture" type="file" class="custom-file-input" id="profile_picture">
											<label class="custom-file-label" for="inputGroupFile"></label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label class="dblock mt-25">First Name <span class="required">*</span></label>
										<input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $users->first_name) }}" />
                                        @if ($errors->has('first_name'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
									</div>
									<div class="col-md-6">
										<label class="dblock mt-25">Last Name <span class="required">*</span></label>
										<input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $users->last_name) }}" />
                                        @if ($errors->has('last_name'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
									</div>
								</div>
                                <label class="dblock mt-25">Email <span class="required">*</span> </label>
								<input type="text"  class="form-control" readonly="readonly" value="{{  old('email', $users->email) }}" />
								<div class="row">
									<div class="col-md-6">
										<label class="dblock mt-25">Gender  <span class="required">*</span></label>
										<select class="selectpicker" name="gender" id="gender">
                                        <option value="Male" @if(old('gender', $users->gender)=='Male') selected @endif>Male</option>

										<option value="Female" @if(old('gender', $users->gender)=='Female') selected @endif>Female</option>
									    </select>
                                         @if ($errors->has('gender'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                        @endif
									</div>
									<div class="col-md-6">
										<label class="dblock mt-25">Date of Birth <span class="required">*</span></label>
										<div class="date-wrap">
											<input type="text" name="dob" id="dob" class="form-control" value="{{ old('dob', $users->dob) }}" />
											<i class="far fa-calendar-alt"></i>
                                             @if ($errors->has('dob'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('dob') }}</strong>
                                        </span>
                                        @endif
										</div>
									</div>
								</div>
                                
								<label class="dblock mt-25">Country of Residence <span class="required">*</span></label>
								<select name="country_of_residence" id="country_of_residence" class="selectpicker">
									<option value="">Select</option>
							        @foreach(getCountryResidence() as $key=>$value)
                                    <option @if(old('country_of_residence',$users->country_of_residence)==$key) selected="selected" @endif value="{{$key}}">{{$value}}</option>
                                      @endforeach
								</select>
                                 @if ($errors->has('country_of_residence'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('country_of_residence') }}</strong>
                                        </span>
                                        @endif
 								
								<label class="dblock mt-25">Contact Number <span class="required">*</span></label>
								<input type="text" class="form-control" name="contact_number" id="contact_number" value="{{  old('contact_number', $users->contact_number) }}" />
                                 @if ($errors->has('contact_number'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('contact_number') }}</strong>
                                        </span>
                                        @endif
								<div class="mt-25 mb-30 text-center output">
									<button class="btn-1" type="submit">Save</button>
									<button class="btn-4" type="reset">Cancel</button>
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
