@extends('admin.layouts.skeleton')
@section('title', 'Consumption')
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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Consumption</h1> 
    </div>

    <div class="flex d-flex justify-content-between mb-1">
        <!-- Detail Part -->
        <form action="{{url('/admin/search_invoices')}}" method="post" role="form">
            @csrf
            <div class="flex d-flex align-items-center">
                entries :
                <select class="form-control ml-2" style="width: 70px;" id="select_size" name="select_size" value="<?= $size ?>">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input type="submit" name="send_pagination_consumption_paid" id="send_pagination_consumption_paid" placeholder="Show" class="ml-1 btn btn-primary">
            </div>
        </form>
        <form action="{{url('/admin/search_invoices')}}" method="post" role="form">
            @csrf
            <div class="flex d-flex align-items-center">
            search By :
            <select onchange="onChange(this)" class="form-control ml-2" #type name="type" id="type" style="width: 100px;">
                <option value="month">Month</option>
                <option value="year">Year</option>
                <option value="username">Username</option>
            </select>
            <input type="number" name="search" id="search" class="form-control ml-2" style="width: 100px;" />
            <input type="text" name="searchT" id="searchT" class="form-control ml-2" style="width: 100px;"/>
            <input type="submit" name="send_search_consumption_unpaid" id="send_search_consumption_unpaid" class="ml-1 btn btn-primary">
        </div>
        </form>
    </div>
    <div class="row">
        <!-- Detail Part -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Invoices</h6>
                </div>
                <div class="card-body container-fluid">
                <div class="table-responsive">
                    <table class="table table-hover">
                    <thead class="thead thead-danger">
                    <tr>
                        <th>Name</th>
                        <th style="text-align: center">Consumption</th>
                        <th style="text-align: center">Amount</th>
                        <th style="text-align: center">Paid</th>
                        <th style="text-align: center">Limite of paiement</th>
                        <th style="text-align: right">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{$client[$loop ->index]->name}}</td>
                            <td style="text-align: center">{{$invoice -> consommation}} m<sup>3</sup></td>
                            <td style="text-align: center">{{$invoice -> montantConsommation}}</td>
                            <td style="text-align: center">{{$invoice -> montantVerse}} FCFA</td>
                            <td style="text-align: center">{{date('d-m-Y H:i:s', strtotime($invoice -> dataLimitePaid))}}</td>
                            <td style="text-align: right">
                                <a href="{{ url('/admin/detail-consumption/'.$invoice->_id.'/edit') }}" class="btn btn-xs btn-primary pull-right">
                                    <i class="fa fa-pencil-alt" style="font-size: 20px;">
                                    </i> 
                                </a>
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
    <div class="flex d-flex justify-content-end mb-1">
        <div style="border: 1px; border-style: solid; border-radius: 5px;">
            @if($previous_page > 1 || ($previous_page == 1 && $page_en_cours > 1))
                <a href="{{ url('/admin/consumption-that-are-paid/page/'.$previous_page.'/size/'.$size) }}">
                    <button class="btn bg-white"> <i class="fas fa-angle-double-left" style="color: blue;"></i> </button>
                </a>
                <a href="{{ url('/admin/consumption-that-are-paid/page/'.$previous_page.'/size/'.$size) }}">
                    <button class="btn bg-white" style="color: blue;border-radius: 0px;">{{$previous_page}}</button>
                </a>
            @else
                <button class="btn bg-white" style="border-radius: 0px;"> <i class="fas fa-angle-double-left"></i> </button>
            @endif
            <!-- Detail Part -->
            <a href="{{ url('/admin/consumption-that-are-paid/page/'.$page_en_cours.'/size/'.$size) }}">
                    <button class="btn btn-primary"  style="width: 40px;border-radius: 0px;" name="page_search" id="page_search">{{$page_en_cours}}</button>
            </a>
            @if($next_page > 1)
                <a href="{{ url('/admin/consumption-that-are-paid/page/'.$next_page.'/size/'.$size) }}">
                    <button class="btn"  style="width: 40px;border-radius: 0px; color: black;" name="page_search" id="page_search">{{$next_page}}</button>
                </a>
                <a href="{{ url('/admin/consumption-that-are-paid/page/'.$next_page.'/size/'.$size) }}">
                    <button class="btn bg-white" style="width: 40px;border: none;border-radius: 0px;"> <i class="fas fa-angle-double-right" style="color: blue;"></i> </button>
                </a>
            @else
                <button class="btn bg-white" style="width: 40px;border-radius: 0px;"> <i class="fas fa-angle-double-right"></i> </button>
            @endif
        </div>
    </div>

   <script type="text/javascript">
        let btn_penalty = document.getElementById('penalty');
        let btn_tranche = document.getElementById('tranche');

        btn_tranche.addEventListener("click", (event) => {
            $('#mediumTrancheModal').modal("show");
        })

        btn_penalty.addEventListener("click", (event) => {
            $('#mediumPenaltyModal').modal("show");
        })

        const searchT = document.getElementById('searchT');
        searchT.hidden=true;

        function onChange(event) {
            value = event.value;
            const search = document.getElementById('search');
            const searchT = document.getElementById('searchT');

            if (value === "year") {
                searchT.value = null;
                searchT.hidden=true;
                search.hidden=false;
            } else if (value === "month") {
                searchT.value = null;
                searchT.hidden=true;
                search.hidden=false;
            } else {
                searchT.hidden=false;
                search.value = null;
                search.hidden=true;
            }
        }

    </script>
@stop