@extends('admin.layouts.skeleton')
@section('title', 'Administrator')
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
        <li class="nav-item ">
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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Administrators</h1>
        <div class="d-flex">
            @if(Session::has('profile'))
                @if(Session::get('profile') == "superAdmin")
                <a href="/admin/administrator/addAdministrator" class="btn btn-primary"> Add an administrator </a>
            @endif
            @endif
            <form action="/admin/find" class="ml-3" novalidate method="post" enctype="multipart/form-data" class="form-horizontal row-border">
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
    </div>

    <?php
        if ($administrators != null) {
            if($administrators['status'] == 200){

                    $informations = $administrators['result'];
                    ?>

            <div class="container">
            <table class="table table-striped table-light table-hover table-sm table-responsive-lg text-center">
                <thead style="background-color:#4e73df;color:white;">
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    @if(Session::has('profile'))
                        @if(Session::get('profile') == "superAdmin")
                            <th>Active/Blocked</th>
                        @endif
                    @endif
                    <th>Registered_at</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                    <?php

                        foreach($informations as $key => $info) {
                            $name = $info['name'];
                            $email = $info['email'];
                            $phone = $info['phone'];
                            $registered_at = date('d-m-Y H:i:s', strtotime($info['createdAt']));

                            if($info['profileImage'] != "noPath"){
                                $image = url('storage/'.$info['profileImage']);
                            }else{
                                $image = "/img/undraw_profile.svg";
                            }

                            $status = $info['status'];
                            if(empty($status)){
                                $status = 0;
                            }

                            $delete = $info['isDelete'];

                    ?>
                <tr style="background-color:white;color:black;">
                    <td><img class="img-profile" src='<?= $image ?>' height="40" width="40"/></td>
                    <td><?= $name ?></td>
                    <td><?= $email ?></td>
                    <td><?= $phone ?></td>
                    @if(Session::has('profile'))
                        @if(Session::get('profile') == "superAdmin")
                            <td>
                            <?php

                                if($delete){
                                    $state = 'Deleted';
                                }elseif($status == 1){
                                    $class='btn-success';
                                    $state = 'Active';
                                }
                                else{
                                    $class='btn-warning';
                                    $state = 'Blocked';
                                }

                                if($delete == 1){ ?>

                                    <span class="text"><?= $state ?></span>

                        <?php }else{ ?>

                                <a href="/admin/administrator/block/<?= $info['_id']?>/<?= $status ?>">
                                <button class="btn btn-sm btn-space <?= $class ?> rounded-pill"><?= $state ?></button>
                                </a>

                        <?php }?>

                            </td>
                        @endif
                    @endif
                    <td><?= $registered_at ?></td>
                    <td>
                            @if(Session::has('profile'))

                                @if(Session::get('profile') != "superAdmin")

                                    {{ _('No action') }}

                                @else
                                    @if($delete)
                                        {{ _('Deleted') }}

                                    @else

                                    <a href="/admin/administrator/edit/<?= $info['_id']?>" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                                        <span class="icon">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </a>

                                    <a href="/admin/administrator/delete/<?= $info['_id']?>" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                                        <span class="icon">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>


                                    @endif
                                @endif
                            @endif
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            </div>
            <?php }
        }
    ?>


@stop
