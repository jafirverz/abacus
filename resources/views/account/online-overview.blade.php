@extends('layouts.app')
@section('content')
<main class="main-wrap">	
  <div class="row sp-col-0 tempt-2">
    <div class="col-lg-3 sp-col tempt-2-aside">
      <div class="menu-aside">
        @include('inc.account-sidebar-online')
      </div>
    </div>
    <div class="col-lg-9 sp-col tempt-2-inner">
      <div class="tempt-2-content">
        <h1 class="title-3">My Profile</h1>
        <div class="box-1">
          <div class="row align-items-center title-type">
            <div class="col-md">
              <h2 class="title-2">Personal Information</h2>
            </div>
            <div class="col-md-auto mt-767-10">
              <a class="link-1" href="#">Edit My Information</a>
            </div>
          </div>
          <div class="mt-20"><label>Account ID:</label> ID3GAB123456</div>
          <div class="row sp-col-xl-30">
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Full Name <span class="required">*</span></label>
              <input class="form-control" type="text" value="Michelle Tan" disabled />
            </div>
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Email <span class="required">*</span></label>
              <input class="form-control" type="text" value="michelletan@3gabacus.edu.sg" disabled />
            </div>
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Password <span class="required">*</span></label>
              <input class="form-control" type="password" placeholder="*****" disabled />
            </div>
          </div>
          <div class="row sp-col-xl-30">
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Date of Birth <span class="required">*</span></label>
              <div class="date-wrap disabled">
                <i class="fa-solid fa-calendar-days ico"></i>
                <input class="form-control" type="text" value="31/12/1994" disabled />
              </div>
            </div>
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Phone <span class="required">*</span></label>
              <div class="row sp-col-10">
                <div class="col-auto sp-col">
                  <select class="selectpicker" disabled>
                    <option>+ 65</option>
                    <option>+ 84</option>
                  </select>
                </div>
                <div class="col sp-col">
                  <input class="form-control" type="text" value="+65 1234 5678" disabled />
                </div>
              </div>
            </div>
            <div class="col-xl-4 sp-col">
              <label class="lb-1">Gender <span class="required">*</span></label>
              <select class="selectpicker" disabled>
                <option>Please Select</option>
                <option selected>Female</option>
                <option>Male</option>
              </select>
            </div>
          </div>
          <div class="row sp-col-xl-30">
            <div class="col-xl-8 sp-col">
              <label class="lb-1">Address</label>
              <input class="form-control" type="text" value="134 Jurong Gateway Road #04-307A Singapore 600134" disabled />
            </div>
          </div>
          <div class="output-2">
            <button class="btn-1" type="submit">Save <i class="fa-solid fa-arrow-right-long"></i></button>
          </div>
        </div>
        <div class="box-1">
          <div class="xscrollbar">
            <table class="tb-2 tbtype-4">
              <thead>
                <tr class="text-uppercase">
                  <th>Lesson Title</th>
                  <th>Completed/Incomplete</th>
                  <th>Completion Date</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><em>Lorem ipsum dolor sit amet</em></td>
                  <td><em class="status-2">Completed</em></td>
                  <td><em>31/02/2018</em></td>
                </tr>
                <tr>
                  <td><em>Lorem ipsum dolor sit amet</em></td>
                  <td><em class="status-3">Incomplete</em></td>
                  <td><em>31/02/2018</em></td>
                </tr>
                <tr>
                  <td><em>Lorem ipsum dolor sit amet</em></td>
                  <td><em class="status-2">Completed</em></td>
                  <td><em>31/02/2018</em></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>	
</main>

@endsection
