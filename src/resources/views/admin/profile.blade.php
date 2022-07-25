@extends('admin.layouts.skeleton')
@section('title', 'Profile')
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

        <!-- Nav Item - Clauses -->
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
        <li class="nav-item active">
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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>

    @if(Session::has('message'))
        <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
            {{ Session::get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


<div class="container">
  <div class="row gutters-sm">

      <div class="col-md-4">
          <div class="portlet light profile-sidebar-portlet bordered">
              <div class="text-center profile-userpic">
                @if(Session::has('photo'))
                    @if(Session::get('photo') == "noPath")
                        @php
                            $photo = '/img/undraw_profile.svg'
                        @endphp
                    @else
                        @php
                            $photo = url('storage/'.Session::get('photo'))
                        @endphp
                    @endif
                @else
                    @php
                        $photo = '/img/undraw_profile.svg'
                    @endphp
                @endif
                <img src="{{$photo}}"  alt="<?= $data['profile']?>" style="border-radius: 25px; transform: scale(1.1);"> </div>
              <div class="profile-usertitle">
                  <div class="profile-usertitle-name"> <?= $data['name']?> </div>
                  <div class="profile-usertitle-job"> <?= $data['profile']?> </div>

                  @if($data['profile'] == "superAdmin")

                    <div class="profile-usertitle-job">

                      <a href="#" id="location" locate="<?= $data['_id']?>" class="btn text-primary" style="size:18px;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                          <span class="icon">
                              <i class="fas fa-globe"></i>
                          </span>
                      </a>

                   </div>

                  @endif
              </div>
          </div>
      </div>
      <div class="col-md-8">
          <div class="portlet light bordered">
              <div class="portlet-title tabbable-line">
                  <div class="caption caption-md">
                      <i class="icon-globe theme-font hide"></i>
                      <span class="text-primary"><strong>DATA PANEL</strong></span>
                  </div>
              </div>
              <div class="portlet-body">
                  <div>

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist" id="tabMenu">
                          <li role="presentation" class="nav-item"><a class="nav-link active ?>" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
                          <li role="presentation" class="nav-item"><a class="nav-link" href="#update" aria-controls="update" role="tab" data-toggle="tab">Update</a></li>
                          <li role="presentation" class="nav-item"><a class="nav-link" href="#password_form" aria-controls="password_form" role="tab" data-toggle="tab">Password</a></li>
                          <li role="presentation"class="nav-item"><a class="nav-link" href="#settings" aria-controls="settings" role="tab" data-toggle="tab">General Settings</a></li>
                          <li role="presentation"class="nav-item"><a class="nav-link" href="#sanction" aria-controls="sanction" role="tab" data-toggle="tab">Sanctions</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                          <div role="tabpanel" class="tab-pane fade show active" id="profile">
                            <br>

                            <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  <?= $data['name']?>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  <?= $data['email']?>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  <?= $data['phone']?>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Home</h6>
                                </div>
                                <?php $localisation = $data['localisation'] ;?>
                                <div class="col-sm-9 text-secondary">
                                  <?php
                                    if(array_key_exists('description', $localisation)) {
                                        if ($data['localisation']['description']) {
                                            echo $localisation['description'];
                                        } else {
                                            echo "Not set";
                                        }

                                    } else {
                                        echo "Not set";
                                    }
                                ?>
                                </div>
                              </div>
                              <hr>
                          </div>


                          <div role="tabpanel" class="tab-pane fade " id="update">
                              <br>
                              <form method="post" action="/admin/profile/update" class="col-lg-8 offset-lg-2" enctype="multipart/form-data">
                                  @csrf
                                  @method('PUT')
                                  <div class="input-group mt-3">
                                      <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class='fas fa-address-book'></i></span></div>
                                      <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="name" id="name" name="name" value="<?= $data['name']?>" required>
                                          @error('name')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                          @enderror
                                  </div>

                                  <div class="input-group mt-3">
                                      <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase">@</span></div>
                                      <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" name="email" id="email" value="<?= $data['email']?>">
                                       @error('email')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                  </div>

                                  <div class="input-group mt-3">
                                      <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class='fas fa-phone-volume'></i></span></div>
                                      <input type="number" class="form-control @error('phone') is-invalid @enderror" placeholder="phone number" id="phone" name="phone" value="<?= $data['phone']?>" required>
                                      @error('phone')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                  </div>
                                  <?php $localisation = $data['localisation']; ?>
                                  <div class="input-group mt-3">
                                      <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class='fas fa-home'></i></span></div>
                                      <input type="text" class="form-control" placeholder="home location" id="home" name="home" value="<?php if(array_key_exists('description', $localisation)){echo $localisation['description'];} ?>">
                                  </div>

                                  <div class="input-group mt-3">
                                      <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class=' fas fa-image'></i></span></div>
                                      <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                                      @error('photo')
                                              <div class="invalid-feedback">{{ $message }}</div>
                                      @enderror
                                  </div>

                                  <hr>

                                  <a href="#">
                                      <button class="btn btn-block btn-primary" type="submit">Proceed</button>
                                  </a>

                              </form>
                      </div>

                      <div role="tabpanel" class="tab-pane fade" id="password_form">
                        <br>

                          <form method="post" action="/admin/profile/change_password" class="col-lg-8 offset-lg-2" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="input-group mt-3">
                                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class=' fas fa-lock'></i></span></div>
                                    <input type="password" class="form-control" placeholder="Old password" id="oldpassword" name="oldpassword" value="{{ old('password') }}" required>
                                </div>

                                <div class="input-group mt-3">
                                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class=' fas fa-lock'></i></span></div>
                                    <input type="password" class="form-control @error('newpassword') is-invalid @enderror" placeholder="New password" id="newpassword" name="newpassword" value="{{ old('password') }}" required>
                                    @error('newpassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group mt-3">
                                    <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class=' fas fa-lock'></i></span></div>
                                    <input type="password" class="form-control @error('confirmpassword') is-invalid @enderror" placeholder="Confirm the password" id="confirmpassword" name="confirmpassword" value="{{ old('confirmpassword') }}" required>
                                    @error('confirmpassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <a href="#">
                                    <button class="btn btn-block btn-primary" type="submit">Proceed</button>
                                </a>

                          </form>
                      </div>

                      <div role="tabpanel" class="tab-pane fade " id="settings">
                        <br>

                        <form method="post" action="/admin/profile/save_settings" class="col-lg-8 offset-lg-2" enctype="multipart/form-data">
                              @csrf
                              <div class="input-group mt-3">
                                  <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class="fas fa-cube"></i></span></div>
                                  <input type="number" class="form-control @error('meterprice') is-invalid @enderror" placeholder="Price per cubic meter" id="meterprice" name="meterprice" value="<?= empty($static) ? "" : $static[$index-1]['prixUnitaire']?>" required>
                                  @error('meterprice')
                                          <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                              </div>

                              <div class="input-group mt-3">
                                  <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class="fas fa-tools"></i></span></div>
                                  <input type="number" class="form-control @error('maintenance') is-invalid @enderror" placeholder="Maintenance costs" id="maintenance" name="maintenance" value="<?= empty($static) ? "" : $static[$index-1]['fraisEntretien']?>" required>
                                  @error('maintenance')
                                          <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                              </div>

                              <div class="input-group mt-3">
                                  <div class="input-group-prepend"><span class="input-group-text" aria-label="arobase"><i class="fas fa-calendar"></i></span></div>
                                  <div class="col-6">
                                    <select name="date" id="date" class="form-control">
                                        <?php
                                            if(!empty($static)){ ?>
                                                <option value="<?=$static[$index-1]['limiteDay']?>"><?=$static[$index-1]['limiteDay']?></option>
                                                <?php for($i=1;$i<=30;$i++){
                                                    if($i!=$static[$index-1]['limiteDay']){
                                                    ?>
                                                <option value="<?=$i?>"><?=$i?></option>
                                                <?php }
                                                    }
                                                ?>
                                        <?php
                                            }else{
                                        ?>
                                        <option value="">day of payment</option>
                                        <?php for($i=1;$i<=30;$i++){?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                        <?php }
                                            }?>
                                    </select>
                                  </div>
                              </div>

                              <hr>

                              <a href="#">
                                  <button class="btn btn-block btn-primary" type="submit">Proceed</button>
                              </a>
                          </form>
                      </div>

                      <div role="tabpanel" class="tab-pane fade " id="sanction">
                        <br>

                        <form method="post" action="/admin/profile/sanctions" class="col-lg-8 offset-lg-2" enctype="multipart/form-data">
                              @csrf
                              <div class="input-group">
                                  <div class="input-group">Sanction Amount</div>
                                  <div class="col-6">
                                    <input type="number" class="form-control @error('sanction') is-invalid @enderror" placeholder="sanction amount" id="sanction" name="sanction" value="{{ old('sanction') }}" required>
                                    @error('sanction')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                  </div>

                              </div>

                              <div class="input-group mt-3">
                                  <div class="input-group">Step</div>
                                  <div class="col-7">
                                    <input type="number" class="form-control @error('step') is-invalid @enderror" placeholder="Every x number of days" id="step" name="step" value="{{ old('step') }}" required>
                                    @error('step')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                  </div>

                              </div>

                              <hr>
                              <a href="#">
                                  <button class="btn btn-block btn-primary" type="submit">Proceed</button>
                              </a>
                          </form>
                      </div>

                  </div>
              </div>
          </div>
        </div>
  </div>

  </div>
</div>

<script>
  //redirect to specific tab
  $(document).ready(function () {
      $("#tabMenu a[href='#{{ old('tab') }}']").tab('show');
  });
</script>

<script>

    $("body").on('click','#location',function(event){

        event.preventDefault();

        var id = $(this).attr('locate');

        console.log(id);

       function myPosition(position) {
         lat = position.coords.latitude;
         lng = position.coords.longitude;

            <?php
                $alltoken = $_COOKIE['token'];
                $alltokentab = explode(';', $alltoken);
                $token = $alltokentab[0];
                $tokentab = explode('=',$token);
                $tokenVal = $tokentab[1];
                $Authorization = 'Bearer '.$tokenVal;
            ?>

            var datas = {'longitude' : lng, 'latitude' : lat };

            datas = JSON.stringify(datas);

           $.ajax({

               type : 'post',

               url : "<?= 'http://172.17.0.2:4000/login/localisation/'?>" + id,

               headers: { 'Authorization': '<?= $Authorization ?>', 'Content-Type': 'application/json' },

               data: datas,

               success :function (success) {
                  alert("Well Done !");
               },

               error : function (){
                  alert('Error');
               }

           });
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
       }

      if(navigator.geolocation)
        navigator.geolocation.getCurrentPosition(myPosition,errorPosition,{enableHighAccuracy:true});


    });

</script>


<style>

.profile-content {
    overflow: hidden
}

.profile-sidebar-portlet {
    padding: 30px 0 0!important
}

.profile-userpic img {

    width: 50%;
}

.profile-usertitle {
    text-align: center;
    margin-top: 20px
}

.profile-usertitle-name {
    color: #5a7391;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 7px
}

.profile-usertitle-job {
    text-transform: uppercase;
    color: #5b9bd1;
    font-size: 13px;
    font-weight: 800;
    margin-bottom: 7px
}

.profile-userbuttons {
    text-align: center;
    margin-top: 10px
}

.profile-userbuttons .btn {
    margin-right: 5px
}

.profile-userbuttons .btn:last-child {
    margin-right: 0
}

.profile-userbuttons button {
    text-transform: uppercase;
    font-size: 11px;
    font-weight: 600;
    padding: 6px 15px
}

.profile-usermenu {
    margin-top: 30px;
    padding-bottom: 20px
}

.profile-usermenu ul li {
    border-bottom: 1px solid #f0f4f7
}

.profile-usermenu ul li:last-child {
    border-bottom: none
}

.profile-usermenu ul li a {
    color: #93a3b5;
    font-size: 16px;
    font-weight: 400
}

.profile-usermenu ul li a i {
    margin-right: 8px;
    font-size: 16px
}

.profile-usermenu ul li a:hover {
    background-color: #fafcfd;
    color: #5b9bd1
}

.profile-usermenu ul li.active a {
    color: #5b9bd1;
    background-color: #f6f9fb;
    border-left: 2px solid #5b9bd1;
    margin-left: -2px
}

.profile-stat {
    padding-bottom: 20px;
    border-bottom: 1px solid #f0f4f7
}

.profile-stat-title {
    color: #7f90a4;
    font-size: 25px;
    text-align: center
}

.profile-stat-text {
    color: #5b9bd1;
    font-size: 11px;
    font-weight: 800;
    text-align: center
}

.profile-desc-title {
    color: #7f90a4;
    font-size: 17px;
    font-weight: 600
}

.profile-desc-text {
    color: #7e8c9e;
    font-size: 14px
}

.profile-desc-link i {
    width: 22px;
    font-size: 19px;
    color: #abb6c4;
    margin-right: 5px
}

.profile-desc-link a {
    font-size: 14px;
    font-weight: 600;
    color: #5b9bd1
}

@media (max-width:991px) {
    .profile-sidebar {
        float: none;
        width: 100%!important;
        margin: 0
    }
    .profile-sidebar>.portlet {
        margin-bottom: 20px
    }
    .profile-content {
        overflow: visible
    }
}


/*portlet*/
.page-portlet-fullscreen {
    overflow: hidden
}

.portlet {
    margin-top: 0;
    margin-bottom: 25px;
    padding: 0;
    border-radius: 4px
}

.portlet.portlet-fullscreen {
    z-index: 10060;
    margin: 0;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: #fff
}

.portlet.portlet-fullscreen>.portlet-body {
    overflow-y: auto;
    overflow-x: hidden;
    padding: 0 10px
}

.portlet.portlet-fullscreen>.portlet-title {
    padding: 0 10px
}

.portlet>.portlet-title {
    border-bottom: 1px solid #eee;
    padding: 0;
    margin-bottom: 10px;
    min-height: 41px;
    -webkit-border-radius: 4px 4px 0 0;
    -moz-border-radius: 4px 4px 0 0;
    -ms-border-radius: 4px 4px 0 0;
    -o-border-radius: 4px 4px 0 0;
    border-radius: 4px 4px 0 0
}

.portlet>.portlet-title:after,
.portlet>.portlet-title:before {
    content: " ";
    display: table
}

.portlet>.portlet-title:after {
    clear: both
}

.portlet>.portlet-title>.caption {
    float: left;
    display: inline-block;
    font-size: 18px;
    line-height: 18px;
    padding: 10px 0
}

.portlet>.portlet-title>.caption.bold {
    font-weight: 400
}

.portlet>.portlet-title>.caption>i {
    float: left;
    margin-top: 4px;
    display: inline-block;
    font-size: 13px;
    margin-right: 5px;
    color: #666
}

.portlet>.portlet-title>.caption>i.glyphicon {
    margin-top: 2px
}

.portlet>.portlet-title>.caption>.caption-helper {
    padding: 0;
    margin: 0;
    line-height: 13px;
    color: #9eacb4;
    font-size: 13px;
    font-weight: 400
}

.portlet>.portlet-title>.actions {
    float: right;
    display: inline-block;
    padding: 6px 0
}

.portlet>.portlet-title>.actions>.dropdown-menu i {
    color: #555
}

.portlet>.portlet-title>.actions>.btn,
.portlet>.portlet-title>.actions>.btn-group>.btn,
.portlet>.portlet-title>.actions>.btn-group>.btn.btn-sm,
.portlet>.portlet-title>.actions>.btn.btn-sm {
    padding: 4px 10px;
    font-size: 13px;
    line-height: 1.5
}

.portlet>.portlet-title>.actions>.btn-group>.btn.btn-default,
.portlet>.portlet-title>.actions>.btn-group>.btn.btn-sm.btn-default,
.portlet>.portlet-title>.actions>.btn.btn-default,
.portlet>.portlet-title>.actions>.btn.btn-sm.btn-default {
    padding: 3px 9px
}

.portlet>.portlet-title>.actions>.btn-group>.btn.btn-sm>i,
.portlet>.portlet-title>.actions>.btn-group>.btn>i,
.portlet>.portlet-title>.actions>.btn.btn-sm>i,
.portlet>.portlet-title>.actions>.btn>i {
    font-size: 13px
}

.portlet>.portlet-title>.actions .btn-icon-only {
    padding: 5px 7px 3px
}

.portlet>.portlet-title>.actions .btn-icon-only.btn-default {
    padding: 4px 6px 2px
}

.portlet>.portlet-title>.actions .btn-icon-only.btn-default>i {
    font-size: 14px
}

.portlet>.portlet-title>.actions .btn-icon-only.btn-default.fullscreen {
    font-family: FontAwesome;
    color: #a0a0a0;
    padding-top: 3px
}

.portlet>.portlet-title>.actions .btn-icon-only.btn-default.fullscreen.btn-sm {
    padding: 3px!important;
    height: 27px;
    width: 27px
}

.portlet>.portlet-title>.actions .btn-icon-only.btn-default.fullscreen:before {
    content: "\f065"
}

.portlet>.portlet-title>.actions .btn-icon-only.btn-default.fullscreen.on:before {
    content: "\f066"
}

.portlet>.portlet-title>.tools {
    float: right;
    display: inline-block;
    padding: 12px 0 8px
}

.portlet>.portlet-title>.tools>a {
    display: inline-block;
    height: 16px;
    margin-left: 5px;
    opacity: 1;
    filter: alpha(opacity=100)
}

.portlet>.portlet-title>.tools>a.fullscreen {
    display: inline-block;
    top: -3px;
    position: relative;
    font-size: 13px;
    font-family: FontAwesome;
    color: #ACACAC
}

.portlet>.portlet-title>.tools>a.fullscreen:before {
    content: "\f065"
}

.portlet>.portlet-title>.tools>a.fullscreen.on:before {
    content: "\f066"
}

.portlet>.portlet-title>.tools>a:hover {
    text-decoration: none;
    -webkit-transition: all .1s ease-in-out;
    -moz-transition: all .1s ease-in-out;
    -o-transition: all .1s ease-in-out;
    -ms-transition: all .1s ease-in-out;
    transition: all .1s ease-in-out;
    opacity: .8;
    filter: alpha(opacity=80)
}

.portlet>.portlet-title>.pagination {
    float: right;
    display: inline-block;
    margin: 2px 0 0;
    border: 0;
    padding: 4px 0
}

.portlet>.portlet-title>.nav-tabs {
    background: 0 0;
    margin: 1px 0 0;
    float: right;
    display: inline-block;
    border: 0
}

.portlet>.portlet-title>.nav-tabs>li {
    background: 0 0;
    margin: 0;
    border: 0
}

.portlet>.portlet-title>.nav-tabs>li>a {
    background: 0 0;
    margin: 5px 0 0 1px;
    border: 0;
    padding: 8px 10px;
    color: #fff
}

.portlet>.portlet-title>.nav-tabs>li.active>a,
.portlet>.portlet-title>.nav-tabs>li:hover>a {
    color: #333;
    background: #fff;
    border: 0
}

.portlet>.portlet-body {
    clear: both;
    -webkit-border-radius: 0 0 4px 4px;
    -moz-border-radius: 0 0 4px 4px;
    -ms-border-radius: 0 0 4px 4px;
    -o-border-radius: 0 0 4px 4px;
    border-radius: 0 0 4px 4px
}

.portlet>.portlet-body p {
    margin-top: 0
}

.portlet>.portlet-empty {
    min-height: 125px
}

.portlet.full-height-content {
    margin-bottom: 0
}

.portlet.bordered {
    border-left: 2px solid #e6e9ec!important
}

.portlet.bordered>.portlet-title {
    border-bottom: 0
}

.portlet.solid {
    padding: 0 10px 10px;
    border: 0
}

.portlet.solid>.portlet-title {
    border-bottom: 0;
    margin-bottom: 10px
}

.portlet.solid>.portlet-title>.caption {
    padding: 16px 0 2px
}

.portlet.solid>.portlet-title>.actions {
    padding: 12px 0 6px
}

.portlet.solid>.portlet-title>.tools {
    padding: 14px 0 6px
}

.portlet.solid.bordered>.portlet-title {
    margin-bottom: 10px
}

.portlet.box {
    padding: 0!important
}

.portlet.box>.portlet-title {
    border-bottom: 0;
    padding: 0 10px;
    margin-bottom: 0;
    color: #fff
}

.portlet.box>.portlet-title>.caption {
    padding: 11px 0 9px
}

.portlet.box>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box>.portlet-title>.actions {
    padding: 7px 0 5px
}

.portlet.box>.portlet-body {
    background-color: #fff;
    padding: 15px
}

.portlet.light {
    padding: 12px 20px 15px;
    background-color: #fff
}

.portlet.light.bordered {
    border: 1px solid #e7ecf1!important
}

.portlet.light.bordered>.portlet-title {
    border-bottom: 1px solid #eef1f5
}

.portlet.light.bg-inverse {
    background: #f1f4f7
}

.portlet.light>.portlet-title {
    padding: 0;
    min-height: 48px
}

.portlet.light>.portlet-title>.caption {
    color: #666;
    padding: 10px 0
}

.portlet.light>.portlet-title>.caption>.caption-subject {
    font-size: 16px
}

.portlet.light>.portlet-title>.caption>i {
    color: #777;
    font-size: 15px;
    font-weight: 300;
    margin-top: 3px
}

.portlet.solid.blue-chambray>.portlet-title>.caption,
.portlet.solid.blue-dark>.portlet-title>.caption,
.portlet.solid.blue-ebonyclay>.portlet-title>.caption,
.portlet.solid.blue-hoki>.portlet-title>.caption,
.portlet.solid.blue-madison>.portlet-title>.caption,
.portlet.solid.blue-oleo>.portlet-title>.caption,
.portlet.solid.blue-sharp>.portlet-title>.caption,
.portlet.solid.blue-soft>.portlet-title>.caption,
.portlet.solid.blue-steel>.portlet-title>.caption,
.portlet.solid.blue>.portlet-title>.caption,
.portlet.solid.dark>.portlet-title>.caption,
.portlet.solid.default>.portlet-title>.caption,
.portlet.solid.green-dark>.portlet-title>.caption,
.portlet.solid.green-haze>.portlet-title>.caption,
.portlet.solid.green-jungle>.portlet-title>.caption,
.portlet.solid.green-meadow>.portlet-title>.caption,
.portlet.solid.green-seagreen>.portlet-title>.caption,
.portlet.solid.green-sharp>.portlet-title>.caption,
.portlet.solid.green-soft>.portlet-title>.caption,
.portlet.solid.green-steel>.portlet-title>.caption,
.portlet.solid.green-turquoise>.portlet-title>.caption,
.portlet.solid.green>.portlet-title>.caption,
.portlet.solid.grey-cararra>.portlet-title>.caption,
.portlet.solid.grey-cascade>.portlet-title>.caption,
.portlet.solid.grey-gallery>.portlet-title>.caption,
.portlet.solid.grey-mint>.portlet-title>.caption,
.portlet.solid.grey-salt>.portlet-title>.caption,
.portlet.solid.grey-silver>.portlet-title>.caption,
.portlet.solid.grey-steel>.portlet-title>.caption,
.portlet.solid.grey>.portlet-title>.caption,
.portlet.solid.purple-intense>.portlet-title>.caption,
.portlet.solid.purple-medium>.portlet-title>.caption,
.portlet.solid.purple-plum>.portlet-title>.caption,
.portlet.solid.purple-seance>.portlet-title>.caption,
.portlet.solid.purple-sharp>.portlet-title>.caption,
.portlet.solid.purple-soft>.portlet-title>.caption,
.portlet.solid.purple-studio>.portlet-title>.caption,
.portlet.solid.purple-wisteria>.portlet-title>.caption,
.portlet.solid.purple>.portlet-title>.caption,
.portlet.solid.red-flamingo>.portlet-title>.caption,
.portlet.solid.red-haze>.portlet-title>.caption,
.portlet.solid.red-intense>.portlet-title>.caption,
.portlet.solid.red-mint>.portlet-title>.caption,
.portlet.solid.red-pink>.portlet-title>.caption,
.portlet.solid.red-soft>.portlet-title>.caption,
.portlet.solid.red-sunglo>.portlet-title>.caption,
.portlet.solid.red-thunderbird>.portlet-title>.caption,
.portlet.solid.red>.portlet-title>.caption,
.portlet.solid.white>.portlet-title>.caption,
.portlet.solid.yellow-casablanca>.portlet-title>.caption,
.portlet.solid.yellow-crusta>.portlet-title>.caption,
.portlet.solid.yellow-gold>.portlet-title>.caption,
.portlet.solid.yellow-haze>.portlet-title>.caption,
.portlet.solid.yellow-lemon>.portlet-title>.caption,
.portlet.solid.yellow-mint>.portlet-title>.caption,
.portlet.solid.yellow-saffron>.portlet-title>.caption,
.portlet.solid.yellow-soft>.portlet-title>.caption,
.portlet.solid.yellow>.portlet-title>.caption {
    font-weight: 400
}

.portlet.light>.portlet-title>.caption.caption-md>.caption-subject {
    font-size: 15px
}

.portlet.light>.portlet-title>.caption.caption-md>i {
    font-size: 14px
}

.portlet.light>.portlet-title>.actions {
    padding: 6px 0 14px
}

.portlet.light>.portlet-title>.actions .btn-default {
    color: #666
}

.portlet.light>.portlet-title>.actions .btn-icon-only {
    height: 27px;
    width: 27px
}

.portlet.light>.portlet-title>.actions .dropdown-menu li>a {
    color: #555
}

.portlet.light>.portlet-title>.inputs {
    float: right;
    display: inline-block;
    padding: 4px 0
}

.portlet.light>.portlet-title>.inputs>.portlet-input .input-icon>i {
    font-size: 14px;
    margin-top: 9px
}

.portlet.light>.portlet-title>.inputs>.portlet-input .input-icon>.form-control {
    height: 30px;
    padding: 2px 26px 3px 10px;
    font-size: 13px
}

.portlet.light>.portlet-title>.inputs>.portlet-input>.form-control {
    height: 30px;
    padding: 3px 10px;
    font-size: 13px
}

.portlet.light>.portlet-title>.pagination {
    padding: 2px 0 13px
}

.portlet.light>.portlet-title>.tools {
    padding: 10px 0 13px;
    margin-top: 2px
}

.portlet.light>.portlet-title>.nav-tabs>li {
    margin: 0;
    padding: 0
}

.portlet.light>.portlet-title>.nav-tabs>li>a {
    margin: 0;
    padding: 12px 13px 13px;
    font-size: 13px;
    color: #666
}

.portlet.light>.portlet-title>.nav-tabs>li.active>a,
.portlet.light>.portlet-title>.nav-tabs>li:hover>a {
    margin: 0;
    background: 0 0;
    color: #333
}

.portlet.light.form-fit {
    padding: 0
}

.portlet.light.form-fit>.portlet-title {
    padding: 17px 20px 10px;
    margin-bottom: 0
}

.portlet.light .portlet-body {
    padding-top: 8px
}

.portlet.light.portlet-fullscreen>.portlet-body {
    padding: 8px 0
}

.portlet.light.portlet-fit {
    padding: 0
}

.portlet.light.portlet-fit>.portlet-title {
    padding: 15px 20px 10px
}

.portlet.light.portlet-fit>.portlet-body {
    padding: 10px 20px 20px
}

.portlet.light.portlet-fit.portlet-form>.portlet-body {
    padding: 0
}

.portlet.light.portlet-fit.portlet-form>.portlet-body .form-actions {
    background: 0 0
}

.portlet.box.white>.portlet-title,
.portlet.white,
.portlet>.portlet-body.white {
    background-color: #fff
}

.portlet.light.portlet-datatable.portlet-fit>.portlet-body {
    padding-top: 10px;
    padding-bottom: 25px
}

.tab-pane>p:last-child {
    margin-bottom: 0
}

.tabs-reversed>li {
    float: right;
    margin-right: 0
}

.tabs-reversed>li>a {
    margin-right: 0
}

.portlet-sortable-placeholder {
    border: 2px dashed #eee;
    margin-bottom: 25px
}

.portlet-sortable-empty {
    box-shadow: none!important;
    height: 45px
}

.portlet-collapsed {
    display: none
}

@media (max-width:991px) {
    .portlet-collapsed-on-mobile {
        display: none
    }
}

.portlet.solid.white>.portlet-body,
.portlet.solid.white>.portlet-title {
    border: 0;
    color: #666
}

.portlet.solid.white>.portlet-title>.caption>i {
    color: #666
}

.portlet.solid.white>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.white {
    border: 1px solid #fff;
    border-top: 0
}

.portlet.box.white>.portlet-title>.caption,
.portlet.box.white>.portlet-title>.caption>i {
    color: #666
}

.portlet.box.white>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #fff;
    color: #fff
}

.portlet.box.default>.portlet-title,
.portlet.default,
.portlet>.portlet-body.default {
    background-color: #e1e5ec
}

.portlet.box.white>.portlet-title>.actions .btn-default>i {
    color: #fff
}

.portlet.box.white>.portlet-title>.actions .btn-default.active,
.portlet.box.white>.portlet-title>.actions .btn-default:active,
.portlet.box.white>.portlet-title>.actions .btn-default:focus,
.portlet.box.white>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #fff;
    color: #fff
}

.portlet.solid.default>.portlet-body,
.portlet.solid.default>.portlet-title {
    border: 0;
    color: #666
}

.portlet.solid.default>.portlet-title>.caption>i {
    color: #666
}

.portlet.solid.default>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.default {
    border: 1px solid #fff;
    border-top: 0
}

.portlet.box.default>.portlet-title>.caption,
.portlet.box.default>.portlet-title>.caption>i {
    color: #666
}

.portlet.box.default>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #fff;
    color: #fff
}

.portlet.box.dark>.portlet-title,
.portlet.dark,
.portlet>.portlet-body.dark {
    background-color: #2f353b
}

.portlet.box.default>.portlet-title>.actions .btn-default>i {
    color: #fff
}

.portlet.box.default>.portlet-title>.actions .btn-default.active,
.portlet.box.default>.portlet-title>.actions .btn-default:active,
.portlet.box.default>.portlet-title>.actions .btn-default:focus,
.portlet.box.default>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #fff;
    color: #fff
}

