@extends('admin.layouts.skeleton')
@section('title', 'Consumption')
@section('nav')
<li class="nav-item">
    <a class="nav-link" href="/admin/home">
        <i class="fas fa-home"></i>
        <span>Home</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider" />

<!-- Heading -->
<div class="sidebar-heading">Information</div>

<!-- Nav Item - consumption -->
<li class="nav-item active">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices">
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
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities1">
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
<li class="nav-item ">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
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
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Client not in good standing</h1>
    <?php
        if (isset($messageOK)){?>
            <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle"></i> <?= $messageOK ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
<?php   } ?>
<?php if (isset($messageErr)){?>
            <div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-triangle"></i><?= $messageErr ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
<?php   } ?>
</div>

<div class="d-flex mt-4">
    <div class="form-group w-100">
        <div class="row justify-content-between">
            <div class="col-7 col-md-7">
                <form action="/admin/consumption-that-are-unpaid/searchCustomer" novalidate method="post" enctype="multipart/form-data" class="w-100 d-flex justify-content-between form-horizontal row-border">
                    @csrf
                    <input class="form-control" type="number" id="limit" name="limit" value="<?=$size ?? ''?>" hidden>
                    <input class="form-control" type="number" id="page" name="page" value="<?=$page ?? ''?>" hidden>
                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Search User by name">
                    <button class="btn btn-primary ml-3" style="width: 40%;" type="submit" name="search" id="search"><i class="fas fa-search"></i> Search by name</button>
                </form>
            </div>
            <div class="col-4 col-md-4">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="{{ url('/admin/consumption-that-are-unpaid') }}" class="btn btn-danger"><i class="fas fa-search"></i> Reload Page</a>
                </div>
            </div>
        </div>
    </div>
</div>



