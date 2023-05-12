<?php
    $content = [];
    if($page->json_content){
        $content = json_decode($page->json_content, true);
    }

?>


<div class="form-group non-external">
<div class="section-title">Loan</div>
        <label for="section_1_content">SEO Section 1</label>
        <textarea name="section_1" class="form-control my-editor" id="" cols="30"
            rows="10">{!! $content['section_1'] ?? '' !!}</textarea>
       @if ($errors->has('section_1'))
        <span class="text-danger d-block">
            <strong>{{ $errors->first('section_1') }}</strong>
        </span>
       @endif
</div>

<div class="form-group non-external">
            <label for="section_2_content">SEO Section 2</label>
            <textarea name="section_2" class="form-control my-editor" id="" cols="30"
                rows="10">{!! $content['section_2'] ?? '' !!}</textarea>
           @if ($errors->has('section_2'))
            <span class="text-danger d-block">
                <strong>{{ $errors->first('section_2') }}</strong>
            </span>
           @endif
    </div>

    <div class="form-group non-external">
      <label for="section_3_content">SEO Section 3</label>
      <textarea name="section_3" class="form-control my-editor" id="" cols="30"
          rows="10">{!! $content['section_3'] ?? '' !!}</textarea>
     @if ($errors->has('section_3'))
      <span class="text-danger d-block">
          <strong>{{ $errors->first('section_3') }}</strong>
      </span>
     @endif
</div>



<!-- End Marketplace Section -->
