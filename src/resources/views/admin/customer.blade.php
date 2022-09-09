@extends('admin.layouts.skeleton')
@section('title', 'Customer')
<style>
    .person-img {
        border-radius: 50%;
        border-style: solid;
        margin-bottom: 1rem;
        width: 50px;
        height: 50px;
        object-fit: cover;
        border: 4px solid var(--clr-grey-8);
        box-shadow: var(--dark-shadow);
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
        <li class="nav-item active">
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
    <div class="d-sm-flex align-items-right justify-content-between mb-4">
        <div>
            <a href="/admin/customer/addCustomer" class="btn btn-primary"> Add a customer </a>
            <a href="/admin/customer/blockedCustomer" class="btn ml-3 btn-warning"><i class="fas fa-exclamation-triangle mr-2"></i>Blocked</a>
        </div>
        <h1 class="h3 mb-0 text-gray-800"><b><?= isset($nbrCl)? $nbrCl.' ' : ''?></b>Customers</h1>
        <form action="/admin/search/customer" novalidate method="post" enctype="multipart/form-data" class="form-horizontal row-border">
            <div class="col-sm-12">
                <div class="row">
                    @csrf
                    <div class="col-9">
                        <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Name of user">
                    </div>
                    <div class="col-2">
                        <button class="btn-sm btn-success h-100" type="submit" name="search" id="search"><i class="fas fa-search"></i></button>
                    </div>
                </div>

            </div>
        </form>
    </div>




    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle"></i>
            {{ Session::get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <!-- Basic Card Example -->

        <?php
        if ($customers != null) {
            if($customers['status'] == 200){

                $informations = $customers['result'];

                foreach($informations as $key => $info) {
                    $location = $info['localisation'];
                    $description = $location['description'];

                    if($description != ""){
                        $description = $location['description'];
                    }else{
                        $description = "Not set";
                    }

                    $status = $info['status'];
                    $delete = $info['isDelete'];

                    if($status == 1){
                        $card='bg-success';
                        $class='btn-success';
                        $state = 'Active';
                        $badge = 'badge-success';
                    }

                    if(empty($status)){
                        $status = 0;
                    }

                    if($info['profileImage'] != "noPath"){
                        $image = url('storage/'.$info['profileImage']);
                    }else{
                        $image = "/img/undraw_profile.svg";
                    }

                    if(!$delete && $status==1){

                ?>


                <div class="col-md-6 col-lg-4">
                        <div class="card shadow mb-4" style="width:18rem;">
                            <div class="card-header py-3 <?= $card ?>">

                                <div class="row">

                                    <img class="person-img float-left" src='<?= $image ?>' width="50" height="50"/>

                                    <div class="ml-2" style="position:absolute;left:60;margin:auto;top:30;">
                                        <h6 class="font-weight-bold text-white" style="font-size:18px;"><?=$info['name']?></h6>
                                    </div>

                                </div>

                            </div>

                            <div class="card-body ">
                                <hr>

                                <div class="text-center">

                                    <table>
                                        <tr>
                                            <td>Number: </td>
                                            <td><?= $info['phone'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Address: </td>
                                            <td><?= $description ?></td>
                                        </tr>
                                        <tr>
                                            <td>Meter ID: </td>
                                            <td><?= $info['IdCompteur'] ?></td>
                                        </tr>
                                    </table>

                                </div>

                                <hr>
                            </div>

                            <div class="card-footer <?= $card?>" >

                                    <a href="/admin/customer/block/<?= $info['_id']?>/<?= $status ?>" class="btn <?= $class ?>">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        <span class="text" style="margin:auto;"><?= $state ?></span>
                                    </a>

                                    <div class="float-right">

                                        <a href="locationModal" id="toLocation" locate="<?= $info['_id'] ?>" desc="<?= $info['localisation']['description'] ? $info['localisation']['description'] : ""?>" data-toggle="modal" data-target="#locationModal" class="btn <?= $card ?> locationModal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="location">
                                            <span class="icon"  style="color:white;">
                                                <i class="fas fa-globe"></i></i>
                                            </span>
                                        </a>

                                        <a href="/admin/customer/edit/<?= $info['_id'] ?>" class="btn <?= $card ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                                            <span class="icon"  style="color:white;">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </a>

                                        <a href="/admin/customer/delete/<?= $info['_id'] ?>" class="btn <?= $card ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                                            <span class="icon"  style="color:white;">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </a>

                                    </div>
                            </div>
                        </div>
                    </div>
        <?php
                    }
                }
            }
        } else {

        }
     ?>

    </div>


    <!-- Location Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Location</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/admin/customer/location" class="user">
                        @csrf
                        <input type="hidden" id="id" name="id"  value="">
                        <input type="hidden" name="lat" id="lat"  value="">
                        <input type="hidden" name="lng" id="lng"  value="">

                        <div class="input-group mt-3">
                            <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class='fas fa-home'></i></span></div>
                            <input type="text" class="form-control" placeholder="description of the location" id="description" name="description" value="" required>
                        </div>

                        <div class="input-group mt-3">
                            <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">Lat</i></span></div>
                            <input type="number" class="form-control" name="latsee" id="latsee" value="" disabled>
                        </div>

                        <div class="input-group mt-3">
                            <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">Lng</i></span></div>
                            <input type="text" class="form-control" name="lngsee" id="lngsee" value="" disabled>
                        </div>

                        <hr>
                        <div class="row float-right mt-3">
                            <a href="#">
                                <button href="#" class="btn btn-primary btn-user" name="submit" type="submit">
                                    Proceed
                                </button>
                            </a>
                            <a href="#">
                                <button class="btn btn-secondary btn-user ml-2" type="button" data-dismiss="modal">Cancel</button>
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- <table id="table_id" class="display">
        <thead>
            <tr>
                <th>Date</th>
                <th>Ref_Client</th>
                <th>N° meter</th>
                <th>Client</th>
                <th>Tel</th>
                <th>Location</th>
                <th>Amount(CFA)</th>
                <th>Observation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= date('d/m/Y',strtotime('17/08/2020'))?></td>
                <td>Client 1</td>
                <td></td>
                <td>GOUAJEU DOMGNO Emeline</td>
                <td>697165159/ 697476526</td>
                <td>premiere cliente</td>
                <td>75 000</td>
                <td></td>
            </tr>
            <tr>
                <td><?= date('d/m/Y',strtotime('29/08/2020'))?></td>
                <td>Client 2</td>
                <td>2019-9-0049</td>
                <td>DEFRE MEGUIANNI Soddy</td>
                <td>690598662</td>
                <td>fermier afrique du sud</td>
                <td>100000</td>
                <td></td>
            </tr>
            <tr>
                <td><?= date('d/m/Y',strtotime('03/09/2020'))?></td>
                <td>Client 3</td>
                <td>20256156</td>
                <td>TAGNE</td>
                <td>697761267</td>
                <td>briquetterie plaque afique du sud</td>
                <td>75000</td>
                <td>Installation le 06/11/20</td>
            </tr>
        </tbody>
    </table> -->

    <script>

        $(document).ready( function () {
            $.noConflict();
            $('#table_id').DataTable();
        } );

    // $("body").on('click','#toLocation',function(event){

    //     event.preventDefault();

    //     var id = $(this).attr('locate');
    //     var desc = $(this).attr('desc');

    //    function myPosition(position) {

    //     $('#lat').val(position.coords.latitude);
    //     $('#latsee').val(position.coords.latitude);
    //     $('#lng').val(position.coords.longitude);
    //     $('#lngsee').val(position.coords.longitude);
    //     $('#id').val(id);
    //     $('#description').val(desc);
    //    }

    //    function errorPosition(error) {
    //       var info = "Error while getting your location : ";

    //       switch(error.code) {
    //           case error.TIMEOUT:
    //               info += "Timeout !";
    //           break;
    //           case error.PERMISSION_DENIED:
    //           info += "Permission denied";
    //           break;
    //           case error.POSITION_UNAVAILABLE:
    //               info += "Your location could not be determined";
    //           break;
    //           case error.UNKNOWN_ERROR:
    //               info += "Unknown Error";
    //           break;
    //       }
    //    }

    //   if(navigator.geolocation)
    //     navigator.geolocation.getCurrentPosition(myPosition,errorPosition,{enableHighAccuracy:true});
    // });

    </script>

@stop
