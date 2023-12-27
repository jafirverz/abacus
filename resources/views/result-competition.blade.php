@extends('layouts.app')
@section('content')

<main class="main-wrap">
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
        @if(Auth::user()->user_type_id == 3)
        @include('inc.account-sidebar-online')
        @endif
        @if(Auth::user()->user_type_id == 1 || Auth::user()->user_type_id == 2)
        @include('inc.account-sidebar')
        @endif
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="{{ url('/') }}"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <h1 class="title-3">Result</h1>

        <div class="box-msg-2 mt-50">
          <h4>Thank you for your submission.</h4>
          @if($paperType == 'practice')
          <h2>Here is your marks {{ $userMarks }} out of {{ $totalMarks }}.</h2>
          @endif
        </div>

      </div>
    </div>
  </div>
</main>


@if($paperType == 'actual')
<script>


  (function (global) {

    if (typeof (global) === "undefined") {
      throw new Error("window is undefined");
    }

    var _hash = "!";
    var noBackPlease = function () {
      global.location.href += "#";

      // Making sure we have the fruit available for juice (^__^)
      global.setTimeout(function () {
        global.location.href += "!";
      }, 50);
    };

    global.onhashchange = function () {
      if (global.location.hash !== _hash) {
        global.location.hash = _hash;
      }
    };

    global.onload = function () {
      noBackPlease();

      // Disables backspace on page except on input fields and textarea..
      document.body.onkeydown = function (e) {
        var elm = e.target.nodeName.toLowerCase();
        if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
          e.preventDefault();
        }
        // Stopping the event bubbling up the DOM tree...
        e.stopPropagation();
      };
    }
  })(window);

</script>

@endif
@endsection