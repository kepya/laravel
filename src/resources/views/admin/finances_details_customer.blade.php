@extends('admin.layouts.skeleton')
@section('title', 'Customer Details')

<style>
.card-margin {
    margin-bottom: 1.875rem;
}

.card {
    border: 0;
    box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #ffffff;
    background-clip: border-box;
    border: 1px solid #e6e4e9;
    border-radius: 8px;
}

.card .card-header.no-border {
    border: 0;
}
.card .card-header {
    background: none;
    padding: 0 0.9375rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    min-height: 50px;
}
.card-header:first-child {
    border-radius: calc(8px - 1px) calc(8px - 1px) 0 0;
}

.widget-49 .widget-49-title-wrapper {
  display: flex;
  align-items: center;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #edf1fc;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-day {
  color: #4e73e5;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
  color: #4e73e5;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-secondary {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #fcfcfd;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-day {
  color: #dde1e9;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-month {
  color: #dde1e9;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-success {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #e8faf8;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-day {
  color: #17d1bd;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-month {
  color: #17d1bd;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-info {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #ebf7ff;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-day {
  color: #36afff;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-month {
  color: #36afff;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-warning {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: floralwhite;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-day {
  color: #FFC868;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-month {
  color: #FFC868;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-danger {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #feeeef;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-day {
  color: #F95062;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-month {
  color: #F95062;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-light {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #fefeff;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-day {
  color: #f7f9fa;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-month {
  color: #f7f9fa;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-dark {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #ebedee;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-day {
  color: #394856;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-month {
  color: #394856;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-base {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  background-color: #f0fafb;
  width: 4rem;
  height: 4rem;
  border-radius: 50%;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-day {
  color: #68CBD7;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-month {
  color: #68CBD7;
  line-height: 1;
  font-size: 1rem;
  text-transform: uppercase;
}

.widget-49 .widget-49-title-wrapper .widget-49-meeting-info {
  display: flex;
  flex-direction: column;
  margin-left: 1rem;
}

.widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-pro-title {
  color: #3c4142;
  font-size: 14px;
}

.widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-meeting-time {
  color: #B1BAC5;
  font-size: 13px;
}

.widget-49 .widget-49-meeting-points {
  font-weight: 400;
  font-size: 13px;
  margin-top: .5rem;
}

.widget-49 .widget-49-meeting-points .widget-49-meeting-item {
  display: list-item;
  color: #727686;
}

.widget-49 .widget-49-meeting-points .widget-49-meeting-item span {
  margin-left: .5rem;
}

.widget-49 .widget-49-meeting-action {
  text-align: right;
}

.widget-49 .widget-49-meeting-action a {
  text-transform: uppercase;
}
</style>

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
            <a class="nav-link collapsed" href="/admin/consumption">
            <i class="fas fa-fw fa-cog"></i>
            <span>consumption</span>
            </a>
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
            <a class="nav-link collapsed" href="/admin/facture">
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

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800"><a href="/admin/finances/details" class="mr-3"><i class="fas fa-chevron-circle-left"></i></a>Details </h1>

  <form action="/admin/finances/details/customer/<?= $userdata['_id']?>" novalidate method="post" enctype="multipart/form-data" class="form-horizontal row-border">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-9">
                    <input type="text" class="form-control form-control-user" id="year" name="year" value="<?php if(isset($year)) echo $year; else echo date('Y'); ?>" placeholder="Enter a year">
                </div>
                <div class="col-2">
                    <button class="btn-lg btn-info" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>

    </div>
</div>

<div class="d-sm-flex align-items-center justify-content-between mb-4">

  <h3 class="h3 mb-2 text-gray-800">Bills<i class="fas fa-file-invoice-dollar" style="margin-left:5px;"></i></h3>

</div>


<div class="row">

  <?php 

      if(isset($facturesYear)){

          $i = 1;
          foreach($facturesYear as $fact) { ?>

            <div class="col-md-6 col-lg-4">
              <div class="card card-margin">
                  <div class="card-header no-border">
                      <h5 class="card-title">N°<?= $i ?></h5>
                  </div>
                  <div class="card-body pt-0">
                      <div class="widget-49">
                          <div class="widget-49-title-wrapper">
                              <div class="widget-49-date-primary">
                                  <span class="widget-49-date-day"><?= date('d', strtotime($fact['dateReleveNewIndex']))?></span>
                                  <span class="widget-49-date-month"><?= substr(date('F', strtotime($fact['dateReleveNewIndex'])), 0,3 ) ?></span>
                              </div>
                              <div class="widget-49-meeting-info">
                                  <span class="widget-49-pro-title"><?= $userdata['name']?></span>
                                  <span class="widget-49-meeting-time"><?= $userdata['localisation']['description']?></span>
                              </div>
                          </div>
                          <ul class="widget-49-meeting-points">
                              <li class="widget-49-meeting-item"><span>Old Index : <?= $fact['oldIndex']?></span></li>
                              <li class="widget-49-meeting-item"><span>New Index : <?= $fact['newIndex']?></span></li>
                              <li class="widget-49-meeting-item"><span>Consommation : <?= $fact['consommation']?> </span></li>
                              <li class="widget-49-meeting-item"><span>Amount : <?= $fact['montantConsommation']?> </span></li>
                              <li class="widget-49-meeting-item"><span>Left : <?= $fact['montantImpaye']?> </span></li>
                          </ul>
                          <div class="widget-49-meeting-action text-center">
                              <?php
                                  if($fact['facturePay'] == 1){
                                    $class = 'btn-success';
                                    $state = 'Paid';
                                  }else{
                                    $class = 'btn-danger';
                                    $state = 'Unpaid';
                                  }
                              ?>
                              <button class="btn btn-sm btn-space <?=$class?> rounded-pill"><?=$state?></button>
                          </div>
                      </div>
                  </div>
              </div>
            </div>    
 <?php   
        $i++;
        } 
      }else {
        $i = 1;
        foreach($factures as $fact){
  ?>
  <div class="col-md-6 col-lg-4">
        <div class="card card-margin">
            <div class="card-header no-border">
                <h5 class="card-title">N°<?= $i ?></h5>
            </div>
            <div class="card-body pt-0">
                <div class="widget-49">
                    <div class="widget-49-title-wrapper">
                        <div class="widget-49-date-primary">
                            <span class="widget-49-date-day"><?= date('d', strtotime($fact['dateReleveNewIndex']))?></span>
                            <span class="widget-49-date-month"><?= substr(date('F', strtotime($fact['dateReleveNewIndex'])), 0,3 ) ?></span>
                        </div>
                        <div class="widget-49-meeting-info">
                            <span class="widget-49-pro-title"><?= $userdata['name']?></span>
                            <span class="widget-49-meeting-time"><?= $userdata['localisation']['description']?></span>
                        </div>
                    </div>
                    <ul class="widget-49-meeting-points">
                        <li class="widget-49-meeting-item"><span>Old Index : <?= $fact['oldIndex']?></span></li>
                        <li class="widget-49-meeting-item"><span>New Index : <?= $fact['newIndex']?></span></li>
                        <li class="widget-49-meeting-item"><span>Consommation : <?= $fact['consommation']?> </span></li>
                        <li class="widget-49-meeting-item"><span>Amount : <?= $fact['montantConsommation']?> </span></li>
                        <li class="widget-49-meeting-item"><span>Left : <?= $fact['montantImpaye']?> </span></li>
                    </ul>
                    <div class="widget-49-meeting-action text-center">
                        <?php
                            if($fact['facturePay'] == 1){
                              $class = 'btn-success';
                              $state = 'Paid';
                            }else{
                              $class = 'btn-danger';
                              $state = 'Unpaid';
                            }
                        ?>
                        <button class="btn btn-sm btn-space <?=$class?> rounded-pill"><?=$state?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <?php 
    $i++;
    } 
  }
?>
</div>

<!-- Content Row -->

<div class="row">

    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class=" card-header py-3 d-flex flex-row align-items-center justify-content-between ">
          <h6 class="m-0 font-weight-bold text-primary">
            Evolution of Consumption
          </h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <canvas id="barChart"></canvas>
        </div>
      </div>
    </div>

</div>




<script>

    //bar
var ctxB = document.getElementById("barChart").getContext('2d');
var myBarChart = new Chart(ctxB, {
type: 'bar',
data: {
labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
datasets: [{
 label: 'Water Consumption (meter cube)',
data: [
  <?php
      $dates = ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];
      $i = 0;
      $tbl_data = array();

      if(isset($facturesYear)){

        foreach ($dates as $date){

            $data = 0;

            foreach($facturesYear as $fact){

                if(date('F', strtotime($date)) == date('F', strtotime($fact['dateReleveNewIndex']))){
                  $data += $fact['consommation'];
                }
            }

            $tbl_data[$i] = $data;
            $i++;
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

          if($factures){

              foreach ($dates as $date){

                  $data = 0;

                  foreach($factures as $fact){

                      if(date('F', strtotime($date)) == date('F', strtotime($fact['dateReleveNewIndex']))){
                        $data += $fact['consommation'];
                      }
                  }

                  $tbl_data[$i] = $data;
                  $i++;
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
'rgba(255, 99, 132, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(255, 206, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(255, 159, 64, 0.2)',
'rgba(255, 206, 86, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(255, 99, 132, 0.2)',
'rgba(255, 159, 64, 0.2)'
],
borderColor: [
'rgba(255,99,132,1)',
'rgba(54, 162, 235, 1)',
'rgba(255, 206, 86, 1)',
'rgba(75, 192, 192, 1)',
'rgba(153, 102, 255, 1)',
'rgba(255, 159, 64, 1)',
'rgba(255, 206, 86, 1)',
'rgba(153, 102, 255, 1)',
'rgba(54, 162, 235, 1)',
'rgba(75, 192, 192, 1)',
'rgba(255,99,132,1)',
'rgba(255, 159, 64, 1)'
],
borderWidth: 1
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
});

</script>
   
@stop
