@extends('Client.layout.default')
    @section('title', 'Dashboard')
        @section ('nav')

            <nav class="nav">
                <div>
                    <a href="#" class="nav_logo">
                        <i class='bx bx-layer nav_logo-icon'></i>
                        <span class="nav_logo-name">
                            Christian Kepya
                        </span>
                    </a>

                    <div class="nav_list">
                        <a href="/home" class="nav_link active" data-bs-toggle="tooltip" data-bs-placement="right" title="Home">
                            <i class='bx bx-grid-alt nav_icon'></i>
                            <span class="nav_name">Home</span>
                        </a>

                        <a href="/user" class="nav_link" data-bs-toggle="tooltip" data-bs-placement="right" title="Profile">
                            <i class='bx bx-user nav_icon'></i>
                            <span class="nav_name">User</span>
                        </a>
                        
                        <a href="/invoice" class="nav_link" data-bs-toggle="tooltip" data-bs-placement="right" title="Bills">
                            <i class='fas fa-file-invoice-dollar nav_icon'></i>
                            <span class="nav_name">Invoice</span>
                        </a>
                        
                        <a href="/receipt" class="nav_link" data-bs-toggle="tooltip" data-bs-placement="right" title="Receipt">
                            <i class='fas fa-receipt nav_icon'></i>
                            <span class="nav_name">Receipt</span>
                        </a>

                        <a href="/message" class="nav_link" data-bs-toggle="tooltip" data-bs-placement="right" title="Message">
                            <i class='bx bx-message-square-detail nav_icon'></i>
                            <span class="nav_name">Messages</span>
                        </a>
                    </div>
                </div>

                <section class="nav_notify_button" id="notify">
                    <i class='bx bx-bell nav_icon not'>
                        <i class='bx bx-radio-circle bx-burst nav_notify_radio_position' style='color:#ffe200' id="bx1"></i>
                        <i class='bx bxs-circle nav_notify_circle_position' style='color:#ffe200' id="bx"></i>
                    </i>
                    <span class="nav_name not" id="not">Notification</span>
                </section>

                <section class="hide_menu_account card" id="sms">
                    <section class="card-header espace">
                        <span class="font-12 col-xs-6 font-semi-bold mr-4">Nouvelles notifications</span>
                        <a class="mark-notification-read col-xs-6 text-right font-12 font-semi-bold" href="javascript:;"> Marquer comme lu</a>
                    </section>
                    <a href="google.com" class="noti pl-4 pr-4 pt-3 pb-3">
                        <div class="user_i"><i class='bx bx-user bxUser'></i></div>
                        <div class="forage">
                            <div>Bienvenue sur ForageManager</div>
                            <div style="font-size: 12px;">il y'a deux minute</div>
                        </div>
                    </a>
                    <hr>
                </section>

                <a href="#" class="nav_link">
                    <i class='bx bx-log-out nav_icon'></i>
                    <span class="nav_name">Log out</span>
                </a>
            </nav>

        @stop
        @section('content')
            <h1>                            
                <i class='bx bx-grid-alt'></i>
                <span class="nav_name">Dashboard</span>
            </h1>
            <section class="card-deck card_group">
                <section class="card single_card">
                    <section class="noti">
                        <div class="user_i"><i class='bx bx-receipt bx_user'></i></div>
                        <div class="forage" style="text-align: right;align-items: flex-end;align-content: flex-end;">
                            <div>Total Factures</div>
                            <div style="font-size: 12px;">0</div>
                        </div>
                    </section>
                </section>
                <section class="card single_card">
                    <section class="noti">
                        <div class="user_i"><i class='bx bx-money bx_user'></i></div>
                        <div class="forage" style="text-align: right;align-items: flex-end;align-content: flex-end;">
                            <div>Total Factures payées</div>
                            <div style="font-size: 12px;">0</div>
                        </div>
                    </section>
                </section>
                <section class="card single_card">
                    <section class="noti">
                        <div class="user_i"><i class="fas fa-hand-holding-usd bx_user"></i></div>
                        <div class="forage" style="text-align: right;align-items: flex-end;align-content: flex-end;">
                            <div>Total factures non payées</div>
                            <div style="font-size: 12px;">0</div>
                        </div>
                    </section>
                </section>
                <section class="card single_card">
                    <section class="noti">
                        <div class="user_i"><i class="fas fa-clipboard-list bx_user"></i></div>
                        <div class="forage" style="text-align: right;align-items: flex-end;align-content: flex-end;">
                            <div>Total Prets demandés</div>
                            <div style="font-size: 12px;">0</div>
                        </div>
                    </section>
                </section>
            </section>

            <section class="card-deck card_information_group mt-4">
                <section class="card card_hide_border">
                    <section class="card-header">Facture en cours de Paiement</section>
                    <section class="card-body">
                        liste des facture qui ne sont pa encore totalement payées avec des liens pour payer cela
                    </section>
                </section>

                <section class="card card_hide_border">
                    <section class="card-header">Notice Board</section>
                    <section class="card-body">
                        Liste des actualités sur son compte
                    </section>
                </section>
            </section>

            <section class="card-deck card_information_group mt-4">
                <section class="card card_hide_border">
                    <section class="card-header">Information sur son compte</section>
                    <section class="card-body">
                        <p>Nom Propriétaire : Christian kepya</p>
                        <p>Numero Compteur : UIX2024</p>
                        <p>Prix de souscription : 50000f</p>
                        <p>Date : 25 juin 2019</p>
                        <p>Nom du propriétaire : Sipof</p>
                    </section>
                </section>

                <section class="card card_hide_border">
                    <section class="card-header">Liste des services disponibles</section>
                    <section class="card-body">
                        
                    </section>
                </section>
            </section>  
@stop
        