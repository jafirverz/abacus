<?php
    $content = [];
    if($page->json_content){
        $content = json_decode($page->json_content, true);
    }

?>


<div class="form-group non-external">
<div class="section-title">About Section</div>
        <label for="section_1_content">Section 1</label>
        <textarea name="section_1" class="form-control my-editor" id="" cols="30"
            rows="10">{!! $content['section_1'] ?? '' !!}</textarea>
       @if ($errors->has('section_1'))
        <span class="text-danger d-block">
            <strong>{{ $errors->first('section_1') }}</strong>
        </span>
       @endif
</div>

<div class="form-group non-external">
        <label for="section_2">Section 2</label>
        <textarea name="section_2" class="form-control my-editor" id="" cols="30"
            rows="10">{!! $content['section_2'] ?? '' !!}</textarea>
       @if ($errors->has('section_2'))
        <span class="text-danger d-block">
            <strong>{{ $errors->first('section_2') }}</strong>
        </span>
       @endif
</div>

<div class="form-group non-external">
        <label for="section_3">Section 3</label>
        <textarea name="section_3" class="form-control my-editor" id="" cols="30"
            rows="10">{!! $content['section_3'] ?? '' !!}</textarea>
       @if ($errors->has('section_3'))
        <span class="text-danger d-block">
            <strong>{{ $errors->first('section_3') }}</strong>
        </span>
       @endif
</div>

<div class="form-group non-external">
    <label for="section_4">SEO Content Section 4</label>
    <textarea name="section_4" class="form-control my-editor" id="" cols="30"
        rows="10">{!! $content['section_4'] ?? '' !!}</textarea>
   @if ($errors->has('section_4'))
    <span class="text-danger d-block">
        <strong>{{ $errors->first('section_4') }}</strong>
    </span>
   @endif
</div>


<!-- End Marketplace Section -->
