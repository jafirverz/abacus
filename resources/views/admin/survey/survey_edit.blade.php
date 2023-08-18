@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <div class="section-header-back">
        <a href="{{ route('survey-completed.getlist') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
      </div>
      <h1>{{ $title ?? '-' }}</h1>
      {{--@include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('survey_crud', 'Edit',
      route('survey.edit', $survey->id))]) --}}
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <form action="{{ route('survey-completed.update', $survey->id) }}" method="post"
              enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="previousUrll" value="{{ url()->previous() }}">
              <div class="card-body">

                @foreach($data as $key=>$value)
                          @if($key == '_token')
                          @else
                          @php 
                          $wordss = ["__", "_"];
                          $replacewith   = [". ", " "];
                          @endphp
                            <div class="form-group">
                              <label for="title">{{ ucwords(str_replace($wordss, $replacewith, $key)) }}</label>
                              <input type="text" disabled class="form-control" value="{{ $value }}">
                                
                            </div>
                            @endif
                          @endforeach

                <div class="form-group">
                  <label for="title">Allocate Certificate</label>
                  <select name="certificate" class="form-control">
                    <option value="">----Please Select----</option>
                    @foreach($certificate as $certi)
                    <option value="{{ $certi->id }}">{{ $certi->title }}</option>
                    @endforeach
                  </select>
                </div>





              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>



<script>

  $(document).ready(function () {

    $('body').on('change', '#worksheet', function () {
      alert(this.value);
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var worksheet_id = this.value;
      //alert(make);
      //alert(id);
      $.ajax({
        url: "<?php echo url('/'); ?>/admin/survey/find-worksheet",
        method: "POST",
        data: { _token: CSRF_TOKEN, worksheet_id: worksheet_id },
        success: function (data) {
          //$("#model_header_list").html(data);
          //$('.selectpicker').selectpicker('refresh');
        }
      });
    });





    $("body").on("click", ".remove", function () {
      $(this).parents(".form-group").remove();
    });

    $("body").on("click", ".remove2", function () {
      $(this).parents(".row").remove();
    });

  });
</script>

@endsection