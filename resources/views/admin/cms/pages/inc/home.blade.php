<?php
    $content = [];
    if($page->json_content){
        $content = json_decode($page->json_content, true);
    }
   
?>



<!-- Start Marketplace Section -->
<div class="form-group non-external">
<div class="section-title">Home Section</div>
    <div class="section-title">Marketplace Section</div>
    <label for="newest_car_section_heading">Title</label>
    <input type="text" name="marketplace_title" class="form-control" id=""
        value="{{ $content['marketplace_title'] ?? '' }}">
    @if ($errors->has('marketplace_title'))
    <span class="text-danger d-block">
        <strong>{{ $errors->first('marketplace_title') }}</strong>
    </span>
    @endif
</div>

<div class="form-group non-external">
    <label for="newest_car_section_link_label">Link</label>
    <input type="text" name="marketplace_link" class="form-control" id=""
        value="{{ $content['marketplace_link'] ?? '' }}">
    @if ($errors->has('marketplace_link'))
    <span class="text-danger d-block">
        <strong>{{ $errors->first('marketplace_link') }}</strong>
    </span>
    @endif
</div>

<div class="form-group non-external">
    <label for="marketplace_content">Content</label>
    <textarea name="marketplace_content" class="form-control h-50">{{ $content['marketplace_content'] ?? '' }}</textarea>
    @if ($errors->has('marketplace_content'))
    <span class="text-danger d-block">
        <strong>{{ $errors->first('marketplace_content') }}</strong>
    </span>
    @endif
</div>
<!-- End Marketplace Section -->
