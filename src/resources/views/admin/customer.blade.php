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

    <h3 class="mt-3">Sort</h3>

    <div class="form-group">
        <form action="/admin/customer/sort" class="ml-4" method="post">
            <div class="form-row">
                @csrf
                <div class="form-group col-md-1">
                    <input type="number" class="form-control" id="customerID" name="customerID" value="" placeholder="ID">
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" id="meter" name="meter" value="" placeholder="UIX2000">
                </div>
                <div class="form-group col-md-2">
                    <input type="date" class="form-control" id="subs_date" name="subs_date" value="" placeholder="Date">
                </div>
                <div class="form-group col-md-1">
                    <select id="order"  name="order" class="form-control" aria-label="multiple select">
                        <option selected value="asc">asc</option>
                        <option value="desc">desc</option>
                    </select>
                </div>
                <div class="form-group ml-2">
                    <input class="btn btn-primary" type="submit" id="sort" name="sort" value="Sort">
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <!-- Basic Card Example -->
        <?php
            if(isset($response["result"])){

                $data = $response['result'];  //table informations returned

                $customers = $data['docs']; //table of customers

                $totalDocs = $data['totalDocs']; //number of customers in the database
                $limit = $data['limit']; // limit of materials on a page
                $totalPages = $data['totalPages']; //number of pages
                $page = $data['page']; //current page
                $pagingCounter = $data['pagingCounter']; //paging counter
                $hasPrevPage = $data['hasPrevPage']; //boolean if previous page exists
                $hasNextPage = $data['hasNextPage']; //boolean if next page exists
                $prevPage = $data['prevPage']; //index of the previous page
                $nextPage = $data['nextPage']; //index of the next page

                if(empty($page)){
                    $page = 0;
                }

                if(empty($hasPrevPage)){
                    $hasPrevPage = 0;
                }

                if(empty($hasNextPage)){
                    $hasNextPage = 0;
                }

                if(empty($prevPage)){
                    $prevPage = 0;
                }

                if(empty($nextPage)){
                    $nextPage = 0;
                }

                if($totalDocs != 0) { //if there are customers in the database

                    foreach($customers as $customer){

                        //Verify if the person has many meters
                        $status = $customer['status'];
                        $delete = $customer['isDelete'];
                        $description = $customer['localisation']['description'];

                        if($status == 1){
                            $card='bg-success';
                            $class='btn-success';
                            $state = 'Active';
                            $badge = 'badge-success';
                        }

                        if(empty($status)){
                            $status = 0;
                        }

                        if($customer['profileImage'] != "noPath"){
                            $image = url('storage/'.$customer['profileImage']);
                        }else{
                            $image = "/img/undraw_profile.svg";
                        }

                        $phones=""; //phone numbers as a string
                        $meters=""; //meter numbers as a string
                        $desc=""; //description as a string

                        if(!empty($customer['phone'])){
                            $i=0;
                            foreach($customer['phone'] as $phone){
                                $i++;
                                if($i == count($customer['phone'])){
                                    $phones = $phones.$phone;
                                }else{
                                    $phones = $phones.$phone." / ";
                                }
                            }
                        }

                        if(!empty($customer['idCompteur'])){
                            $i=0;
                            foreach($customer['idCompteur'] as $meter){
                                $i++;
                                if($i == count($customer['idCompteur'])){
                                    $meters = $meters.$meter;
                                }else{
                                    $meters = $meters.$meter." / ";
                                }
                            }
                        }

                        if(!empty($description)){
                            $i=0;
                            foreach($description as $description){
                                $i++;
                                if($i == count($customer['localisation']['description'])){
                                    $desc = $desc.$description;
                                }else{
                                    $desc = $desc.$description." / ";
                                }
                            }
                        }

                        if(!$delete && $status==1){ //Customer not blocked and not deleted
                        ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow mb-4" style="width:18rem;">
                                    <div class="card-header py-3 <?= $card ?>">

                                        <div class="row">

                                            <img class="person-img float-left" src='<?= $image ?>' width="50" height="50"/>

                                            <div class="ml-2" style="position:absolute;left:60;margin:auto;top:30;">
                                                <h6 class="font-weight-bold text-white" style="font-size:18px;"><?=$customer['name']?></h6>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="card-body ">
                                        <hr>
                                        <div class="text-center">
                                            <table>
                                                <tr>
                                                    <td>CLIENT : <?= $customer['customerReference']?></td>
                                                </tr>
                                                <tr>
                                                    <td>TEL : <?= $phones?> </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="card-footer <?= $card?>" >

                                            <a href="/admin/customer/block/<?= $customer['_id']?>/<?= $status ?>" class="btn <?= $class ?>">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </span>
                                                <span class="text" style="margin:auto;"><?= $state ?></span>
                                            </a>

                                            <div class="float-right">

                                                <a href="#" customerID="<?= $customer['_id'] ?>"  meters="<?=$meters?>" subs_amount="<?=$customer['subscriptionAmount']?>" subs_date="<?=$customer['subscriptionDate']?>" obs="<?=$customer['observation']?>" desc="<?=$desc?>" data-toggle="modal" data-target="#infoModal" class="btn <?= $card ?> infoModal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="info">
                                                    <span class="icon"  style="color:white;">
                                                        <i class="fas fa-eye"></i></i>
                                                    </span>
                                                </a>

                                                <a href="/admin/customer/edit/<?= $customer['_id'] ?>" class="btn <?= $card ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                                                    <span class="icon"  style="color:white;">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                </a>

                                                <a href="/admin/customer/delete/<?= $customer['_id'] ?>" class="btn <?= $card ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
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

                    }?>

    </div>

            <div class="row">
                <div class="container">

                    <div class="float-right">

                        <?php
                            //previous page
                            if($hasPrevPage == 0){
                                $prevDisabled = 'disabled';
                                $prevAriadisabled = 'true';
                                $prevHref = '#';
                            }else{
                                $prevDisabled = '';
                                $prevAriadisabled = '';
                                $prevHref = '/admin/customer/search/'.$prevPage;
                            }

                            //next page
                            if($hasNextPage == 0){
                                $nextDisabled = 'disabled';
                                $nextAriadisabled = 'true';
                                $nextHref = '#';
                            }else{
                                $nextDisabled = '';
                                $nextAriadisabled = '';
                                $nextHref = '/admin/customer/search/'.$nextPage ;
                            }

                        ?>

                        <!-- Pagination -->
                            <small><?=$totalPages?>pages</small>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item <?= $prevDisabled?>">
                                    <a class="page-link" href="<?=$prevHref?>" aria-label="Previous" aria-disabled="<?=$prevAriadisabled?>">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                    </li>
                                    <li class="page-item active" aria-current="page"><a class="page-link" href="/admin/customer/search/<?= $page ?>"><?= $page ?></a></li>

                                    <li class="page-item <?=$nextDisabled?>">
                                    <a class="page-link" href="<?= $nextHref ?>" aria-label="Next" aria-disabled="<?=$nextAriadisabled?>">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                    </li>
                                </ul>
                            </nav>
                            <div class="form-pages">
                                <form action="/admin/customer/search" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <input class="btn btn-primary" type="submit" id="pageSearch" name="PageSearch" value="Page N°">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input class="form-control" type="number" id="page" name="page" value="<?=$page?>">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                    </div>

                </div>

            </div>
        <?php
        }
    }

?>


    <!-- Info Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Others Informations</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="" class="user">
                        @csrf
                        <input type="hidden" id="id" name="id"  value="">

                        <div class="form-group">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="">Sites</label>
                                    <input type="text" class="form-control" id="meters" name="meters" value="" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <textarea class="form-control" id="desc" readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="part3">Subscription</div>
                        <div class="form-group mt-2">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="date" class="form-control" id="subs_date" name="subs_date" value="" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="number" class="form-control" id="subs_amount" name="subs_amount" value="" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <input type="text" class="form-control" id="observation" name="observation" value="" readonly>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row float-right mt-3">
                            <a href="#">
                                <button class="btn btn-primary btn-user ml-2" type="button" data-dismiss="modal">Cancel</button>
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        $("body").on('click','.infoModal',function(event){

            var id = $(this).attr('customerID');
            var subs_date = $(this).attr('subs_date')
            var subs_amount = $(this).attr('subs_amount');
            var obs = $(this).attr('obs');
            var meters = $(this).attr('meters');
            var desc = $(this).attr('desc');

            $('#meters').val(meters);
            $('#subs_date').val(subs_date);
            $('#subs_amount').val(subs_amount);
            $('#observation').val(obs);
            $('#desc').val(desc);

        });

    </script>

@stop
