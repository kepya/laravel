@extends('admin.layouts.skeleton')
@section('title', 'Bill')
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

<div class="card mb-4">
    <div class="card-header">
        Detail of Invoice
    </div>
    <div class="card-body">
        <div class="container">

            <?php if (isset($messageOK)){?>
                    <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle"></i> <?= $messageOK ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
            <?php } ?>
            <?php if (isset($messageErr)){?>
                    <div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-triangle"></i><?= $messageErr ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
            <?php } ?>

            @if($show == false)
            <form method="post" id="detailInvoice" action="/admin/facture/{{$invoice->_id}}" class="col-lg-8 offset-lg-2">
                {{csrf_field()}}
                <div class="form-group mb-3">
                    <div class="input-group">Personnel</div>

                    <select name="idClient" id="idClient" class="form-control" disabled>
                        <option value={{$client -> _id}}>{{ $client -> name }}</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <div class="input-group">New index</div>
                            <input type="number" class="form-control" placeholder="new index" id="newIndex" name="newIndex" value="<?= $invoice  -> newIndex?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <div class="input-group">Old index</div>
                            <input type="number" class="form-control" placeholder="old index" id="oldIndex" name="oldIndex" value="<?= $invoice  -> oldIndex?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <div class="input-group">Id Counter</div>
                            <input type="text" disabled class="form-control" placeholder="Id Counter" id="idCompteur" name="idCompteur" value="<?= $invoice  -> idCompteur?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <div class="input-group">Surplus</div>
                            <input type="number" class="form-control" placeholder="surplus" id="surplus" name="surplus" value="<?= $invoice  -> surplus?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <div class="input-group">Date of spicy</div>
                            <input type="text" disabled class="form-control" id="dateSpicy" name="dateSpicy" placeholder="Date of spicy" value="<?= date('d-m-Y ', strtotime($invoice  -> dateReleveNewIndex))?>" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <div class="input-group">Date Limit of paiement</div>
                            <input type="text" disabled class="form-control" id="dataPaid" name="dataPaid" placeholder="Date of payement" value="<?= date('d-m-Y ', strtotime($invoice  -> dataLimitePaid))?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3">
                        <div class="input-group">Consumption</div>
                        <input type="number" disabled class="form-control" placeholder="consumption" id="consumption" name="consumption" value="<?= $invoice  -> consommation?>" required>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <div class="input-group">Amount</div>
                            <input type="number" disabled class="form-control" placeholder="consumption" id="consumption" name="consumption" value="<?= $invoice  -> montantConsommation?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <div class="input-group">Paid</div>
                            <input type="number" class="form-control" placeholder="money who give" id="amountPaid" name="amountPaid" value="<?= $invoice  -> montantVerse?>" required disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <div class="input-group">UnPaid</div>
                            <input type="number" disabled class="form-control" id="oldIndex" name="oldIndex"  value="<?= $invoice  -> montantImpaye?>" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex justify-content-between">
                    <div class="float-left">
                        @if($invoice  -> facturePay == false)
                            <a href="{{ url('/admin/paid/'.$invoice->_id .'/client/'.$client -> _id) }}">
                                <button class="btn btn-primary" id="paid" name="connect" type="button">Paid Invoice</button>
                            </a>
                        @endif
                    </div>
                    <div class="float-right">
                        @if($invoice  -> facturePay == false)
                            <button  title="update invoice" type="button" class="btn btn-xs btn-outline-dark pull-right" role="button" data-toggle="modal" data-target="#modal-update-{{ $invoice->_id }}">
                                Update Invoice
                            </button>
                        @endif
                        <a href="/admin/home">
                            <a class="ml-2 btn btn-primary" type="button" href="{{ url('/admin/print/'.$invoice->_id) }}">Print to pdf</a>
                            <button class="btn btn-secondary ml-2 back" type="button">Cancel</button>
                        </a>
                    </div>
                </div>
            </form>
            @endif

            @if($show == true)
            <form id="paidInvoice" action="{{url('/admin/paid')}}" method="post" role="form" class="col-lg-8 offset-lg-2">
                {{csrf_field()}}
                <div class="form-group mb-3">
                    <div class="input-group">Personnel</div>

                    <select name="idClient" id="idClient" class="form-control" disabled>
                        <option value={{$client -> _id}}>{{ $client -> name }}</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-3" hidden>
                            <div class="input-group">Id Invoice</div>
                            <input type="text" class="form-control" placeholder="idInvoice" id="idInvoice" name="idInvoice" value="<?= $invoice ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <div class="input-group">Enter Amount Paid</div>
                            <input type="number" class="form-control" placeholder="amount" id="amount" name="amount" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex justify-content-end">
                    <button class="btn btn-primary" id="connect" name="connect" type="submit">Paid Invoice</button>
                    <button class="btn btn-secondary ml-2 back" id="showDetail" type="button"><a href="admin/consumption-that-are-unpaid">Cancel</a></button>
                </div>
            </form>
            @endif

            <div class="modal fade" tabindex="-1" id="modal-update-{{ $invoice->_id }}" role="dialog" aria-labelledby="mediumDeleteModalLabel" data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <section>
                                Update Invoice
                            </section>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="updateInvoice"  action="/admin/facture/{{$invoice->_id}}"  method="put" role="form" class="col-lg-8 offset-lg-2">
                                @csrf
                                {{method_field('put')}}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3" hidden>
                                            <div class="input-group">Id Invoice</div>
                                            <input type="text" class="form-control" placeholder="idInvoice" id="idInvoice" name="idInvoice" value="<?= $invoice ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <div class="input-group">New index</div>
                                            <input type="number" class="form-control" placeholder="new index" id="newIndex" name="newIndex" value="<?= $invoice  -> newIndex?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <div class="input-group">Date of spicy</div>
                                            <input type="text" class="form-control" id="dateSpicy" name="dateSpicy" placeholder="Date of spicy" value="<?= date('d-m-Y ', strtotime($invoice  -> dateReleveNewIndex))?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <div class="input-group">Paid</div>
                                            <input type="number" class="form-control" placeholder="money who give" id="amountPaid" name="amountPaid" value="<?= $invoice  -> montantVerse?>" required disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex justify-content-end">
                                    <button class="btn btn-primary" id="connect" name="connect" type="submit">Update Invoice</button>
                                    <button class="btn btn-secondary ml-2 back" id="showDetail" type="button">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$('.back').on('click', function(){
    history.back();
    // admin/consumption-that-are-unpaid
});

</script>
@stop
