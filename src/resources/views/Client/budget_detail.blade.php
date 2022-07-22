@extends('Client.layout.default')
    @section('title', 'Consumption')
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
        <li class="nav-item active">
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
        <li class="nav-item ">
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
            <a class="nav-link collapsed"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Log Out" href="/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log out</span>
            </a>
        </li>

@stop
@section('content')
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body row">
            <h4 class="header-title col-md-4 mt-4">Budget</h4>
            <!-- Total invoice which didn't paid -->
            <div class="col-md-4 offset-3">
                <div class="card border-left-info shadow">
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
                                    Total
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php
                                        $lengthPaid = count($data['result']);
                                        $count = 0;
                                        for ($j=0; $j < $lengthPaid; $j++) {
                                            $count += $data['result'][$j]['montantVerse'];
                                        }
                                        echo $count;
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
            <div class="single-table mt-4">
                <div class="table-responsive">
                    <table class="table table-hover progress-table text-center">
                        <thead class="text-uppercase">
                            <tr class="table-primary">
                                <th scope="col">New Index</th>
                                <th scope="col">Old Index</th>
                                <th scope="col">Amount</th>
                                <th scope="col">PU</th>
                                <th scope="col">Maintenance fee</th>
                                <th scope="col">Amount consumption</th>
                                <th scope="col">Penality</th>
                                <th scope="col">Progress</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $lengthPaid = count($data['result']);
                                for ($i=0; $i < $lengthPaid; $i++) {
                                    $EndTranche = count($data['result'][$i]['tranche']);
                                    if ($EndTranche == 0) {
                                        $progression = 0;
                                    } else {
                                        $tranche = $data['result'][$i]['tranche'][$EndTranche-1]['montant'];
                                        $progression = 100/($data['result'][$i]['montantConsommation'] / $tranche);
                                    }


                            ?>
                                <tr>
                                    <td><?= $data['result'][$i]['newIndex'] ?></td>
                                    <td><?= $data['result'][$i]['oldIndex'] ?></td>
                                    <td><?= $data['result'][$i]['consommation'] ?></td>
                                    <td><?= $data['result'][$i]['prixUnitaire'] ?></td>
                                    <td><?= $data['result'][$i]['fraisEntretien'] ?></td>
                                    <td><?= $data['result'][$i]['montantConsommation'] ?></td>
                                    <td><?= $data['result'][$i]['penalty'][0]['montant'] ?></td>
                                    <?php
                                        if ($data['result'][$i]['facturePay'] == true) {
                                            ?>
                                        <td>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-success">Paid</span></td>
                                        <?php
                                        } else {
                                            ?>
                                        <td>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $progression ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td><span class="badge badge-danger">Unpaid</span></td>
                                    <?php
                                        }
                                    ?>

                                </tr>
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
@stop
