@extends('admin.layouts.skeleton')
@section('title', 'Finances')
@section('nav')
        <li class="nav-item">
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

        <!-- Nav Item - Notification -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/admin/chat">
            <i class="fas fa-file-archive"></i>
            <span>Notification</span>
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

        <!-- Nav Item - Clauses -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/admin/map">
            <i class="fas fa-map-marker-alt"></i>
            <span>Map</span>
            </a>
        </li>

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
        <li class="nav-item active">
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

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Finances </h1>
<a href="/admin/finances/details" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm "><i class="fas fa-caret-right"></i> Details</a>

</div>
<!-- Content Row -->
<div class="row">
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="  text-xs  font-weight-bold  text-primary text-uppercase  mb-1 ">
           Total Income 
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            <?php
              if($factures){
                $totalIncome=0;
                foreach ($factures as $fact){
                    if($fact['facturePay'] == 1){
                      $totalIncome += $fact['montantConsommation'];
                    }
                }
                echo $totalIncome;
              }else{
                echo '0';
              }
            ?>
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
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-success shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class=" text-xs font-weight-bold text-success text-uppercase mb-1 ">
            <?php echo date('F-Y').' ';?>Income 
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            <?php
              if($yearBills){
                $monthlyIncome=0;
                foreach ($yearBills as $fact){
                    if($fact['facturePay'] == 1) {
                      if(date('m-Y', strtotime($fact['createdAt'])) == date('m-Y')){
                        $monthlyIncome += $fact['montantConsommation'];
                      }
                    }
                }
                echo $monthlyIncome;
              }else{
                echo '0';
              }
            ?>
          </div>
        </div>
        <div class="col-auto">
          <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-info shadow h-100 py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class=" text-xs font-weight-bold text-info text-uppercase mb-1 ">
              <?php echo date('F-Y').' ';?>Expense 
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
                if($materialsYear){
                    $monthlyExpense = 0;
                    foreach($materialsYear as $material){
                      if(date('m-Y', strtotime($material['date'])) == date('m-Y')){
                        $monthlyExpense += ($material['quantity'] * $material['prixUnit']);
                      }
                    }
                    echo $monthlyExpense;
                }else{
                  echo '0';
                }
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-warning shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class=" text-xs font-weight-bold text-warning text-uppercase mb-1 ">
            Total Expense
          </div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            <?php
              if($materials){
                $totalExpense = 0;
                foreach($materials as $material){
                    $totalExpense += ($material['input'][0]['quantity'] * $material['input'][0]['prixUnit']);
                }
                echo $totalExpense;
              }else{
                echo '0';
              }  
            ?>
          </div>
        </div>
        <div class="col-auto">
          <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
    <div class=" card-header py-3 d-flex flex-row align-items-center justify-content-between ">
      <h6 class="m-0 font-weight-bold text-primary">
        Overview
      </h6>

      <form action="/admin/finances" novalidate method="post" enctype="multipart/form-data" class="form-horizontal row-border">
        <div class="col-sm-12">
            <div class="row">
                @csrf
                <div class="col-9">
                    <input type="text" class="form-control form-control-user" id="year" name="year" value="<?php if(isset($year)) echo $year; else echo date('Y'); ?>">
                </div>
                <div class="col-2">
                    <button class="btn-sm btn-success" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>

        </div>
    </form>

    </div>
    <!-- Card Body -->
    <div class="card-body">
      <!-- <div class="chart-area"> -->
        <canvas id="lineChart"></canvas>
      <!-- </div> -->
    </div>
  </div>
</div>
</div>

<!--  -->


<script>

//line
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
type: 'line',
data: {
labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
datasets: [{
label: "Income",
data: [
  <?php
      if(isset($reqYearBills)){

          $dates = ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];

          //Datas
          $tbl_data = array(); //data table
          $k = 0; //counter
          foreach ($dates as $date) {

            $data= 0;

            foreach ($reqYearBills as $bill){

                if(date('F', strtotime($date)) == date('F', strtotime($bill['createdAt']))){

                    if($bill['facturePay'] == 1){
                      $data += $bill['montantConsommation'];
                    }
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

      }else{

        if($yearBills){

          $dates = ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];

          //Datas
          $tbl_data = array(); //data table
          $k = 0; //counter
          foreach ($dates as $date) {

            $data= 0;

            foreach ($yearBills as $bill){

                if(date('F', strtotime($date)) == date('F', strtotime($bill['createdAt']))){
                  
                    if($bill['facturePay'] == 1){
                      $data += $bill['montantConsommation'];
                    }
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

      }
    
  ?>
],
backgroundColor: [
'rgba(105, 0, 132, .2)',
],
borderColor: [
'rgba(200, 99, 132, .7)',
],
borderWidth: 2
},
{
label: "Expense",
data: [
    <?php

        if(isset($reqYearMaterials)){

          $dates = ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];

            //Datas
            $tbl_data = array(); //data table
            $k = 0; //counter
            foreach ($dates as $date) {

              $data= 0;

              foreach ($reqYearMaterials as $material){

                  if(date('F', strtotime($date)) == date('F', strtotime($material['date']))){
                      $data += $material['quantity'] * $material['prixUnit'];
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

        }else{

            if($materialsYear){

            $dates = ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];

            //Datas
            $tbl_data = array(); //data table
            $k = 0; //counter
            foreach ($dates as $date) {

              $data= 0;

              foreach ($materialsYear as $material){

                  if(date('F', strtotime($date)) == date('F', strtotime($material['date']))){
                      $data += $material['quantity'] * $material['prixUnit'];
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
