@extends('admin.layouts.skeleton')
@section('title', 'Dashboard')
@section('nav')
        <li class="nav-item active">
            <a class="nav-link" href="/admin/home">
            <i class="fas fa-home"></i>
            <span>Home</span></a
            >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Information</div>

        <!-- Nav Item - consumption -->
        <li class="nav-item">
            <a class="nav-link collapsed"  href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices">
                <i class="fas fa-fw fa-cog"></i>
                <span>Consumption</span>
            </a>
            <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities2" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Consumption</h6>
                    <a class="collapse-item" href="/admin/consumption" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices paid">All</a>
                    <a class="collapse-item" href="/admin/consumption-that-are-paid" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices paid">Consumption Paid</a>
                    <a class="collapse-item" href="/admin/consumption-that-are-unpaid" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices unpaid">Consumption UnPaid</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Customer -->
        <li class="nav-item">
            <a class="nav-link collapsed"  href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities1">
                <i class="fas fa-address-book"></i>
                <span>Customer</span>
            </a>
            <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities1" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Customers</h6>
                    <a class="collapse-item" href="/admin/customer">Manage customers</a>
                    <a class="collapse-item" href="/admin/administrator">Manage Administrators</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Payment -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/admin/invoice/addInformation">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Invoices</span>
            </a>
        </li>

        <!-- Nav Item - Stock -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Stock</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Stock Information</h6>
                    <a class="collapse-item" href="/admin/products_types">Products type</a>
                    <a class="collapse-item" href="/admin/manage_products">Manage products</a>
                    <a class="collapse-item" href="/admin/stock/1">Stock</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Payment -->
        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="/admin/map">
            <i class="fas fa-map-marker-alt"></i>
            <span>Map</span>
            </a>
        </li> -->

        <!-- Nav Item - Payment -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/admin/clauses">
            <i class="fas fa-list"></i>
            <span>Confidentiality Clauses</span>
            </a>
        </li>

        <!-- Nav Item - profile -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/admin/profile">
            <i class="fas fa-user"></i>
            <span>Profile</span>
            </a>
        </li>

        <!-- Nav Item - Finances -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/admin/finances">
            <i class="fas fa-wallet"></i>
            <span>Finances</span>
            </a>
        </li>

        <!-- Nav Item - Log out -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log out</span>
            </a>
        </li>
@stop
@section('content')

<!-- Page Heading -->
<div
class="d-sm-flex align-items-center justify-content-between mb-4"
>
<h1 class="h3 mb-0 text-gray-800">Personal Information</h1>
</div>
<!-- Content Row -->
<div class="row">
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div
            class="
              text-xs
              font-weight-bold
              text-primary text-uppercase
              mb-1
            "
          >
            Earnings (Monthly)
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            {{$earnly}}Fcfa
          </div>
        </div>
        <div class="col-auto">
          <i class="fas fa-calendar fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<!--<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-success shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div
            class="
              text-xs
              font-weight-bold
              text-success text-uppercase
              mb-1
            "
          >
            Personal Orange Money
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            215 000
          </div>
        </div>
        <div class="col-auto">
          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>-->

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
  <div class="card border-left-info shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div
            class="
              text-xs
              font-weight-bold
              text-info text-uppercase
              mb-1
            "
          >
            People who have paid
          </div>
          <div class="row no-gutters align-items-center">
            <div class="col-auto">
              <div
                class="
                  h5
                  mb-0
                  mr-3
                  font-weight-bold
                  text-gray-800
                "
              >
                {{$pourcent}}%
              </div>
            </div>
            <div class="col">
              <div class="progress progress-sm mr-2">
                <div
                  class="progress-bar bg-info"
                  role="progressbar"
                  style="width: {{$earnly}}%"
                  aria-valuenow="50"
                  aria-valuemin="0"
                  aria-valuemax="100"
                ></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-auto">
          <i
            class="fas fa-clipboard-list fa-2x text-gray-300"
          ></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
  <div class="card border-left-warning shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div
            class="
              text-xs
              font-weight-bold
              text-warning text-uppercase
              mb-1
            "
          >
            Nb. product remaining
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            <?php
              if($materials){
                $left = 0;
                foreach($materials as $material){
                   $left += $material['quantity'];
                }
                echo $left;
              }else{
                echo '0';
              }
            ?>
          </div>
        </div>
        <div class="col-auto">
          <i class="fas fa-wrench fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Content Row -->

<div class="row">
<!-- Area Chart -->
<div class="col-xl-12 col-lg-12">
  <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div
      class="
        card-header
        py-3
        d-flex
        flex-row
        align-items-center
        justify-content-between
      "
    >
      <h6 class="m-0 font-weight-bold text-primary">
        Earnings Overview
      </h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
      <canvas id="lineChart"></canvas>
      <!--<div class="chart-area">
        <canvas id="myAreaChart"></canvas>
      </div>-->
    </div>
  </div>
</div>
</div>

<!-- Content Row -->
<div class="row">
<!-- Content Column -->
<div class="col-lg-12  mb-4">
  <!-- Project Card Example -->
  <div class="card shadow mb-4">
    <div class="card-header w-100 py-3 d-flex flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Invoices</h6>
      <a href="/admin/consumption-that-are-unpaid" class="text-red text-danger cursor-pointer">View more</a>
    </div>
    <div class="card-body container-fluid">
      <div class="table-responsive" *ngIf="classes.length>0">
        <table class="table table-hover">
          <thead class="thead thead-danger">
          <tr>
            <th>Name</th>
            <th style="text-align: center">Consumption</th>
            <th style="text-align: center">UnPaid</th>
            <th style="text-align: right"></th>
          </tr>
          </thead>

          <tbody>
            @foreach($invoices as $invoice)
              @if($loop ->index < 5)
                <tr>
                  <td>{{$client[$loop ->index]->name}}</td>
                  <td style="text-align: center">{{$invoice['montantConsommation']}}</td>
                  <td style="text-align: center">{{$invoice['montantImpaye']}}FCFA</td>
                  <td style="text-align: right">
                    <i
                      class="fas fa-lightbulb"
                      style="font-size: 30px; color: red"
                    ></i>
                  </td>
                </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</div>

<script>

//line
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
type: 'line',
data: {
labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
datasets: [
{
label: "Invoices",
data: [
    <?php

if(isset($earnly_invoices)){

  $dates = ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];

    //Datas
    $tbl_data = array(); //data table
    $k = 0; //counter
    foreach ($dates as $date) {

      $data= 0;

      foreach ($earnly_invoices as $material => $value){
        //dump($value -> dateFacturation);
        if(date('F', strtotime($date)) == date('F', strtotime($value -> createdAt))){
          $data += $value -> montantVerse;
        }
      }

      $tbl_data[$k] = $data;
      $k++;
      // echo '"'.$data.'"';
    }

    $c = 0; //counter
    foreach ($tbl_data as $data) {
      echo '"'.$data.'"';
      if($c<(count($tbl_data)-1)){
        echo ', ';
      }
      $c++;
    }

}

    ?>
],
backgroundColor: [
'rgba(0, 137, 132, .2)',
],
borderColor: [
'rgba(0, 10, 130, .7)',
],
borderWidth: 2
}
]
},
options: {
responsive: true
}
});


</script>

@stop
