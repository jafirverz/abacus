<div class="picture">
						
						<div class="photo">
							<img class="bgimg" src="@if(isset(Auth::user()->profile_picture)) {{asset(Auth::user()->profile_picture)}} @endif" alt="" id="preview">
						</div>
						
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="profile_picture" id="uploadphoto">
							<label class="custom-file-label" for="uploadphoto">Change Photo <i
									class="fas fa-upload"></i></label>
						</div>
						@if ($errors->has('profile_picture'))
						<span class="text-danger d-block">
							<strong>{{ $errors->first('profile_picture') }}</strong>
						</span>
						@endif
					</div>
                    
<script>
			$("#uploadphoto").on('change',function(){
				var input = $(this)[0];
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$('#preview').attr('src', e.target.result).fadeIn('slow');
					}
					reader.readAsDataURL(input.files[0]);
				}
			});
			$('.btn-edit').on('click', function() {
				var dis = $('.edit-profile').find('.form-control'),
					btnhide = $('.edit-profile').find('.edit-hide');
				$(dis).removeAttr("disabled");
				$(btnhide).show();
			})
			$('.btn-noedit').on('click', function() {
				var dis = $('.edit-profile').find('.form-control'),
					btnhide = $('.edit-profile').find('.edit-hide');
				$(dis).attr("disabled", "disabled");
				$(btnhide).hide();
			})
		</script>