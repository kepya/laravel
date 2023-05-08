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
        <li class="nav-item active">
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
        <h1 class="h3 mb-0 text-gray-800">Paid Consumption</h1>
    </div>

    <div class="flex d-flex justify-content-start mb-3">
        <form action="{{url('/admin/search_invoices')}}" method="post" role="form" class="w-100">
            @csrf
            <div class="flex d-flex align-items-center justify-content-between">
                <h5 class="me-2 mr-2 w-50">search By :</h5>
                <input type="number" name="month" id="month" placeholder="Month" title="Month" class="form-control ml-2" />
                <input type="number" name="year" id="year" placeholder="Year" title="Year" class="form-control ml-2"/>
                <input type="number" name="consumption" id="consumption" placeholder="Consumption" title="Consumption" class="form-control ml-2"/>
                <input type="text" name="username" id="username" placeholder="Username" title="Username" class="form-control ml-2"/>
                <input type="submit" name="send_search_consumption_paid" id="send_search_consumption_paid" class="ml-1 btn btn-primary">
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
                        <td>{{$invoice->user->name}}</td>
                            @if($invoice -> invoice ->  consommation > 0)
                                <td style="text-align: center">{{$invoice -> invoice ->  consommation}} m<sup>3</sup></td>
                            @else
                                <td style="text-align: center">{{-1 * ($invoice -> invoice ->  consommation)}} m<sup>3</sup></td>
                            @endif
                            @if($invoice -> invoice ->  montantConsommation > 0)
                                <td style="text-align: center">{{$invoice -> invoice ->  montantConsommation}}</td>
                            @else
                                <td style="text-align: center">{{-1 * ($invoice -> invoice ->  montantConsommation)}}</td>
                            @endif
                            <td style="text-align: center">{{$invoice -> invoice ->  montantVerse}} FCFA</td>
                            <td style="text-align: center">{{date('d-m-Y H:i:s', strtotime($invoice -> invoice ->  dataLimitePaid))}}</td>
                            <td style="text-align: right">
                                <a href="{{ url('/admin/detail-consumption/'.$invoice-> invoice -> _id.'/edit') }}" class="btn btn-xs btn-primary pull-right">
                                    <i class="fa fa-pencil-alt" style="font-size: 20px;">
                                    </i>
                                </a>
                                <button  title="delete invoice" type="button" class="btn btn-xs btn-danger pull-right" role="button" data-toggle="modal" data-target="#modal-delete-{{ $invoice-> invoice ->_id }}">
                                        <i class="fa fa-trash" style="font-size: 20px;">
                                        </i>
                                    </button>
                                <button type="button" class="btn btn-xs btn-primary pull-right" role="button" data-toggle="modal" data-target="#modal-penalty-{{ $invoice-> invoice -> _id }}">
                                    <i class="far fa-eye" style="font-size: 20px;">
                                    </i> P
                                </button>
                                <button type="button" class="btn btn-xs btn-primary pull-right" role="button" data-toggle="modal" data-target="#modal-tranche-{{ $invoice-> invoice -> _id }}">
                                    <i class="far fa-eye" style="font-size: 20px;">
                                    </i> T
                                </button>
                                   <!-- medium modal -->
                                    <div class="modal fade" tabindex="-1" id="modal-penalty-{{ $invoice-> invoice -> _id }}" role="dialog" aria-labelledby="mediumPenaltyModalLabel" data-backdrop="static" aria-hidden="true">
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
                                                    $penalty = $invoice-> invoice -> penalty;
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

                                    <div class="modal fade" tabindex="-1" id="modal-tranche-{{ $invoice-> invoice -> _id }}" role="dialog" aria-labelledby="mediumTrancheModalLabel" data-backdrop="static"
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
                                                        $tranche = $invoice-> invoice -> tranche;
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
                                    <div class="modal fade" tabindex="-1" id="modal-delete-{{ $invoice-> invoice ->_id }}" role="dialog" aria-labelledby="mediumDeleteModalLabel" data-backdrop="static" aria-hidden="true">
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
                                                            <a href="{{ url('/admin/invoice/delete/'.$invoice-> invoice ->_id) }}" class="ms-3 text-white">
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

    <div class="flex d-flex justify-content-between mb-1">
        <form action="{{url('/admin/search_invoices')}}" method="post" role="form">
            @csrf
            <div class="flex d-flex align-items-center">
                entries :
                <input type="text" name="url" id="url" placeholder="url" title="url" class="form-control" value="<?= $url ?? '' ?>" hidden/>

                <select class="form-control ml-2" style="width: 70px;" id="select_size" name="select_size" value="<?= $size ?>">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input type="submit" name="send_pagination_consumption_unpaid" id="send_pagination_consumption_unpaid" placeholder="Show" class="ml-1 btn btn-primary">
            </div>
        </form>
        @if($isSearch ?? '' == false)
            <div style="height: 100%; border: 1px; border-style: solid; border-radius: 5px;">
                @if($hasPrevPage ?? '' == true)
                    <a href="{{ url('/admin/consumption-that-are-paid/page/'.$previous_page.'/size/'.$size) }}">
                        <button class="btn bg-white"> <i class="fas fa-angle-double-left" style="color: blue;"></i> </button>
                    </a>
                    <a href="{{ url('/admin/consumption-that-are-paid/page/'.$previous_page.'/size/'.$size) }}">
                        <button class="btn bg-white" style="color: blue;border-radius: 0px;">{{$previous_page}}</button>
                    </a>
                @else
                    <button disabled class="btn bg-white" style="border-radius: 0px;"> <i class="fas fa-angle-double-left"></i> </button>
                @endif
                <a href="{{ url('/admin/consumption-that-are-paid/page/'.$page_en_cours.'/size/'.$size) }}">
                    <button class="btn btn-primary" style="width: 40px;border-radius: 0px;" name="page_search" id="page_search">{{$page_en_cours}}</button>
                </a>
                @if($hasNextPage ?? '' == true)
                    <a href="{{ url('/admin/consumption-that-are-paid/page/'.$next_page.'/size/'.$size) }}">
                        <button class="btn" style="width: 40px;border-radius: 0px; color: black;" name="page_search" id="page_search">{{$next_page}}</button>
                    </a>
                    <a href="{{ url('/admin/consumption-that-are-paid/page/'.$next_page.'/size/'.$size) }}">
                        <button class="btn bg-white" style="width: 40px;border: none;border-radius: 0px;"> <i class="fas fa-angle-double-right" style="color: blue;"></i> </button>
                    </a>
                @else
                    <button disabled class="btn bg-white" style="width: 40px;border-radius: 0px;"> <i class="fas fa-angle-double-right"></i> </button>
                @endif
            </div>
        @else
            <form style="height: 100%; border: 1px; border-style: solid; border-radius: 5px;" action="{{url('/admin/search_invoices_pagination')}}" method="post" role="form">
                <input type="number" value="<?= $month ?>" name="month" id="month" placeholder="Month" title="Month" class="form-control ml-2" hidden/>
                <input type="number" value="<?= $year ?>" name="year" id="year" placeholder="Year" title="Year" class="form-control ml-2" hidden/>
                <input type="number" value="<?= $consumption ?>" name="consumption" id="consumption" placeholder="Consumption" title="Consumption" hidden class="form-control ml-2"/>
                <input type="number" value="<?= $page_en_cours ?>" name="page" id="page" placeholder="page" title="page" hidden class="form-control ml-2"/>
                <input type="number" value="<?= $size ?>" name="size" id="size" placeholder="size" title="size" hidden class="form-control ml-2"/>
                <input type="text" value="<?= $username ?>" name="username" id="username" placeholder="Username" title="Username" class="form-control ml-2" hidden/>
                <input type="text" value="paid" name="type" id="type" placeholder="type" title="type" class="form-control ml-2" hidden/>

                @if($hasPrevPage ?? '' == true)
                    <button class="btn bg-white" name="previous_page" id="previous_page"  type="submit"> <i class="fas fa-angle-double-left" style="color: blue;"></i> </button>
                    <button class="btn bg-white" name="previous_page" id="previous_page" style="color: blue;border-radius: 0px;" type="submit">{{$previous_page}}</button>
                @else
                    <button disabled class="btn bg-white" style="border-radius: 0px;" type="button"> <i class="fas fa-angle-double-left"></i> </button>
                @endif
                    <button class="btn btn-primary" style="width: 40px;border-radius: 0px;"  name="current_page" id="current_page">{{$page_en_cours}}</button>
                @if($hasNextPage ?? '' == true)
                    <button class="btn" name="next_page" id="next_page" style="width: 40px;border-radius: 0px; color: black;" type="submit">{{$next_page}}</button>
                    <button class="btn bg-white" name="next_page" id="next_page" style="width: 40px;border: none;border-radius: 0px;" type="submit"> <i class="fas fa-angle-double-right" style="color: blue;"></i> </button>
                @else
                    <button disabled class="btn bg-white" style="width: 40px;border-radius: 0px;"  type="button"> <i class="fas fa-angle-double-right"></i> </button>
                @endif
            </form>
        @endif
    </div>
@stop
