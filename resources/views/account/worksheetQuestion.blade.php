@extends('layouts.app')
@section('content')

<main class="main-wrap">	
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      @if(Auth::user()->user_type_id == 1)
        @include('inc.account-sidebar')
      @endif
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <div class="mb-20">
          <a class="link-1 lico" href="be-overview-preparatory.html"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
        </div>
        <ul class="breadcrumb bctype">
          <li><a href="{{ url('home') }}">Overview</a></li>
          <li><a href="{{ url('') }}">Preparatory Level</a></li>
          <li><strong>{{ $worksheet->title }}</strong></li> 
        </ul>
        <div class="box-1">
          {{ $worksheet->description }}
        </div>
        <div class="shuffle-wrap">
          <div class="shuffle"><button type="button" class="btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="(Note: This feature is only available for premium member)"><i class="icon-info"></i></button> <strong><a href="#">Shuffle the Questions <i class="icon-shuffle"></i></a></strong></div>
        </div>
        <form action="post">
          <div class="box-1">
            <div class="xscrollbar">
              <table class="tb-2 tbtype-2">
                <thead>
                  <tr>
                    <th class="wcol-2"></th>
                    @php 
                    $questionns = json_decode($questions->json_question);
                    $count = count($questionns->input_1);
                    for($i=1;$i<=$count;$i++){
                    @endphp
                      <th colspan="2" class="text-center">{{ $i }}</th>
                    @php
                    }
                    @endphp
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @php 
                  for($i=1;$i<=$count;$i++){
                    @endphp
                  <tr>
                    <td></td>
                    <td class="typecol-1">$</td>
                    <td class="typecol-2">48,544.17</td>
                    <td></td>
                  </tr>
                  @php
                    }
                    @endphp
                </tbody>
                <tfoot>
                  <tr>
                    <td class="lb">Answer</td>
                    <td class="typecol-1">$</td>
                    <td class="typecol-2 colanswer">
                      <input class="form-control" type="number" />
                    </td>
                    <td class="typecol-1">$</td>
                    <td class="typecol-2 colanswer">
                      <input class="form-control" type="number" />
                    </td>
                    <td class="typecol-1">$</td>
                    <td class="typecol-2 colanswer">
                      <input class="form-control" type="number" />
                    </td>
                    <td class="typecol-1">$</td>
                    <td class="typecol-2 colanswer">
                      <input class="form-control" type="number" />
                    </td>
                    <td class="typecol-1">$</td>
                    <td class="typecol-2 colanswer">
                      <input class="form-control" type="number" />
                    </td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="output-1">
            <button class="btn-1" type="submit">Submit <i class="fa-solid fa-arrow-right-long"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>	
</main>
@endsection