@extends('admin.layouts.skeleton')
@section('title', 'Finances Details')

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
   
   <!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800"><a href="/admin/finances" class="mr-3"><i class="fas fa-chevron-circle-left"></i></a>Finances Details </h1>
</div>

<div class="row">

  <div class="col-xl-12 col-lg-12">

    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class=" card-header py-3 d-flex flex-row align-items-center justify-content-between ">
        <h4 class="m-0 font-weight-bold text-primary">
          Customers Overview
        </h4>
      </div>
      <!-- Card Body -->
      <div class="card-body">
      
        <div class="single-table mt-4">
            <div class="table-responsive">
                <table class="table table-hover progress-table text-center">
                    <thead class="text-uppercase">
                        <tr class="table-primary">
                            <th scope="col">name</th>
                            <th scope="col">location</th>
                            <th scope="col">phone</th>
                            <th scope="col">Registered at</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                                if($customers){
                                      foreach($customers as $cust) {

                            ?>
                            <tr>
                                <td><?= $cust['name']?></td>
                                <td><?= $cust['localisation']['description']?></td>
                                <td><?= $cust['phone']?></td>
                                <td><?= date('Y-m-d H:i:s', strtotime($cust['createdAt']))?> </td>
                                <td>
                                    <a href="/admin/finances/details/customer/<?=$cust['_id']?>" class="btn btn-outline-info" data-target="_self" data-bs-toggle="tooltip" data-bs-placement="bottom" title="See Details"><i class="fas fa-chart-area"></i></a>
                                </td>
                            </tr>
                            
                                <?php 
                                        } 
                                    }
                                ?>
                    </tbody>
                </table>
            </div>
        </div>

      </div>
    </div>

  </div>

</div>

<!-- Content Row -->

<div class="row">

  <div class="col-xs-12 col-lg-7">

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">All materials bought</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Products</th>
                            <th>Quantity</th>
                            <th>Unit price</th>
                            <th>Total price</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <?php
                                $total = 0;
                                if($materials){
                                    foreach($materials as $mat){
                                        $total += $mat['input'][0]['quantity']*$mat['input'][0]['prixUnit'] ;
                                    }
                                }
                            ?>
                            <th class="text-center" colspan= "4">Total : <?= $total ?></th>
                        </tr>
                    </tfoot>
                    <tbody>
                            <?php
                                if($materials){
                                    foreach($materials as $mat){
                            ?>
                        <tr>
                            <td><?= $mat['name']?></td>
                            <td><?= $mat['input'][0]['quantity']?></td>
                            <td><?= $mat['input'][0]['prixUnit']?></td>
                            <td><?= $mat['input'][0]['quantity']*$mat['input'][0]['prixUnit']?></td>
                        </tr>

                            <?php   } 
                                }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  </div>

  <div class="col-xs-12 col-lg-5">

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Overview stock</h4>
        </div>
        <div class="card-body">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

  </div>

</div>

<script>
//pie
var ctxP = document.getElementById("pieChart").getContext('2d');
var myPieChart = new Chart(ctxP, {
type: 'pie',
data: {
labels: [
    <?php
        $inputQuantity = 0;
        $leftQuantity = 0;
        if($materials){

           foreach($materials as $mat){
             $inputQuantity += $mat['input'][0]['quantity'];
             $leftQuantity += $mat['quantity'];
           }

           $left = number_format(($leftQuantity / $inputQuantity)*100, 2) ;
           $used = 100 - $left;
           echo '"'.$used.' %Used",';
           echo '"'.$left.' %Left"';
        }
        
    ?>
],
datasets: [{
data: [
    <?php
        $inputQuantity = 0;
        $leftQuantity = 0;
        if($materials){

           foreach($materials as $mat){
            $inputQuantity += $mat['input'][0]['quantity'];
            $leftQuantity += $mat['quantity'];
           } 

           $left = number_format(($leftQuantity / $inputQuantity)*100, 2) ;
           $used = 100 - $left;
           echo '"'.$used.'",';
           echo '"'.$left.'"';
        }
    ?>
],
backgroundColor: ["#46BFBD", "#FDB45C"],
hoverBackgroundColor: ["#5AD3D1", "#FFC870"]
}]
},
options: {
responsive: true
}
});

</script>
@stop
