@extends('Client.layout.default')
@section('title', 'Dashboard')
@section('nav')
        <li class="nav-item active" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home">
            <a class="nav-link" href="/home">
            <i class="fas fa-home"></i>
            <span>Home</span></a
            >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Information</div>

        <!-- Nav Item - consumption -->
        <li class="nav-item ">
            <a class="nav-link collapsed"  href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Budget</span>
            </a>
            <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities1" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Budget</h6>
                    <a class="collapse-item" href="/budget-stat" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices paid">statistics</a>
                    <a class="collapse-item" href="/budget-detail" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices unpaid">Details</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Invoice -->
        <li class="nav-item">
            <a class="nav-link collapsed"  href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices">
                <i class="fas fa-money-bill-alt"></i>
                <span>Invoices</span>
            </a>
            <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities1" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Invoices</h6>
                    <a class="collapse-item" href="/invoices_paid" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices paid">Invoices Paid</a>
                    <a class="collapse-item" href="/unpaid_invoices" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices unpaid">Unpaid Invoices</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Profile Setting -->
        @if(Session::has('status'))
            @if(Session::get('status') != 0)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="/user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profile">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Profile Setting</span>
                    </a>
                </li>
            @endif
        @endif

        <!-- Nav Item - Policy -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/clauses" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profile">
            <i class="fas fa-list"></i>
            <span>Confidentiality Clauses</span>
            </a>
        </li>

        <!-- Nav Item - Log out -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Log Out" href="/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log out</span>
            </a>
        </li>

@stop
@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Personal Information</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total of invoices -->
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
                            Total Invoices
                        </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                    print_r($informations['result']['numberFacture']);
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Invoices that have been paid -->
        <div class="col-xl-4 col-md-6 mb-4">
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
                            Total Invoices Paid
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                                    print_r($informations['result']['numberFacturePaid']);
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

        <!-- Total invoice which didn't paid -->
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
                                Total Unpaid Invoices
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                    print_r($informations['result']['numberFactureInvoice']);
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Content Row -->

    <!-- Content Row -->
    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Invoice Paid</h6>
                </div>
                <div class="card-body container-fluid">
                    <?php
                        $lengthPaid = count($informations['result']['facturePaid']);
                        for ($i=0; $i < $lengthPaid; $i++) {
                    ?>
                    <div class="col-lg-12 bg-info mb-2 row">
                        <div class="text-white col-md-4">
                        <div class="">
                            New Index
                            <div class="text-white-50 small">
                                <?php
                                    print_r($informations['result']['facturePaid'][$i]['newIndex']);
                                ?>
                            </div>
                        </div>
                        </div>
                        <div class="text-white col-md-4">
                        <div class="">
                            Old Index
                            <div class="text-white-50 small">
                                <?php
                                    print_r($informations['result']['facturePaid'][$i]['oldIndex']);
                                ?>
                            </div>
                        </div>
                        </div>
                        <div class="text-white col-md-3">
                        <div class="">
                            Payment Date
                            <div class="text-white-50 small">
                                <?php
                                    $date = null;
                                    if(array_key_exists('dateFacturation', $informations['result']['facturePaid'][$i])) {
                                        $date = $informations['result']['facturePaid'][$i]['dateFacturation'];
                                    }
                                    echo (substr($date, 0, 11));
                                ?>
                            </div>
                        </div>
                        </div>
                        <div class="text-white col-md-1">
                        <div class="col-auto">
                            <i class="fas fa-arrow-right text-primary" style="font-size: 30px; cursor:pointer"
                            ></i>
                        </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Unpaid Invoices</h6>
                </div>
                <div class="card-body container-fluid">
                    <?php
                        $lengthInvoid = count($informations['result']['factureInvoice']);
                        for ($i=0; $i < $lengthInvoid; $i++) {
                    ?>
                        <div class="col-lg-12 bg-danger mb-2 row">
                            <div class="text-white col-md-4">
                                <div class="">
                                    amount outstanding
                                    <div class="text-white-50 small">
                                        <?php
                                            print_r($informations['result']['factureInvoice'][$i]['montantImpaye']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="text-white col-md-4">
                                <div class="">
                                    amount paid
                                    <div class="text-white-50 small">
                                        <?php
                                            print_r($informations['result']['factureInvoice'][$i]['montantVerse']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="text-white col-md-3">
                                <div class="">
                                    Date Released
                                    <div class="text-white-50 small">
                                        <?php
                                            $date = $informations['result']['factureInvoice'][$i]['dateReleveNewIndex'];
                                            echo (substr($date, 0, 11));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="text-white col-md-1">
                                <div class="col-auto">
                                    <i
                                    class="fas fa-lightbulb"
                                    style="font-size: 30px; color: red"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">About Your Account</h6>
                </div>
                <div class="card-body container-fluid">
                    <p>Name : <?= $informations['result']['client']['name']; ?></p>
                    <p>Phone : <?= $informations['result']['client']['phone']; ?></p>
                    <p>Email : <?= $informations['result']['client']['email']; ?></p>
                    <p>Id Meter : <?= $informations['result']['client']['IdCompteur']; ?></p>
                </div>
            </div>
        </div>

    </div>
@stop
