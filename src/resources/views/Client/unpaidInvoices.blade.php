@extends('Client.layout.default')
    @section('title', 'Unpaid Invoices')
    @section('nav')
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home">
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
        <li class="nav-item active">
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

            @if(Session::has('message'))
                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
                    {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h1>
                <i class='bx bx-grid-alt'></i>
                <span class="nav_name">Invoice Unpaid</span>
            </h1>

            <?php
                $alltoken = $_COOKIE['token'];
                $alltokentab = explode(';', $alltoken);
                $token = $alltokentab[0];
                $tokentab = explode('=',$token);
                $tokenVal = $tokentab[1];
                $Authorization = 'Bearer '.$tokenVal;
            ?>

            <form style="float: right" hidden>
                <input type="text" value="<?php echo $Authorization?>" id="authorization">
            </form>

            <!-- Default Card Example -->
            <?php
                $lengthPaid = count($data['result']);
                for ($i=0; $i < $lengthPaid; $i++) {
            ?>
                <div class="card mb-4 containter-fluid">
                    <div class="card-header row col-lg-12">
                        <div class="col-md-6 col-lg-6">
                            <?php
                                $datesb = $data['result'][$i]['facture']['createdAt'];
                                echo (substr($datesb, 0, 10));
                            ?>
                        </div>
                        <div class="col-md-2 col-lg-2 offset-md-2">
                            <a href="/user/get/<?php echo $data['result'][$i]['facture']['_id'] ?>" class="btn btn-primary">Overview</a>
                        </div>
                        {{-- <div class="col-md-2 col-lg-2">
                            <a href="javascript:;" class="btn btn-success btnapp" data-unpaid="<?= $data['result'][$i]['facture']['montantImpaye'] ?>" data-id="<?= $data['result'][$i]['facture']['_id'] ?>">Paid/Advance</a>
                        </div> --}}
                    </div>
                    <div class="card-body row">
                        <div class="col-lg-3 col-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Index (New - Old)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['result'][$i]['facture']['newIndex'] ?> - <?= $data['result'][$i]['facture']['oldIndex'] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Consumption M<sup>3</sup></div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['result'][$i]['facture']['consommation'] ?> m<sup>3</sup></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-4">
                            <div class="card shadow h-100 py-2 bg-danger">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Unpaid</div>
                                            <div class="h5 mb-0 font-weight-bold text-white" id="unpaid"><?= $data['result'][$i]['facture']['montantImpaye'] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                amount of consumption</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['result'][$i]['facture']['montantConsommation'] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
                    # code...
                }
            ?>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Paid/Advance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form name="formulaire" method="PUT" action="/paidfact">
                            <input type="text" class="form-control" id="modalId" name="modalId" hidden>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">$</span></div>
                                <input type="number" class="form-control" id="modalUnpaid" name="modalUnpaid" disabled>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">$</span></div>
                                <input type="number" class="form-control" id="montant" name="montant" placeholder="Montant" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success validate">Paid</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>


@stop

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).on('click', '.btnapp', function() {
        var id = $(this).attr('data-id');
        var unpaid = $(this).attr('data-unpaid');
        alert(unpaid);
        document.getElementById("modalUnpaid").value = unpaid;
        document.getElementById("modalId").value = id;
        $('#alertM').modal('hide');
        $('#exampleModal').modal('show');
    });
</script>
