@extends('admin.layouts.skeleton')
@section('title', 'Invoice')
@section('nav')
<style>
    .person-img {
        border-radius: 50%;
        border-style: solid;
        margin-bottom: 1rem;
        width: 70px;
        height: 70px;
        object-fit: cover;
        border: 4px solid var(--clr-grey-8);
        box-shadow: var(--dark-shadow);
        transform: translateY(-30px)
    }
</style>
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
        <li class="nav-item active">
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
@if(Session::has('message'))
    <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
        {{ Session::get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(Session::has('messageErr'))
    <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
        {{ Session::get('messageErr') }}<a href='/admin/profile#settings'> the general settings</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="py-3 d-flex flex-row align-items-center justify-content-between ">
    <h4 class="m-0 font-weight-bold text-primary">
        Add Invoices
    </h4>

    <form action="/admin/facture/search_custumer" novalidate method="post" enctype="multipart/form-data" class="form-horizontal row-border">
        <div class="col-sm-12">
            <div class="row">
                @csrf
                <div class="col-9">
                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Name of user">
                </div>
                <div class="col-2">
                    <button class="btn-sm btn-success h-100" type="submit" name="search" id="search"><i class="fas fa-search"></i></button>
                </div>
            </div>

        </div>
    </form>

</div>
<div class="container-fluid mt-5" id="users">
    <section class="row">

        <?php if($userHasInvoices != null){
                foreach ($userHasInvoices as $userHasInvoice){
            ?>

            <div class="col-md-6 col-lg-4 mb-2 mt-3">
                <div class="w-75 d-inline-block" style="height:200px;border-radius: 10px; border-color: black;border-style: solid;background-color: rgba(0,0,255,.1)">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            @if ($userHasInvoice['user']->profileImage != "noPath")
                                <img src="{{url('storage/'.$userHasInvoice['user']->profileImage)}}" class="mt-2 mb-2 person-img" alt="illisible">
                            @else
                                <img src="/img/undraw_profile.svg" class="mt-2 mb-2 person-img" alt="illisible">
                            @endif
                        </div>
                        <div class="col-12">
                            <h5 class="ml-2 d-flex justify-content-center">{{$userHasInvoice['user']->name}}</h5>
                            <h6 class="ml-2 d-flex justify-content-center">{{$userHasInvoice['user']->IdCompteur}}</h6>
                            <a href="#modal{{$userHasInvoice['user']->_id}}" class="d-inline-flex btn btn-primary ml-4" style="border-radius: 10px; color:white" user=<?= $userHasInvoice['user']->_id ?> data-toggle="modal" data-target="#modal{{$userHasInvoice['user']->_id}}" class="btn btn-sm bg-primary addInvoiceModal ml-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add Invoice">
                                Add Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" id="modal{{$userHasInvoice['user']->_id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Invoice </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form data-toggle="validator" action="{{route('addOneInvoice')}}" method="post" class="col-lg-8 offset-lg-2">
                                @csrf
                                {{method_field('post')}}
                                <div class="form-group mb-3" id="b_userId" hidden>
                                    <div class="input-group">User Id</div>
                                    <input type="text" class="form-control" value="{{$userHasInvoice['user']->_id}}" placeholder="user Id" name="userId" id="userId">
                                </div>
                                <div class="form-group mb-3" id="b_date" hidden>
                                    <div class="input-group">Date</div>
                                    <input type="date" class="form-control" value="<?= $date?>" placeholder="Date" id="date" name="date">
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group">New index</div>
                                    <input type="number" min="0" class="form-control" placeholder="new index" id="newIndex" name="newIndex" required>
                                </div>
                                <?php if($userHasInvoice['hasInvoice'] == false) { ?>
                                    <div class="form-group mb-3" id="b_oldIndex">
                                        <div class="input-group">Old index</div>
                                        <input type="number" min="0" class="form-control" placeholder="old index" id="oldIndex" name="oldIndex" value="0">
                                    </div>
                                <?php } ?>
                                <div class="row form-group float-right">
                                    <button type="submit" class="btn btn-primary" id="addInvoice" name="addInvoice"> Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php   }
            }else{
        ?>
        <?php } ?>
    </section>
</div>



<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>

<script>
    $("body").on('click','.addInvoiceModal',function(event){

        // event.preventDefault();

        var id = $(this).attr('user');
        let b_date = document.getElementById("b_date");

        // var date = new Date(<?php echo json_encode($date); ?>);
        // let formatDate = date.getFullYear();

        // if(date.getMonth() + 1 < 10) {
        //     formatDate = formatDate + "-0" + (date.getMonth() + 1);
        // } else {
        //     formatDate = formatDate + "-" + (date.getMonth() + 1);
        // }

        // if (date.getDate() < 10 ) {
        //     formatDate = formatDate + "-0" + date.getDate();
        // } else {
        //     formatDate = formatDate + "-" + date.getDate();
        // }
        // //b_date.hidden = true;

        // $('#userId').val(id);
        // $('#date').val('' + formatDate.toString());

    });


</script>

@stop
