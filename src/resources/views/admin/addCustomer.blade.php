@extends('admin.layouts.skeleton')
@section('title', 'Add a Customer')
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
        <li class="nav-item active">
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

    <div class="card mb-4">
        <div class="card-header">
            Add a customer
        </div>
    <div class="card-body">
        <div class="container">
            <!-- form validation -->

            @if(Session::has('message'))
                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
                    {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

             <form method="post" action="/admin/customer/addCustomer/store" class="col-lg-8 offset-lg-2" enctype="multipart/form-data">
                @csrf

                <div class="part1" style="display:flex;">
                    <span class="text-danger text-lg mr-2" style="display:flex;align-items:center;justify-content:center;">*</span>
                    <span>Customer Informations</span>
                </div>
                <div class="form-group mt-2">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <input type="number" class="form-control @error('ref_client') is-invalid @enderror" placeholder="ref_ID" id="ref_client" name="ref_client" value="@if(isset($nbrCl)){{$nbrCl+1}}@else{{ old('ref_client') }}@endif" required>
                        </div>
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="full name" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row" id="addPhone">
                        <input type="hidden" name="nbrePhone" id="nbrePhone"  value="1">
                        <div class="form-group col-md-1">
                            <i class="fas fa-plus ml-2 btn-primary" class="" id="plusPhone" style="display:flex; align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                        </div>
                        <div class="form-group col-md-11" id="form0">
                            <input type="number" class="form-control @error('phone0') is-invalid @enderror" placeholder="phone number" id="phone0" name="phone0" value="{{ old('phone0') }}">
                            @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-1" id="minusform0" style="display:none;">
                            <i class="fas fa-minus ml-3 btn-primary" class="" id="minusPhone" style="display:flex;align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                        </div>
                    </div>
                </div>

                <div class="part2">Sites</div>
                <div class="form-group mt-2" id="addHomeMeter">
                    <input type="hidden" name="blocSites" id="blocSites" value="1">
                    <div class="form-row">
                        <div class="form-group col-md-1">
                            <i class="fas fa-plus ml-2 btn-primary" id="plusSites" style="display:flex; align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                        </div>
                        <div class="form-group col-md-3" id="form1">
                            <input type="text" class="form-control" placeholder="Meter_ID" id="meter0" name="meter0" value="{{ old('meter0') }}">
                        </div>
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" placeholder="location" id="home0" name="home0" value="{{ old('home0') }}">
                        </div>
                        <div class="form-group col-md-1" id="minusform1" style="display:none;">
                            <i class="fas fa-minus ml-3 btn-primary" id="minusSites" style="display:flex; align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                        </div>
                    </div>
                </div>

                <div class="part3">Subscription</div>
                <div class="form-group mt-2">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="date" class="form-control" id="subs_date" name="subs_date" value="{{ old('subs_date')}}" placeholder="Date">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" class="form-control" id="subs_amount" name="subs_amount" value="{{ old('subs_amount')}}" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" placeholder="Observation" id="observation" name="observation" value="{{ old('observation') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-2">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row float-right mt-3">
                    <a href="#">
                        <button class="btn btn-primary" name="submit" type="submit">Register</button>
                    </a>
                    <a href="/admin/customer">
                        <button class="btn btn-secondary ml-2" type="button">Cancel</button>
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
    var nbrePhone = 0;
    var blocSites = 0;

    $("#plusPhone").on("click", function(){
        nbrePhone+=1;
        $("#addPhone").append(
            "<div class='form-group col-md-10' style='margin-left:60px;' id='input_phone_"+nbrePhone+"'>"+
                "<input type='number' class='form-control @error('phone"+nbrePhone+"') is-invalid @enderror' placeholder='phone number' id='phone"+nbrePhone+"' name='phone"+nbrePhone+"' value='{{ old('phone"+nbrePhone+"') }}'>"+
                "@error('phone"+nbrePhone+"')"+
                        "<div class='invalid-feedback'>{{ $message }}</div>"+
                "@enderror"+
            "</div>"
        );
        $("#form0").removeClass('col-md-11').addClass('col-md-10');
        $('#minusform0').css('display', 'flex');
        $("#nbrePhone").val(nbrePhone+1);
    });

    $('#minusPhone').on("click",function(){
        $("#input_phone_"+nbrePhone).remove();
        nbrePhone-=1;
        if(nbrePhone==0){
            $("#form0").removeClass('col-md-10').addClass('col-md-11');
            $('#minusform0').css('display', 'none');
        }
        $("#nbrePhone").val(nbrePhone+1);
    });

    $("#plusSites").on("click", function(){
        blocSites+=1;
        $("#addHomeMeter").append(
                "<div class='form-row' id='blocSites"+blocSites+"'>"+
                    "<div class='form-group col-md-2' style='margin-left:60px;'>"+
                        "<input type='text' class='form-control' placeholder='Meter_ID' id='meter"+blocSites+"' name='meter"+blocSites+"' value='{{ old('meter"+blocSites+"') }}'>"+
                    "</div>"+
                    "<div class='form-group col-md-8'>"+
                        "<input type='text' class='form-control' placeholder='location' id='home"+blocSites+"' name='home"+blocSites+"' value='{{ old('home"+blocSites+"') }}'>"+
                    "</div>"+
                "</div>"
        );
        $("#form1").removeClass('col-md-3').addClass('col-md-2');
        $('#minusform1').css('display', 'flex');
        $("#blocSites").val(blocSites+1);
    });

    $('#minusSites').on("click",function(){
        $("#blocSites"+blocSites).remove();
        blocSites-=1;
        if(blocSites==0){
            $("#form1").removeClass('col-md-2').addClass('col-md-3');
            $('#minusform1').css('display', 'none');
        }
        $("#blocSites").val(blocSites+1);
    });

</script>

<script>
    // $( "#setLocation" ).on( "click", function() {

    //     if($("#setLocation").is(':checked'))

            // checked

    //        function myPosition(position) {
    //         $('#lat').val(position.coords.latitude);
    //         $('#lng').val(position.coords.longitude);
    //        }

    //        function errorPosition(error) {
    //           var info = "Error while getting your location : ";

    //           switch(error.code) {
    //               case error.TIMEOUT:
    //                   info += "Timeout !";
    //               break;
    //               case error.PERMISSION_DENIED:
    //               info += "Permission denied";
    //               break;
    //               case error.POSITION_UNAVAILABLE:
    //                   info += "Your location could not be determined";
    //               break;
    //               case error.UNKNOWN_ERROR:
    //                   info += "Unknown Error";
    //               break;
    //           }

    //           alert(info);
    //        }

    //       if(navigator.geolocation)
    //         navigator.geolocation.getCurrentPosition(myPosition,errorPosition,{enableHighAccuracy:true});

    //     else
    //         //unchecked
    //         var message = "unchecked";
    // });
</script>



@stop
