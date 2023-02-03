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
@if(Session::has('message'))
    <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
        {{ Session::get('message') }}
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
                <div class="col-8">
                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Name of user">
                </div>
                <div class="col-2">
                    <button class="btn-sm btn-success h-100" type="submit" name="search" id="search"><i class="fas fa-search"></i></button>
                </div>
                <div class="col-2">
                    <button class="btn-sm btn-warning h-100" type="submit" name="reload" id="reload"><i class="fas fa-reload"></i></button>
                </div>
            </div>

        </div>
    </form>

</div>
<div class="container-fluid mt-5" id="users">
    <section class="row">

        <?php if($invoices ?? '' != null && count($invoices ?? '') > 0 ){
                foreach ($invoices ?? '' as $invoice){
            ?>

            <div class="col-md-6 col-lg-4 mb-2 mt-3">
                <div class="w-75 d-inline-block" style="height:200px;border-radius: 10px; border-color: black;border-style: solid;background-color: rgba(0,0,255,.1)">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            @if ($invoice->user->profileImage != "noPath")
                                <img src="{{url('storage/'.$invoice->user->profileImage)}}" class="mt-2 mb-2 person-img" alt="illisible">
                            @else
                                <img src="/img/undraw_profile.svg" class="mt-2 mb-2 person-img" alt="illisible">
                            @endif
                        </div>
                        <div class="col-12">
                            <h5 class="ml-2 d-flex justify-content-center">CLIENT : {{$invoice->user->customerReference}}</h5>
                            <h6 class="ml-2 d-flex justify-content-center">{{$invoice->user->name}}</h6>
                            <a href="#modal{{$invoice->user->_id}}" class="d-inline-flex btn btn-primary ml-4" style="border-radius: 10px; color:white" user=<?= $invoice->user->_id ?> data-toggle="modal" data-target="#modal{{$invoice->user->_id}}" class="btn btn-sm bg-primary addInvoiceModal ml-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add Invoice">
                                Add Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" id="modal{{$invoice->user->_id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="text" class="form-control" value="{{$invoice->user->_id}}" placeholder="user Id" name="userId" id="userId">
                                </div>
                                <div class="form-group mb-3" id="b_date" hidden>
                                    <div class="input-group">Date</div>
                                    <input type="date" class="form-control" value="<?= $date?>" placeholder="Date" id="date" name="date">
                                </div>

                                <div class="form-group mb-3" id="b_idCompteur">
                                    <div class="input-group">Meters</div>
                                    <select id="meter"  name="meter" class="form-control" aria-label="multiple select" required>
                                        <option value="">Choose a meter</option>
                                        @foreach($invoice->idCompteur as $meter)
                                            <option value="{{$meter}}">{{$meter}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group">New index</div>
                                    <input type="number" min="0" class="form-control" placeholder="new index" id="newIndex" name="newIndex" required>
                                </div>
                                <?php if($invoice->hasAtLeastOneInvoice == false) { ?>
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

    <section class="row">
        <section class="page-size">

        </section>
        <section class="page">

        </section>
    </section>
    <div class="flex d-flex align-items-center justify-content-between mb-1">
        <form action="{{url('/admin/search_invoices')}}" method="post" role="form">
            @csrf
            <div class="flex d-flex align-items-center">
                entries :

                <select class="form-control ml-2" style="width: 70px;" id="select_page_size" name="select_page_size" value="<?= $page_size ?>">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
                <input type="submit" name="paginate_invoice" id="paginate_invoice" placeholder="Show" class="ml-1 btn btn-primary">
            </div>
        </form>

        @if($isSearch == false)
            <div style="height: 100%; border: 1px; border-style: solid; border-radius: 5px;">
                @if($hasPrevPage == true)
                    <a href="{{ url('/admin/consumption-that-are-paid/page/'.$previous_page.'/size/'.$page_size) }}">
                        <button class="btn bg-white"> <i class="fas fa-angle-double-left" style="color: blue;"></i> </button>
                    </a>
                    <a href="{{ url('/admin/consumption-that-are-paid/page/'.$previous_page.'/size/'.$page_size) }}">
                        <button class="btn bg-white" style="color: blue;border-radius: 0px;">{{$previous_page}}</button>
                    </a>
                @else
                    <button disabled class="btn bg-white" style="border-radius: 0px;"> <i class="fas fa-angle-double-left"></i> </button>
                @endif
                <a href="{{ url('/admin/consumption-that-are-paid/page/'.$page_en_cours.'/size/'.$page_size) }}">
                    <button class="btn btn-primary" style="width: 40px;border-radius: 0px;" name="page_search" id="page_search">{{$page_en_cours}}</button>
                </a>
                @if($hasNextPage == true)
                    <a href="{{ url('/admin/consumption-that-are-paid/page/'.$next_page.'/size/'.$page_size) }}">
                        <button class="btn" style="width: 40px;border-radius: 0px; color: black;" name="page_search" id="page_search">{{$next_page}}</button>
                    </a>
                    <a href="{{ url('/admin/consumption-that-are-paid/page/'.$next_page.'/size/'.$page_size) }}">
                        <button class="btn bg-white" style="width: 40px;border: none;border-radius: 0px;"> <i class="fas fa-angle-double-right" style="color: blue;"></i> </button>
                    </a>
                @else
                    <button disabled class="btn bg-white" style="width: 40px;border-radius: 0px;"> <i class="fas fa-angle-double-right"></i> </button>
                @endif
            </div>
        @else
            <form style="height: 100%; border: 1px; border-style: solid; border-radius: 5px;" action="{{url('/admin/search_invoices_pagination')}}" method="post" role="form">
                <input type="number" value="<?= $page_en_cours ?>" name="page" id="page" placeholder="page" title="page" hidden class="form-control ml-2"/>
                <input type="number" value="<?= $page_size ?>" name="page_size" id="page_size" placeholder="page_size" title="page_size" hidden class="form-control ml-2"/>
                <input type="text" value="<?= $username ?>" name="username" id="username" placeholder="Username" title="Username" class="form-control ml-2" hidden/>

                @if($hasPrevPage == true)
                    <button class="btn bg-white" name="previous_page" id="previous_page"  type="submit"> <i class="fas fa-angle-double-left" style="color: blue;"></i> </button>
                    <button class="btn bg-white" name="previous_page" id="previous_page" style="color: blue;border-radius: 0px;" type="submit">{{$previous_page}}</button>
                @else
                    <button disabled class="btn bg-white" style="border-radius: 0px;" type="button"> <i class="fas fa-angle-double-left"></i> </button>
                @endif
                    <button class="btn btn-primary" style="width: 40px;border-radius: 0px;"  name="current_page" id="current_page">{{$page_en_cours}}</button>
                @if($hasNextPage == true)
                    <button class="btn" name="next_page" id="next_page" style="width: 40px;border-radius: 0px; color: black;" type="submit">{{$next_page}}</button>
                    <button class="btn bg-white" name="next_page" id="next_page" style="width: 40px;border: none;border-radius: 0px;" type="submit"> <i class="fas fa-angle-double-right" style="color: blue;"></i> </button>
                @else
                    <button disabled class="btn bg-white" style="width: 40px;border-radius: 0px;"  type="button"> <i class="fas fa-angle-double-right"></i> </button>
                @endif
            </form>
        @endif
    </div>
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