<?php

    if(isset($response) || isset($response2)){

        if (isset($response2['search'])){

            $customers = $response2['result']; ?>

            <div class="row" >
                <!-- Detail Part -->
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
                        </div>
                        <div class="card-body container-fluid">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead thead-danger">
                                        <tr>
                                            <th>Name</th>
                                            <th>Subscription Date</th>
                                            <th>Unpaid Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            foreach($customers as $customer){

                                                //Verify if the person has many meters
                                                $status = $customer['client']['status'];
                                                $delete = $customer['client']['isDelete'];
                                                $unpaidAmount = $customer['unPaidAmount'];

                                                if($status == 1){
                                                    $card='bg-primary';
                                                    $class='btn-primary';
                                                    $state = 'Active';
                                                    $badge = 'badge-success';
                                                }

                                                if(empty($status)){
                                                    $status = 0;
                                                }

                                                if(!$delete && $status==1){
                                        ?>
                                        <tr>
                                            <td><?=$customer['client']['name']?></td>
                                            <td><?= $customer['client']['subscriptionDate'] ? $customer['client']['subscriptionDate'] : '' ?></td>
                                            <td><?= $unpaidAmount ?></td>
                                            <td>
                                                <a href="#" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="pay">
                                                    <span class="icon"  style="color:white;">
                                                        Pay <i class="fas fa-file-invoice-dollar"></i>
                                                    </span>
                                                </a>
                                                <a href="#" class="btn <?= $card ?>" customerID="<?= $customer['client']['_id'] ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="info">
                                                    <span class="icon"  style="color:white;">
                                                        See <i class="fas fa-eye"></i>
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

<?php
        }else{

            $data = $response->result;

            $customers = $data->docs; //table of customers

            $totalDocs = $data->totalDocs; //number of customers not in good standing
            //$limit = $data['limit']; // limit of materials on a page
            $totalPages = $data->totalPages; //number of pages
            $page = $data->page; //current page
            //$pagingCounter = $data['pagingCounter']; //paging counter
            $hasPrevPage = $data->hasPrevPage; //boolean if previous page exists
            $hasNextPage = $data->hasNextPage; //boolean if next page exists
            $prevPage = $data->prevPage; //index of the previous page
            $nextPage = $data->nextPage; //index of the next page

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
                <div class="flex d-flex justify-content-between mb-1">
                    <!-- Detail Part -->
                    <form action="/admin/consumption-that-are-unpaid" class="tableBloc" method="post" role="form">
                        @csrf
                        <div class="flex d-flex align-items-center">
                            entries :
                            <select class="form-control ml-2" style="width: 70px;" id="entrySize" name="entrySize">
                                <option <?=$size == 10 ? 'selected' : ''?> value="10">10</option>
                                <option <?=$size == 15 ? 'selected' : ''?> value="15">15</option>
                                <option <?=$size == 20 ? 'selected' : ''?> value="20">20</option>
                                <option <?=$size == 25 ? 'selected' : ''?> value="25">25</option>
                            </select>
                            <input class="form-control" type="number" id="limit" name="limit" value="<?=$size ?? ''?>" hidden>
                            <input class="form-control" type="number" id="page" name="page" value="<?=$page ?? ''?>" hidden>
                            <input type="submit" name="send_pagination" id="send_pagination" placeholder="Show" class="ml-1 btn btn-primary">
                        </div>
                    </form>
                </div>

                <div class="row" >
                    <!-- Detail Part -->
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Customers</h6>
                            </div>
                            <div class="card-body container-fluid">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead thead-danger">
                                            <tr>
                                                <th>Name</th>
                                                <th>Subscription Date</th>
                                                <th>Unpaid Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                                foreach($customers as $customer){

                                                    //Verify if the person has many meters
                                                    $status = $customer->client->status;
                                                    $delete = $customer->client->isDelete;
                                                    $unpaidAmount = $customer->unpaidAmount;

                                                    if($status == 1){
                                                        $card='bg-primary';
                                                        $class='btn-primary';
                                                        $state = 'Active';
                                                        $badge = 'badge-success';
                                                    }

                                                    if(empty($status)){
                                                        $status = 0;
                                                    }

                                                    if(!$delete && $status==1){
                                            ?>
                                            <tr>
                                                <td><?=$customer->client->name?></td>
                                                <td><?= $customer->client->subscriptionDate ? $customer->client->subscriptionDate : '' ?></td>
                                                <td><?= $unpaidAmount ?></td>
                                                <td>
                                                    <a href="#modal-pay-{{ $customer->client->_id }}" class="btn btn-warning" role="button" data-toggle="modal" data-target="#modal-pay-{{ $customer->client->_id }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="pay">
                                                        <span class="icon"  style="color:white;">
                                                            Pay <i class="fas fa-file-invoice-dollar"></i>
                                                        </span>
                                                    </a>
                                                    <a href="/admin/consumption-that-are-unpaid/<?= $customer->client->_id ?>" class="btn <?= $card ?>" customerID="<?= $customer->client->_id ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="info">
                                                        <span class="icon"  style="color:white;">
                                                            See <i class="fas fa-eye"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>
                                <?php
                                        } ?>

                                        <div class="modal fade" tabindex="-1" id="modal-pay-{{ $customer->client->_id }}" role="dialog" aria-labelledby="payModalLabel" data-backdrop="static"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <section>
                                                            Pay
                                                        </section>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="/admin/consumption-that-are-unpaid/pay" class="user" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <input type="hidden" id="id" name="id"  value="<?= $customer->client->_id ?>">
                                                            <input type="hidden" id="page" name="page"  value="<?= $page ?>">
                                                            <input type="hidden" id="size" name="size"  value="<?= $size ?>">

                                                            <div class="amount">
                                                                Amount
                                                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                                                    id="amount" name="amount" placeholder="amount" value="" required>
                                                                    @error('amount')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
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

                                <?php
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
                                    $prevHref = '/admin/consumption-that-are-unpaid/'.$prevPage.'/'.$size ?? '';
                                }

                                //next page
                                if($hasNextPage == 0){
                                    $nextDisabled = 'disabled';
                                    $nextAriadisabled = 'true';
                                    $nextHref = '#';
                                }else{
                                    $nextDisabled = '';
                                    $nextAriadisabled = '';
                                    $nextHref = '/admin/consumption-that-are-unpaid/'.$nextPage.'/'.$size ?? '' ;
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
                                        <li class="page-item active" aria-current="page"><a class="page-link" href="/admin/consumption-that-are-unpaid/<?= $page ?>/<?=$size ?? ''?>"><?= $page ?></a></li>

                                        <li class="page-item <?=$nextDisabled?>">
                                        <a class="page-link" href="<?= $nextHref ?>" aria-label="Next" aria-disabled="<?=$nextAriadisabled?>">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                    </div>

                </div>
<?php
            }
        }
    }
?>

@stop
