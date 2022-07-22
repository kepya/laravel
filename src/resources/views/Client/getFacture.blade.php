@extends('Client.layout.default')
    @section('title', 'Invoices Paid')
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
        <div class="sidebar-heading">Informations</div>

        <!-- Nav Item - consumption -->
        <li class="nav-item ">
            <a class="nav-link collapsed"  href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Buget</span>
            </a>
            <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities1" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Buget</h6>
                    <a class="collapse-item" href="/budget-stat" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices paid">statistics</a>
                    <a class="collapse-item" href="/budget-detail" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices unpaid">Detail</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Invoice -->
        <li class="nav-item active">
            <a class="nav-link collapsed"  href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices">
                <i class="fas fa-money-bill-alt"></i>
                <span>Invoice</span>
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
            <div class="col-md-6 col-lg-6">
                <h1>
                    <i class='bx bx-grid-alt'></i>
                    <span class="nav_name">Invoice</span>
                </h1>
            </div>
            <div class="col-md-2 col-lg-2 offset-md-5">
                <?php if($invoice['result']['facturePay'] == true) { ?>
                    <a href="/user/print/<?php echo $invoice['result']['_id'] ?>" class="btn btn-primary btnapp">Print to pdf</a>
                <?php } ?>
            </div>

            <div class="card mb-4 containter-fluid">
                <table cellspacing="0" style="border-style: solid; border-width: 1px">
                    <tr>
                        <td colspan="9" align="center">Facture d'eau</td>
                    </tr>
                    <tr>
                        <td colspan="9" align="left">Tel: <?=$admin['result']['phone']?></td>
                    </tr>
                    <tr>
                        <td colspan="7"></td>
                        <td class="border">Dernier Index <br> relevé le :</td>
                        <td class="border" align="center"><?=date("d.m.y",strtotime($invoice['result']['dateReleveNewIndex']))?></td>
                    </tr>
                    <tr>
                        <td colspan="9" align="center">Déposé le :</td>
                    </tr>
                    <tr>
                        <td colspan="7"></td>
                        <td class="border">Date limite <br> de paiement :</td>
                        <td class="border" align="center"><?=date("m.d.y",strtotime($invoice['result']['dataLimitePaid']))?></td>
                    </tr>
                    <tr>
                        <td colspan="9" align="center">Mois: <?=date("F Y")?> <br> Destinataire: <?=$client['result']['name']?> <br> Localisation: <?=$client['result']['localisation']['description']?></td>
                    </tr>
                    <tr>
                        <td rowspan="2" align="center" class="border">N° <br> Compteur </td>
                        <td colspan="2" align="center" class="border">Index</td>
                        <td rowspan="2" align="center" class="border">Consommation <br> M3 </td>
                        <td rowspan="2" align="center" class="border">Prix <br> Unitaire </td>
                        <td rowspan="2" align="center" class="border">Montant <br> Consommation </td>
                        <td rowspan="2" align="center" class="border">Frais <br> Entretein </td>
                        <td rowspan="2" align="center" class="border">Impayes </td>
                        <td rowspan="2" align="center" class="border">Montant <br> A Payer </td>
                    </tr>
                    <tr>
                        <td align="center" class="border">Nouvel</td>
                        <td align="center" class="border">Ancien</td>
                    </tr>
                    <tr>
                        <td align="center" class="border"><?=$client['result']['IdCompteur']?></td>
                        <td align="center" class="border"><?=$invoice['result']['newIndex']?></td>
                        <td align="center" class="border"><?=$invoice['result']['oldIndex']?></td>
                        <td align="center" class="border"><?=$invoice['result']['consommation']?></td>
                        <td align="center" class="border"><?=$invoice['result']['prixUnitaire']?></td>
                        <td align="center" class="border"><?php echo ($invoice['result']['montantConsommation']-$invoice['result']['fraisEntretien'])?></td>
                        <td align="center" class="border"><?=$invoice['result']['fraisEntretien']?></td>
                        <td align="center" class="border"><?=$invoice['result']['montantImpaye']?></td>
                        <td align="center" class="border"><?=$invoice['result']['montantConsommation']?></td>
                    </tr>
                    <tr>
                        <td height="8"></td>
                    </tr>
                    <tr>
                        <td class="border" align="center">Montant <br> Versé</td>
                        <td class="border" align="center">Nom et  <br> Signature caissier</td>
                        <td class="border" align="center">Date paiement</td>
                        <td align="center" colspan="6">Mode paiement: Cash ou Orange Money (avec frais de retrait)</td>
                    </tr>
                    <tr>
                        <td class="border" height="30"><?=$invoice['result']['montantVerse']?></td>
                        <td class="border"><?=$admin['result']['name']?></td>
                        <td class="border"></td>
                        <td align="center" colspan="6"></td>
                    </tr>
                </table>
            </div>

@stop
