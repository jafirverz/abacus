@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('survey-completed.getlist') }}" class="btn btn-icon"><i
                        class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                          @foreach($data as $key=>$value)
                          @if($key == '_token')
                          @else
                          @php 
                          $wordss = ["__", "_"];
                          $replacewith   = [". ", " "];
                          @endphp
                            <div class="form-group">
                                <label for="">{{ ucwords(str_replace($wordss, $replacewith, $key)) }}</label>
                                : {{ $value }}

                            </div>
                            @endif
                          @endforeach
                            
                            



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