.portlet.solid.dark>.portlet-body,
.portlet.solid.dark>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.dark>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.dark>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.dark {
    border: 1px solid #464f57;
    border-top: 0
}

.portlet.box.dark>.portlet-title>.caption,
.portlet.box.dark>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.dark>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #616d79;
    color: #6c7a88
}

.portlet.blue,
.portlet.box.blue>.portlet-title,
.portlet>.portlet-body.blue {
    background-color: #3598dc
}

.portlet.box.dark>.portlet-title>.actions .btn-default>i {
    color: #738290
}

.portlet.box.dark>.portlet-title>.actions .btn-default.active,
.portlet.box.dark>.portlet-title>.actions .btn-default:active,
.portlet.box.dark>.portlet-title>.actions .btn-default:focus,
.portlet.box.dark>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #798794;
    color: #8793a0
}

.portlet.solid.blue>.portlet-body,
.portlet.solid.blue>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.blue>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue {
    border: 1px solid #60aee4;
    border-top: 0
}

.portlet.box.blue>.portlet-title>.caption,
.portlet.box.blue>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #95c9ed;
    color: #aad4f0
}

.portlet.blue-madison,
.portlet.box.blue-madison>.portlet-title,
.portlet>.portlet-body.blue-madison {
    background-color: #578ebe
}

.portlet.box.blue>.portlet-title>.actions .btn-default>i {
    color: #b7daf3
}

.portlet.box.blue>.portlet-title>.actions .btn-default.active,
.portlet.box.blue>.portlet-title>.actions .btn-default:active,
.portlet.box.blue>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #c0dff4;
    color: #d6eaf8
}

.portlet.solid.blue-madison>.portlet-body,
.portlet.solid.blue-madison>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue-madison>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.blue-madison>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue-madison {
    border: 1px solid #7ca7cc;
    border-top: 0
}

.portlet.box.blue-madison>.portlet-title>.caption,
.portlet.box.blue-madison>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue-madison>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #a8c4dd;
    color: #bad1e4
}

.portlet.blue-chambray,
.portlet.box.blue-chambray>.portlet-title,
.portlet>.portlet-body.blue-chambray {
    background-color: #2C3E50
}

.portlet.box.blue-madison>.portlet-title>.actions .btn-default>i {
    color: #c5d8e9
}

.portlet.box.blue-madison>.portlet-title>.actions .btn-default.active,
.portlet.box.blue-madison>.portlet-title>.actions .btn-default:active,
.portlet.box.blue-madison>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue-madison>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #cdddec;
    color: #dfeaf3
}

.portlet.solid.blue-chambray>.portlet-body,
.portlet.solid.blue-chambray>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue-chambray>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.blue-chambray>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue-chambray {
    border: 1px solid #3e5871;
    border-top: 0
}

.portlet.box.blue-chambray>.portlet-title>.caption,
.portlet.box.blue-chambray>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue-chambray>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #547698;
    color: #5f83a7
}

.portlet.blue-ebonyclay,
.portlet.box.blue-ebonyclay>.portlet-title,
.portlet>.portlet-body.blue-ebonyclay {
    background-color: #22313F
}

.portlet.box.blue-chambray>.portlet-title>.actions .btn-default>i {
    color: #698bac
}

.portlet.box.blue-chambray>.portlet-title>.actions .btn-default.active,
.portlet.box.blue-chambray>.portlet-title>.actions .btn-default:active,
.portlet.box.blue-chambray>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue-chambray>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #6f90b0;
    color: #809cb9
}

.portlet.solid.blue-ebonyclay>.portlet-body,
.portlet.solid.blue-ebonyclay>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue-ebonyclay>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.blue-ebonyclay>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue-ebonyclay {
    border: 1px solid #344b60;
    border-top: 0
}

.portlet.box.blue-ebonyclay>.portlet-title>.caption,
.portlet.box.blue-ebonyclay>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue-ebonyclay>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #496a88;
    color: #527798
}

.portlet.blue-hoki,
.portlet.box.blue-hoki>.portlet-title,
.portlet>.portlet-body.blue-hoki {
    background-color: #67809F
}

.portlet.box.blue-ebonyclay>.portlet-title>.actions .btn-default>i {
    color: #587ea2
}

.portlet.box.blue-ebonyclay>.portlet-title>.actions .btn-default.active,
.portlet.box.blue-ebonyclay>.portlet-title>.actions .btn-default:active,
.portlet.box.blue-ebonyclay>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue-ebonyclay>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #5d83a7;
    color: #6d90b0
}

.portlet.solid.blue-hoki>.portlet-body,
.portlet.solid.blue-hoki>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue-hoki>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.blue-hoki>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue-hoki {
    border: 1px solid #869ab3;
    border-top: 0
}

.portlet.box.blue-hoki>.portlet-title>.caption,
.portlet.box.blue-hoki>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue-hoki>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #acb9ca;
    color: #bbc7d4
}

.portlet.blue-steel,
.portlet.box.blue-steel>.portlet-title,
.portlet>.portlet-body.blue-steel {
    background-color: #4B77BE
}

.portlet.box.blue-hoki>.portlet-title>.actions .btn-default>i {
    color: #c5ceda
}

.portlet.box.blue-hoki>.portlet-title>.actions .btn-default.active,
.portlet.box.blue-hoki>.portlet-title>.actions .btn-default:active,
.portlet.box.blue-hoki>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue-hoki>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #cbd4de;
    color: #dbe1e8
}

.portlet.solid.blue-steel>.portlet-body,
.portlet.solid.blue-steel>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue-steel>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.blue-steel>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue-steel {
    border: 1px solid #7093cc;
    border-top: 0
}

.portlet.box.blue-steel>.portlet-title>.caption,
.portlet.box.blue-steel>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue-steel>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #9db5dc;
    color: #b0c3e3
}

.portlet.blue-soft,
.portlet.box.blue-soft>.portlet-title,
.portlet>.portlet-body.blue-soft {
    background-color: #4c87b9
}

.portlet.box.blue-steel>.portlet-title>.actions .btn-default>i {
    color: #bbcce7
}

.portlet.box.blue-steel>.portlet-title>.actions .btn-default.active,
.portlet.box.blue-steel>.portlet-title>.actions .btn-default:active,
.portlet.box.blue-steel>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue-steel>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #c3d2e9;
    color: #d6e0f0
}

.portlet.solid.blue-soft>.portlet-body,
.portlet.solid.blue-soft>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue-soft>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.blue-soft>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue-soft {
    border: 1px solid #71a0c7;
    border-top: 0
}

.portlet.box.blue-soft>.portlet-title>.caption,
.portlet.box.blue-soft>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue-soft>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #9dbdd9;
    color: #afc9e0
}

.portlet.blue-dark,
.portlet.box.blue-dark>.portlet-title,
.portlet>.portlet-body.blue-dark {
    background-color: #5e738b
}

.portlet.box.blue-soft>.portlet-title>.actions .btn-default>i {
    color: #bad1e4
}

.portlet.box.blue-soft>.portlet-title>.actions .btn-default.active,
.portlet.box.blue-soft>.portlet-title>.actions .btn-default:active,
.portlet.box.blue-soft>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue-soft>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #c1d6e7;
    color: #d4e2ee
}

.portlet.solid.blue-dark>.portlet-body,
.portlet.solid.blue-dark>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue-dark>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.blue-dark>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue-dark {
    border: 1px solid #788da4;
    border-top: 0
}

.portlet.box.blue-dark>.portlet-title>.caption,
.portlet.box.blue-dark>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue-dark>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #9dacbd;
    color: #acb8c7
}

.portlet.blue-sharp,
.portlet.box.blue-sharp>.portlet-title,
.portlet>.portlet-body.blue-sharp {
    background-color: #5C9BD1
}

.portlet.box.blue-dark>.portlet-title>.actions .btn-default>i {
    color: #b5c0cd
}

.portlet.box.blue-dark>.portlet-title>.actions .btn-default.active,
.portlet.box.blue-dark>.portlet-title>.actions .btn-default:active,
.portlet.box.blue-dark>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue-dark>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #bbc5d1;
    color: #cad2db
}

.portlet.solid.blue-sharp>.portlet-body,
.portlet.solid.blue-sharp>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue-sharp>.portlet-title>.caption>i {
    color: #FFF
}


.portlet.solid.blue-sharp>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue-sharp {
    border: 1px solid #84b3dc;
    border-top: 0
}

.portlet.box.blue-sharp>.portlet-title>.caption,
.portlet.box.blue-sharp>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue-sharp>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #b4d1ea;
    color: #c7ddef
}

.portlet.blue-oleo,
.portlet.box.blue-oleo>.portlet-title,
.portlet>.portlet-body.blue-oleo {
    background-color: #94A0B2
}

.portlet.box.blue-sharp>.portlet-title>.actions .btn-default>i {
    color: #d3e4f3
}

.portlet.box.blue-sharp>.portlet-title>.actions .btn-default.active,
.portlet.box.blue-sharp>.portlet-title>.actions .btn-default:active,
.portlet.box.blue-sharp>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue-sharp>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #dbe9f5;
    color: #eff5fb
}

.portlet.solid.blue-oleo>.portlet-body,
.portlet.solid.blue-oleo>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.blue-oleo>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.blue-oleo>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.blue-oleo {
    border: 1px solid #b2bac7;
    border-top: 0
}

.portlet.box.blue-oleo>.portlet-title>.caption,
.portlet.box.blue-oleo>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.blue-oleo>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #d5dae1;
    color: #e4e7ec
}

.portlet.box.green>.portlet-title,
.portlet.green,
.portlet>.portlet-body.green {
    background-color: #32c5d2
}

.portlet.box.blue-oleo>.portlet-title>.actions .btn-default>i {
    color: #edeff2
}

.portlet.box.blue-oleo>.portlet-title>.actions .btn-default.active,
.portlet.box.blue-oleo>.portlet-title>.actions .btn-default:active,
.portlet.box.blue-oleo>.portlet-title>.actions .btn-default:focus,
.portlet.box.blue-oleo>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #f3f4f6;
    color: #fff
}

.portlet.solid.green>.portlet-body,
.portlet.solid.green>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green {
    border: 1px solid #5cd1db;
    border-top: 0
}

.portlet.box.green>.portlet-title>.caption,
.portlet.box.green>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #8edfe6;
    color: #a3e5eb
}

.portlet.box.green-meadow>.portlet-title,
.portlet.green-meadow,
.portlet>.portlet-body.green-meadow {
    background-color: #1BBC9B
}

.portlet.box.green>.portlet-title>.actions .btn-default>i {
    color: #afe8ee
}

.portlet.box.green>.portlet-title>.actions .btn-default.active,
.portlet.box.green>.portlet-title>.actions .btn-default:active,
.portlet.box.green>.portlet-title>.actions .btn-default:focus,
.portlet.box.green>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #b8ebef;
    color: #cdf1f4
}

.portlet.solid.green-meadow>.portlet-body,
.portlet.solid.green-meadow>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green-meadow>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green-meadow>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green-meadow {
    border: 1px solid #2ae0bb;
    border-top: 0
}

.portlet.box.green-meadow>.portlet-title>.caption,
.portlet.box.green-meadow>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green-meadow>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #5fe8cc;
    color: #75ebd3
}

.portlet.box.green-seagreen>.portlet-title,
.portlet.green-seagreen,
.portlet>.portlet-body.green-seagreen {
    background-color: #1BA39C
}

.portlet.box.green-meadow>.portlet-title>.actions .btn-default>i {
    color: #83edd7
}

.portlet.box.green-meadow>.portlet-title>.actions .btn-default.active,
.portlet.box.green-meadow>.portlet-title>.actions .btn-default:active,
.portlet.box.green-meadow>.portlet-title>.actions .btn-default:focus,
.portlet.box.green-meadow>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #8ceeda;
    color: #a2f2e1
}

.portlet.solid.green-seagreen>.portlet-body,
.portlet.solid.green-seagreen>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green-seagreen>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green-seagreen>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green-seagreen {
    border: 1px solid #22cfc6;
    border-top: 0
}

.portlet.box.green-seagreen>.portlet-title>.caption,
.portlet.box.green-seagreen>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green-seagreen>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #4de1da;
    color: #63e5de
}

.portlet.box.green-turquoise>.portlet-title,
.portlet.green-turquoise,
.portlet>.portlet-body.green-turquoise {
    background-color: #36D7B7
}

.portlet.box.green-seagreen>.portlet-title>.actions .btn-default>i {
    color: #70e7e1
}

.portlet.box.green-seagreen>.portlet-title>.actions .btn-default.active,
.portlet.box.green-seagreen>.portlet-title>.actions .btn-default:active,
.portlet.box.green-seagreen>.portlet-title>.actions .btn-default:focus,
.portlet.box.green-seagreen>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #78e9e3;
    color: #8eece8
}

.portlet.solid.green-turquoise>.portlet-body,
.portlet.solid.green-turquoise>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green-turquoise>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green-turquoise>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green-turquoise {
    border: 1px solid #61dfc6;
    border-top: 0
}

.portlet.box.green-turquoise>.portlet-title>.caption,
.portlet.box.green-turquoise>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green-turquoise>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #94ead9;
    color: #a9eee0
}

.portlet.box.green-haze>.portlet-title,
.portlet.green-haze,
.portlet>.portlet-body.green-haze {
    background-color: #44b6ae
}

.portlet.box.green-turquoise>.portlet-title>.actions .btn-default>i {
    color: #b6f0e5
}

.portlet.box.green-turquoise>.portlet-title>.actions .btn-default.active,
.portlet.box.green-turquoise>.portlet-title>.actions .btn-default:active,
.portlet.box.green-turquoise>.portlet-title>.actions .btn-default:focus,
.portlet.box.green-turquoise>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #bef2e8;
    color: #d3f6ef
}

.portlet.solid.green-haze>.portlet-body,
.portlet.solid.green-haze>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green-haze>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green-haze>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green-haze {
    border: 1px solid #67c6bf;
    border-top: 0
}

.portlet.box.green-haze>.portlet-title>.caption,
.portlet.box.green-haze>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green-haze>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #93d7d2;
    color: #a6deda
}

.portlet.box.green-jungle>.portlet-title,
.portlet.green-jungle,
.portlet>.portlet-body.green-jungle {
    background-color: #26C281
}

.portlet.box.green-haze>.portlet-title>.actions .btn-default>i {
    color: #b1e2de
}

.portlet.box.green-haze>.portlet-title>.actions .btn-default.active,
.portlet.box.green-haze>.portlet-title>.actions .btn-default:active,
.portlet.box.green-haze>.portlet-title>.actions .btn-default:focus,
.portlet.box.green-haze>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #b9e5e2;
    color: #cbece9
}

.portlet.solid.green-jungle>.portlet-body,
.portlet.solid.green-jungle>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green-jungle>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green-jungle>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green-jungle {
    border: 1px solid #41da9a;
    border-top: 0
}

.portlet.box.green-jungle>.portlet-title>.caption,
.portlet.box.green-jungle>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green-jungle>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #74e4b5;
    color: #8ae8c1
}

.portlet.box.green-soft>.portlet-title,
.portlet.green-soft,
.portlet>.portlet-body.green-soft {
    background-color: #3faba4
}

.portlet.box.green-jungle>.portlet-title>.actions .btn-default>i {
    color: #96ebc8
}

.portlet.box.green-jungle>.portlet-title>.actions .btn-default.active,
.portlet.box.green-jungle>.portlet-title>.actions .btn-default:active,
.portlet.box.green-jungle>.portlet-title>.actions .btn-default:focus,
.portlet.box.green-jungle>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #9feccc;
    color: #b4f0d7
}

.portlet.solid.green-soft>.portlet-body,
.portlet.solid.green-soft>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green-soft>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green-soft>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green-soft {
    border: 1px solid #5bc2bc;
    border-top: 0
}

.portlet.box.green-soft>.portlet-title>.caption,
.portlet.box.green-soft>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green-soft>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #87d3ce;
    color: #9adad6
}

.portlet.box.green-dark>.portlet-title,
.portlet.green-dark,
.portlet>.portlet-body.green-dark {
    background-color: #4DB3A2
}

.portlet.box.green-soft>.portlet-title>.actions .btn-default>i {
    color: #a5deda
}

