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
    <h1 class="h3 mb-0 text-gray-800"><a href="/admin/consumption-that-are-unpaid" class="mr-3"><i class="fas fa-chevron-circle-left"></i></a>Unpaid Consumption</h1>
    @if(Session::has('message'))
        <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
            {{ Session::get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>

<div class="flex d-flex justify-content-start mb-3">
    <form action="{{url('/admin/search_invoices')}}" method="post" role="form" class="w-100">
        @csrf
        <div class="flex d-flex align-items-center justify-content-between">
            <h5 class="me-2 mr-2 w-50">search By :</h5>
            <input type="number" name="month" id="month" placeholder="Month" title="Month" class="form-control ml-2" />
            <input type="number" name="year" id="year" placeholder="Year" title="Year" class="form-control ml-2"/>
            <input type="number" name="consumption" id="consumption" placeholder="Consumption" title="Consumption" class="form-control ml-2"/>
            <input type="text" name="username" id="username" placeholder="Username" title="Username" value="<?= $userInfo->name ?>" class="form-control ml-2" disabled/>
            <input type="hidden" name="userID" id="userID" value="<?= $userInfo->_id ?>"/>
            <input type="submit" name="send_search_consumption_unpaid" id="send_search_consumption_unpaid" class="ml-1 btn btn-primary">
        </div>
    </form>
</div>
<div class="row">
    <!-- Detail Part -->
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Unpaid Invoices</h6>
            </div>
            <div class="card-body container-fluid">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead thead-danger">
                            <tr>
                                <th style="text-align: center">Consumption</th>
                                <th style="text-align: center">Amount</th>
                                <th style="text-align: center">UnPaid</th>
                                <th style="text-align: center">Limite of paiement</th>
                                <th style="text-align: right">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($unPaidInvoices as $invoice)
                            <tr>
                                <td style="text-align: center">{{$invoice -> consommation}} m<sup>3</sup></td>
                                <td style="text-align: center">{{$invoice -> montantConsommation}}</td>
                                <td style="text-align: center">{{$invoice -> montantImpaye}} FCFA</td>
                                <td style="text-align: center">{{date('d-m-Y H:i:s', strtotime($invoice -> dataLimitePaid))}}</td>
                                <td style="text-align: right">
                                    <a href="{{ url('/admin/detail-consumption/'.$invoice-> _id.'/edit') }}" class="btn btn-xs btn-primary pull-right">
                                        <i class="fa fa-pencil-alt" style="font-size: 20px;">
                                        </i>
                                    </a>
                                    <button  title="delete invoice" type="button" class="btn btn-xs btn-danger pull-right" role="button" data-toggle="modal" data-target="#modal-delete-{{ $invoice->_id }}">
                                        <i class="fa fa-trash" style="font-size: 20px;">
                                        </i>
                                    </button>
                                    <button type="button" class="btn btn-xs btn-primary pull-right" role="button" data-toggle="modal" data-target="#modal-penalty-{{ $invoice->_id }}">
                                        <i class="far fa-eye" style="font-size: 20px;">
                                        </i> P
                                    </button>
                                    <button type="button" class="btn btn-xs btn-primary pull-right" role="button" data-toggle="modal" data-target="#modal-tranche-{{ $invoice->_id }}">
                                        <i class="far fa-eye" style="font-size: 20px;">
                                        </i> T
                                    </button>

                                    <!-- medium modal -->
                                    <div class="modal fade" tabindex="-1" id="modal-penalty-{{ $invoice->_id }}" role="dialog" aria-labelledby="mediumPenaltyModalLabel" data-backdrop="static" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <section>
                                                        Penalty
                                                    </section>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    $penalty = $invoice->penalty;
                                                    $length = count($penalty);
                                                    for ($i = 0; $i < $length; $i++) {
                                                        echo nl2br('Montant: '.$penalty[$i] -> montant.'<br/>');
                                                        echo nl2br('Date: '.$penalty[$i] -> date);
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" tabindex="-1" id="modal-tranche-{{ $invoice->_id }}" role="dialog" aria-labelledby="mediumTrancheModalLabel" data-backdrop="static"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <section>
                                                        Tranches
                                                    </section>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @foreach($invoice -> tranche as $value)
                                                        <div class="d-flex flex">
                                                            <p>{{$value->montant}}</p>
                                                        </div>
                                                    @endforeach
                                                    <?php
                                                        $tranche = $invoice->tranche;
                                                        $length = count($tranche);
                                                        for ($i = 0; $i < $length; $i++) {
                                                            echo nl2br('Montant: '.$tranche[$i] -> montant.'<br/>');
                                                            echo nl2br('Date: '.$tranche[$i] -> date);
                                                        }
                                                        ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" tabindex="-1" id="modal-delete-{{ $invoice->_id }}" role="dialog" aria-labelledby="mediumDeleteModalLabel" data-backdrop="static" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <section>
                                                        Delete Invoice
                                                    </section>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="d-flex flex justify-content-start align-items-center">Are you sure you want to delete this invoice ?</span>
                                                    <div class="d-flex flex justify-content-end align-items-center">
                                                        <button type="button" class="btn mt-1 btn-xs btn-danger pull-right" role="button">
                                                            <a href="{{ url('/admin/invoice/delete/'.$invoice->_id) }}" class="ms-3 text-white">
                                                                Delete
                                                            </a>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop