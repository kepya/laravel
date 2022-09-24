@extends('admin.layouts.skeleton')
@section('title', 'Add an Administrator')
<style>
    .displayError{
        color : red;
        font-size: 15px;
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


    <div class="card mb-4">
        <div class="card-header">
            Add an Administrator
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

             <form method="post" action="/admin/administrator/addAdministrator/store" class="col-lg-8 offset-lg-2" enctype="multipart/form-data">
                @csrf
                <div class="input-group mt-3">
                    <span class="text-danger text-lg mr-2" style="margin-top: 10px;">*</span>
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class='fas fa-address-book'></i></span></div>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="full name" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                <div class="input-group mt-3">
                    <span class="text-danger text-lg mr-2" style="margin-top: 10px;">*</span>
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" name="email" id="email" value="{{ old('email') }}">
                     @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                </div>

                <div class="input-group mt-3">
                    <span class="text-danger text-lg mr-2" style="margin-top: 10px;">*</span>
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class='fas fa-phone-volume'></i></span></div>
                    <input type="number" class="form-control @error('phone') is-invalid @enderror" placeholder="phone number" id="phone" name="phone" value="{{ old('phone') }}" required>
                    @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group mt-3">
                    <span class="text-danger text-lg mr-2" style="margin-top: 10px;">*</span>
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class='fas fa-home'></i></span></div>
                    <input type="text" class="form-control" placeholder="description of the location" id="home" name="home" value="{{ old('home') }}">
                </div>

                <div class="input-group mt-3">
                    <span class="text-danger text-lg mr-2" style="">*</span>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="setLocation" id="setLocation" name="setLocation">
                      <label class="form-check-label" for="setLocation">
                        Activate the location
                      </label>
                    </div>
                    <input type="hidden" name="lat" id="lat"  value="">
                    <input type="hidden" name="lng" id="lng"  value="">
                </div>

                <div class="input-group mt-3">
                    <span class="text-danger text-lg mr-2" style="margin-top: 10px;">*</span>
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class=' fas fa-lock'></i></span></div>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter the password" id="password" name="password" value="{{ old('password') }}" required>
                    @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group mt-3">
                    <span class="text-danger text-lg mr-2" style="margin-top: 10px;">*</span>
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class=' fas fa-lock'></i></span></div>
                    <input type="password" class="form-control @error('confirmpassword') is-invalid @enderror" placeholder="Confirm the password" id="confirmpassword" name="confirmpassword" value="{{ old('confirmpassword') }}" required>
                    @error('confirmpassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group mt-3 pl-3">
                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class=' fas fa-image'></i></span></div>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row float-right mt-3">
                    <a href="#">
                        <button class="btn btn-primary" name="submit" type="submit">Register</button>
                    </a>
                    <a href="/admin/administrator">
                        <button class="btn btn-secondary ml-2" type="button">Cancel</button>
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $( "#setLocation" ).on( "click", function() {

        if($("#setLocation").is(':checked'))

            // checked

           function myPosition(position) {
            $('#lat').val(position.coords.latitude);
            $('#lng').val(position.coords.longitude);
           }

           function errorPosition(error) {
              var info = "Error while getting your location : ";

              switch(error.code) {
                  case error.TIMEOUT:
                      info += "Timeout !";
                  break;
                  case error.PERMISSION_DENIED:
                  info += "Permission denied";
                  break;
                  case error.POSITION_UNAVAILABLE:
                      info += "Your location could not be determined";
                  break;
                  case error.UNKNOWN_ERROR:
                      info += "Unknown Error";
                  break;
              }

              alert(info);
           }

          if(navigator.geolocation)
            navigator.geolocation.getCurrentPosition(myPosition,errorPosition,{enableHighAccuracy:true});

        else
            //unchecked
            var message = "unchecked";
    });
</script>

@stop
