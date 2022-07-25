@extends('admin.layouts.skeleton')
@section('title', 'Add an Administrator')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
crossorigin=""/><!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>
<style>
    .displayError{
        color : red;
        font-size: 15px;
    }
    #mapid {
        height: 75%;
    }
    /* Optional: Makes the sample page fill the window. */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>
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
        <li class="nav-item">
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
        <li class="nav-item active">
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
<?php 
    $alltoken = $_COOKIE['token'];
    $alltokentab = explode(';', $alltoken);
    $token = $alltokentab[0];
    $tokentab = explode('=',$token);
    $tokenVal = $tokentab[1];
    $Authorization = 'Bearer '.$tokenVal;   
?>
<div class="card mb-4">
    <div class="card-header">
        Map
        <form style="float: right" hidden>
            <input type="text" value="<?php echo $Authorization?>" id="authorization">
            <button type="submit" class="btn btn-primary">Actuliser</button>
        </form>
    </div>
</div> 
<div id="mapid"></div>
<script src="/js/jquery-3.6.0.min.js"></script>
<script type='text/javascript'> 
    let client = [];
    let NumClient;
    let admin;
    const autho = document.getElementById('authorization').value;
    
    var settings = {
        "url": "http://172.17.0.2:4000/admin/auth/getClient",
        "method": "GET",
        "timeout": 0,
        "headers": {
            "Authorization": autho
        },
    };
    $.ajax(settings).done(function (response) {
        for (let j = 0; j < response.result.length; j++) {
            client.push(response.result[j]);   
        }
        NumClient = response.result.length;
    });
    
    var adminS = {
        "url": "http://172.17.0.2:4000/admin/auth/getAdminByToken",
        "method": "GET",
        "timeout": 0,
        "headers": {
            "Authorization": autho
        },
    };
    $.ajax(adminS).done(function (response) {
        admin = response.result
        console.log(response);
    });
    
    $( document ).ready(function() {
        var mymap = L.map('mapid').setView([5.48464445289128, 10.442020316114435], 16);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'sk.eyJ1Ijoic2lwb2YyNCIsImEiOiJja3JqbjVlYjUwNDZyMnVwY2s4NjlnbmhqIn0.4ZJUEirSuUiu-ywAHeJ3rQ'
        }).addTo(mymap);

        var greenIcon = L.icon({
            iconUrl: '/img/pointeur3.png',
            iconSize:     [32, 32], 
            iconAnchor:   [22, 94], 
            popupAnchor:  [-3, -76] 
        });
        var adminIcon = L.icon({
            iconUrl: '/img/pointeur1.png',
            iconSize:     [38, 45], // size of the icon
            shadowSize:   [50, 64], // size of the shadow
            iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
            shadowAnchor: [4, 62],  // the same for the shadow
            popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        L.marker([admin.localisation.latitude, admin.localisation.longitude], {icon: adminIcon}).addTo(mymap).bindPopup("<h4>Admin</h4>").openPopup();
        
        for (let i = 0; i < NumClient; i++) {
            if (client[i].localisation.latitude && client[i].localisation.longitude) {
                const description = function () {
                    if (client[i].localisation.description == undefined) {
                        return null
                    } else {
                        return client[i].localisation.description
                    }
                }
                L.marker([client[i].localisation.latitude, client[i].localisation.longitude]).addTo(mymap).bindPopup(client[i].localisation.description).openPopup();
            }
            
        }
        
    });
        
</script>
<!-- Make sure you put this AFTER Leaflet's CSS -->
@stop 