@extends('admin.layouts.skeleton')
@section('title', 'Invoice Information')
@section('nav')
        <li class="nav-item active">
            <a class="nav-link" href="/admin/home">
            <i class="fas fa-home"></i>
            <span>Home</span></a
            >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Information</div>

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
<div
class="d-sm-flex align-items-center justify-content-between mb-4"
>
    <h1 class="h3 mb-0 text-gray-800">Invoices Information</h1>

    </div>
        <section class="main">
            <p class="h5">Please enter the information about the invoices that you want to create</p>
            <form action="/admin/addInvoice" method="post" class="m-5">
                @csrf
                <section  class="form-group mb-3 d-flex justify-content-center align-items-center text-center">
                    <input type="number" class="form-control mr-2" id="day" name="day" placeholder="day"
                    required style="height: 80px; width: 200px; font-size: x-large;border-radius: 15px;" min="1" max="31">
                    <span class="mr-2 mt-auto" id="span_day" style="font-size: 60px; align-items: center;">:</span>
                    <input type="number" class="form-control mr-2" id="month" name="month" min="1" max="12"
                    required style="height: 80px; width: 200px; font-size: x-large;border-radius: 15px;" placeholder="month">
                    <span class="mr-2" style="font-size: 60px; align-items: center;">:</span>
                    <input type="number" class="form-control mr-2" id="year" name="year" min="1940" placeholder="year"
                    required style="height: 80px; width: 200px; font-size: x-large;border-radius: 15px;">
                </section>
                <section class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="submit" style="font-size: x-large;">submit</button>
                </section>
            </form>
            <script>
                let month = document.getElementById('month');
                let year = document.getElementById('year');
                let day = document.getElementById('day');
                let span_day = document.getElementById('span_day');
                let date = new Date();
                year.value = date.getFullYear();
                month.value = date.getMonth() + 1;
                day.value = date.getDate();
                day.hidden = true;
                span_day.hidden = true;
            </script>
        </section>
    </div>
</div>
@stop

