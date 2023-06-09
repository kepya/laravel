@extends('admin.layouts.skeleton')
@section('title', 'Customer')
<style>
 /* .btn:hover{
    background-color: #e7e7e7;
 } */

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
            <a class="nav-link collapsed" href="/admin/facture">
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
            <h1 class="h3 mb-0 text-gray-800"><a href="/admin/customer" class="mr-3"><i class="fas fa-chevron-circle-left"></i></a></h1>
        </div>
        <h1 class="h3 mb-0 text-gray-800"><b><?= isset($nbrCl)? $nbrCl.' ' : ''?></b>Blocked Customers, <b><?= isset($response) ? ($response["result"]['totalPages'] + 1).' ' : '1 ' ?></b> Pages</h1>
        <div>
            <button mode="<?=$mode?>" class="btn btn-primary showTable" id="showTable"><i class="fa fa-table"></i></button>
        </div>
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


    <!-- bloc normal -->

    <?php
        if(isset($response["result"])){

            $data = $response['result'];  //table informations returned

            $customers = $data['docs']; //table of customers

            $totalDocs = $data['totalDocs']; //number of customers in the database
            //$limit = $data['limit']; // limit of materials on a page
            $totalPages = $data['totalPages']; //number of pages
            $page = $data['page']; //current page
            //$pagingCounter = $data['pagingCounter']; //paging counter
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

            if($totalDocs!=0) {
    ?>
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <!-- Basic Card Example -->

            <?php
                foreach($customers as $customer){

                    //Verify if the person has many meters
                    $status = $customer['status'];
                    $delete = $customer['isDelete'];
                    $description = $customer['description'];

                    if($status == 0){
                        $card='bg-warning';
                        $class='btn-warning';
                        $state = 'Blocked';
                        $badge = 'badge-warning';
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
                            if($i == count($customer['description'])){
                                $desc = $desc.$description;
                            }else{
                                $desc = $desc.$description." / ";
                            }
                        }
                    }

                    if(!$delete && $status==0){
            ?>

            <div class="col-md-6 col-lg-4 custBloc">
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
                }
            ?>
    </div>

    <div class="flex d-flex justify-content-between mb-1">
        <!-- Detail Part -->
        <form action="/admin/customer/blockedCustomer" class="tableBloc" method="post" role="form" style="display:none;">
            @csrf
            <div class="flex d-flex align-items-center">
                entries :
                <select class="form-control ml-2" style="width: 70px;" id="size" name="size">
                    <option <?=$size == 10 ? 'selected' : ''?> value="10">10</option>
                    <option <?=$size == 15 ? 'selected' : ''?> value="15">15</option>
                    <option <?=$size == 20 ? 'selected' : ''?> value="20">20</option>
                    <option <?=$size == 25 ? 'selected' : ''?> value="25">25</option>
                </select>
                <input class="form-control" type="number" id="limit" name="limit" value="<?=$size ?? ''?>" hidden>
                <input class="form-control" type="text" id="mode" name="mode" value="<?=$mode ?? ''?>" hidden>
                <input type="submit" name="send_pagination" id="send_pagination" placeholder="Show" class="ml-1 btn btn-primary">
            </div>
        </form>
    </div>

    <div class="row" >
        <!-- Detail Part -->
        <div class="col-lg-12 tableBloc" style="display:none;">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
                </div>
                <div class="card-body container-fluid">
                <div class="table-responsive">
                    <table class="table table-hover">
                    <thead class="thead thead-danger">
                        <tr>
                            <th>ID</th>
                            <th style="text-align: center">Name</th>
                            <th style="text-align: center">Phone</th>
                            <th style="text-align: right">State</th>
                            <th style="text-align: right">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            foreach($customers as $customer){

                                //Verify if the person has many meters
                                $status = $customer['status'];
                                $delete = $customer['isDelete'];
                                $description = $customer['description'];

                                if($status == 0){
                                    $card='bg-primary';
                                    $class='btn-primary';
                                    $state = 'Blocked';
                                    $badge = 'badge-primary';
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
                                        if($i == count($customer['description'])){
                                            $desc = $desc.$description;
                                        }else{
                                            $desc = $desc.$description." / ";
                                        }
                                    }
                                }

                                if(!$delete && $status==0){ //Not deleted and blocked
                        ?>
                        <tr>
                            <td><?= $customer['customerReference']?></td>
                            <td style="text-align: center"><?=$customer['name']?></td>
                            <td style="text-align: center"><?= $phones?></td>
                            <td style="text-align: right">
                                <a href="/admin/customer/block/<?= $customer['_id']?>/<?= $status ?>" class="btn <?= $class ?>">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </span>
                                    <span class="text" style="margin:auto;"><?= $state ?></span>
                                </a>
                            </td>
                            <td style="text-align: right">
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

    <div class="row">
        <div class="col-12 d-flex justify-content-between ">

                <?php
                    //previous page
                    if($hasPrevPage == 0){
                        $prevDisabled = 'disabled';
                        $prevAriadisabled = 'true';
                        $prevHref = '#';
                    }else{
                        $prevDisabled = '';
                        $prevAriadisabled = '';
                        $prevHref = '/admin/customer/search/'.$prevPage.'/'.$size ?? '';
                    }

                    //next page
                    if($hasNextPage == 0){
                        $nextDisabled = 'disabled';
                        $nextAriadisabled = 'true';
                        $nextHref = '#';
                    }else{
                        $nextDisabled = '';
                        $nextAriadisabled = '';
                        $nextHref = '/admin/customer/search/'.$nextPage.'/'.$size ?? '' ;
                    }

                ?>

                <!-- Pagination -->
                <div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item <?= $prevDisabled?>">
                            <a class="page-link" href="<?=$prevHref?>" aria-label="Previous" aria-disabled="<?=$prevAriadisabled?>">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                            </li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="/admin/customer/search/<?= $page ?>/<?=$size ?? ''?>"><?= $page ?></a></li>

                            <li class="page-item <?=$nextDisabled?>">
                            <a class="page-link" href="<?= $nextHref ?>" aria-label="Next" aria-disabled="<?=$nextAriadisabled?>">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="form-pages">
                    <small></small>
                        <form action="/admin/customer/search" method="post">
                            @csrf
                            <div class="form-group d-flex align-items-center justify-content-end">
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" id="pageSearch" name="PageSearch" value="Page N°">
                                </div>
                                <div class="form-group pageSearch">
                                    <input class="form-control" type="number" id="page" name="page" value="<?=$page?>">
                                </div>
                                <div class="form-group pageSearchLimit">
                                    <div>Limit :</div>
                                </div>
                                <div class="form-group w-25">
                                    <input class="form-control pageSearchLimit" type="number" id="limit" name="limit" value="<?=$size ?? ''?>">
                                    <input class="form-control" type="text" id="mode" name="mode" value="<?=$mode ?? ''?>" hidden>
                                </div>
                            </div>

                        </form>
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

        var mode = "<?=$mode?>";

        if(mode == "custBloc"){
            $('.custBloc').css('display','block');
            $('.tableBloc').css('display','none');
            $('.pageSearchLimit').show();
            $('.pageSearch').removeClass('col-md-3').addClass('col-md-2');
        }else{
            $('.custBloc').css('display','none');
            $('.tableBloc').css('display','block');
            $('.pageSearchLimit').hide();
            $('.pageSearch').removeClass('col-md-2').addClass('col-md-3');
        }

        $("body").on('click','.showTable',function() {
            var mode = $(this).attr('mode');
            //passage en mode tableBloc
            if (mode == "custBloc"){
                $('.custBloc').css('display','none');
                $('.tableBloc').css('display','block');
                $('.pageSearchLimit').hide();
                $('.pageSearch').removeClass('col-md-2').addClass('col-md-3');
                mode = "tableBloc";
                $('#mode').val(mode);
                $(this).attr('mode',mode);
            //passage en mode custBloc
            }else{
                $('.custBloc').css('display','block');
                $('.tableBloc').css('display','none');
                $('.pageSearchLimit').show();
                $('.pageSearch').removeClass('col-md-3').addClass('col-md-2');
                mode = "custBloc";
                $('#mode').val(mode);
                $(this).attr('mode',mode);
            }
        });

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