.portlet.box.green-soft>.portlet-title>.actions .btn-default.active,
.portlet.box.green-soft>.portlet-title>.actions .btn-default:active,
.portlet.box.green-soft>.portlet-title>.actions .btn-default:focus,
.portlet.box.green-soft>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #ade1dd;
    color: #bfe7e5
}

.portlet.solid.green-dark>.portlet-body,
.portlet.solid.green-dark>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green-dark>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green-dark>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green-dark {
    border: 1px solid #71c2b5;
    border-top: 0
}

.portlet.box.green-dark>.portlet-title>.caption,
.portlet.box.green-dark>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green-dark>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #9cd5cb;
    color: #addcd4
}

.portlet.box.green-sharp>.portlet-title,
.portlet.green-sharp,
.portlet>.portlet-body.green-sharp {
    background-color: #2ab4c0
}

.portlet.box.green-dark>.portlet-title>.actions .btn-default>i {
    color: #b8e1da
}

.portlet.box.green-dark>.portlet-title>.actions .btn-default.active,
.portlet.box.green-dark>.portlet-title>.actions .btn-default:active,
.portlet.box.green-dark>.portlet-title>.actions .btn-default:focus,
.portlet.box.green-dark>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #bfe4de;
    color: #d1ebe7
}

.portlet.solid.green-sharp>.portlet-body,
.portlet.solid.green-sharp>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green-sharp>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green-sharp>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green-sharp {
    border: 1px solid #46cbd7;
    border-top: 0
}

.portlet.box.green-sharp>.portlet-title>.caption,
.portlet.box.green-sharp>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green-sharp>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #79d9e2;
    color: #8edfe6
}

.portlet.box.green-steel>.portlet-title,
.portlet.green-steel,
.portlet>.portlet-body.green-steel {
    background-color: #29b4b6
}

.portlet.box.green-sharp>.portlet-title>.actions .btn-default>i {
    color: #9ae3e9
}

.portlet.box.green-sharp>.portlet-title>.actions .btn-default.active,
.portlet.box.green-sharp>.portlet-title>.actions .btn-default:active,
.portlet.box.green-sharp>.portlet-title>.actions .btn-default:focus,
.portlet.box.green-sharp>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #a2e5eb;
    color: #b7ebef
}

.portlet.solid.green-steel>.portlet-body,
.portlet.solid.green-steel>.portlet-title {
    border: 0;
    color: #FFF
}

.portlet.solid.green-steel>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.solid.green-steel>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.green-steel {
    border: 1px solid #3ed1d4;
    border-top: 0
}

.portlet.box.green-steel>.portlet-title>.caption,
.portlet.box.green-steel>.portlet-title>.caption>i {
    color: #FFF
}

.portlet.box.green-steel>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #70dddf;
    color: #85e2e4
}

.portlet.box.grey>.portlet-title,
.portlet.grey,
.portlet>.portlet-body.grey {
    background-color: #E5E5E5
}

.portlet.box.green-steel>.portlet-title>.actions .btn-default>i {
    color: #92e5e6
}

.portlet.box.green-steel>.portlet-title>.actions .btn-default.active,
.portlet.box.green-steel>.portlet-title>.actions .btn-default:active,
.portlet.box.green-steel>.portlet-title>.actions .btn-default:focus,
.portlet.box.green-steel>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #9ae7e8;
    color: #afeced
}

.portlet.solid.grey>.portlet-body,
.portlet.solid.grey>.portlet-title {
    border: 0;
    color: #333
}

.portlet.solid.grey>.portlet-title>.caption>i {
    color: #333
}

.portlet.solid.grey>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.grey {
    border: 1px solid #fff;
    border-top: 0
}

.portlet.box.grey>.portlet-title>.caption,
.portlet.box.grey>.portlet-title>.caption>i {
    color: #333
}

.portlet.box.grey>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #fff;
    color: #fff
}

.portlet.box.grey-steel>.portlet-title,
.portlet.grey-steel,
.portlet>.portlet-body.grey-steel {
    background-color: #e9edef
}

.portlet.box.grey>.portlet-title>.actions .btn-default>i {
    color: #fff
}

.portlet.box.grey>.portlet-title>.actions .btn-default.active,
.portlet.box.grey>.portlet-title>.actions .btn-default:active,
.portlet.box.grey>.portlet-title>.actions .btn-default:focus,
.portlet.box.grey>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #fff;
    color: #fff
}

.portlet.solid.grey-steel>.portlet-body,
.portlet.solid.grey-steel>.portlet-title {
    border: 0;
    color: #80898e
}

.portlet.solid.grey-steel>.portlet-title>.caption>i {
    color: #80898e
}

.portlet.solid.grey-steel>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.grey-steel {
    border: 1px solid #fff;
    border-top: 0
}

.portlet.box.grey-steel>.portlet-title>.caption,
.portlet.box.grey-steel>.portlet-title>.caption>i {
    color: #80898e
}

.portlet.box.grey-steel>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #fff;
    color: #fff
}

.portlet.box.grey-cararra>.portlet-title,
.portlet.grey-cararra,
.portlet>.portlet-body.grey-cararra {
    background-color: #fafafa
}

.portlet.box.grey-steel>.portlet-title>.actions .btn-default>i {
    color: #fff
}

.portlet.box.grey-steel>.portlet-title>.actions .btn-default.active,
.portlet.box.grey-steel>.portlet-title>.actions .btn-default:active,
.portlet.box.grey-steel>.portlet-title>.actions .btn-default:focus,
.portlet.box.grey-steel>.portlet-title>.actions .btn-default:hover {
    border: 1px solid #fff;
    color: #fff
}

.portlet.solid.grey-cararra>.portlet-body,
.portlet.solid.grey-cararra>.portlet-title {
    border: 0;
    color: #333
}

.portlet.solid.grey-cararra>.portlet-title>.caption>i {
    color: #333
}

.portlet.solid.grey-cararra>.portlet-title>.tools>a.fullscreen {
    color: #fdfdfd
}

.portlet.box.grey-cararra {
    border: 1px solid #fff;
    border-top: 0
}

.portlet.box.grey-cararra>.portlet-title>.caption,
.portlet.box.grey-cararra>.portlet-title>.caption>i {
    color: #333
}

.portlet.box.grey-cararra>.portlet-title>.actions .btn-default {
    background: 0 0!important;
    border: 1px solid #fff;
    color: #fff
}

.portlet.box.grey-gallery>.portlet-title,
.portlet.grey-gallery,
.portlet>.portlet-body.grey-gallery {
    background-color: #555
}

.portlet.box.grey-cararra>.portlet-title>.actions .btn-default>i {
    color: #fff
}

/* .portlet.box.grey-cararra>.portlet-title>.actions .btn-default.active,
.portlet.box.grey-cararra>.portlet-title>.actions .btn-default:active,
.portlet.box.grey-cararra>.portlet-title>.actions .btn-defau */
</style>

@stop
