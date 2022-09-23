@extends('admin.layouts.skeleton')
@section('title', 'EditCustomer')
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
            <!-- Edit a customer -->
            <!-- <div class="float-right">
                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#accountModal">Edit Customer Account</a>
            </div> -->

            <a href="/admin/customer/edit/resetPasswd/<?= $data['_id']?>" class="btn btn-primary">Reset Password</a>

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



             <form method="post" action="/admin/customer/saveCustomer/<?= $data['_id']?>" class="col-lg-8 offset-lg-2" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="part1" style="display:flex;">
                    <span class="text-danger text-lg mr-2" style="display:flex;align-items:center;justify-content:center;">*</span>
                    <span>Customer Informations</span>
                </div>
                <div class="form-group mt-2">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <input type="number" class="form-control @error('ref_client') is-invalid @enderror" placeholder="ref_ID" id="ref_client" name="ref_client" value="<?= $data['customerReference']?>" required>
                        </div>
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="full name" id="name" name="name" value="<?= $data['name']?>" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row" id="addPhone">
                        <?php
                            if(count($data['phone']) <= 1){ ?>
                                <input type="hidden" name="nbrePhone" id="nbrePhone"  value="<?=count($data['phone'])?>">
                                <div class="form-group col-md-1">
                                    <i class="fas fa-plus ml-2 btn-primary" class="" id="plusPhone" style="display:flex; align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                                </div>
                                <div class="form-group col-md-11" id="form0">
                                    <input type="number" class="form-control" placeholder="phone number" id="phone0" name="phone0" value="<?= !empty($data['phone']) ? $data['phone'][0]: ''?>">
                                </div>
                                <div class="form-group col-md-1" id="minusform0" style="display:none;">
                                    <i class="fas fa-minus ml-3 btn-primary" class="" id="minusPhone" style="display:flex;align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                                </div>
                        <?php
                            }else{ ?>
                                <input type="hidden" name="nbrePhone" id="nbrePhone"  value="<?=count($data['phone'])?>">
                                <div class="form-group col-md-1">
                                    <i class="fas fa-plus ml-2 btn-primary" class="" id="plusPhone" style="display:flex; align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                                </div>
                                <div class="form-group col-md-10" id="form0">
                                    <input type="number" class="form-control" placeholder="phone number" id="phone0" name="phone0" value="<?=$data['phone'][0]?>">
                                </div>
                                <div class="form-group col-md-1" id="minusform0">
                                    <i class="fas fa-minus ml-3 btn-primary" class="" id="minusPhone" style="display:flex;align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                                </div>
                        <?php
                                for ($i=1; $i < count($data['phone']); $i++) { ?>
                                    <div class='form-group col-md-10' style='margin-left:60px;' id='<?='input_phone_'.$i?>'>
                                        <input type='number' class="form-control" placeholder='phone number' id='<?='phone'.$i?>' name='<?='phone'.$i?>' value='<?=$data['phone'][$i]?>'>
                                    </div>
                        <?php
                                }
                            }
                        ?>

                    </div>
                </div>

                <div class="part2">Sites</div>
                <div class="form-group mt-2" id="addHomeMeter">
                    <input type="hidden" name="blocSites" id="blocSites" value="<?=count($data['localisation']['description'])?>">
                    <?php
                        if(count($data['localisation']['description']) <= 1){ ?>
                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <i class="fas fa-plus ml-2 btn-primary" id="plusSites" style="display:flex; align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                                </div>
                                <div class="form-group col-md-3" id="form1">
                                    <input type="text" class="form-control" placeholder="Meter_ID" id="meter0" name="meter0" value="<?= !empty($data['idCompteur']) ? $data['idCompteur'][0] : ''?>">
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control" placeholder="location" id="home0" name="home0" value="<?= !empty($data['localisation']['description']) ? $data['localisation']['description'][0] : ''?>">
                                </div>
                                <div class="form-group col-md-1" id="minusform1" style="display:none;">
                                    <i class="fas fa-minus ml-3 btn-primary" id="minusSites" style="display:flex; align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                                </div>
                            </div>
                        <?php
                        }else{ ?>
                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <i class="fas fa-plus ml-2 btn-primary" id="plusSites" style="display:flex; align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                                </div>
                                <div class="form-group col-md-2" id="form1">
                                    <input type="text" class="form-control" placeholder="Meter_ID" id="meter0" name="meter0" value="<?=$data['idCompteur'][0]?>">
                                </div>
                                <div class="form-group col-md-8">
                                    <input type="text" class="form-control" placeholder="location" id="home0" name="home0" value="<?=$data['localisation']['description'][0]?>">
                                </div>
                                <div class="form-group col-md-1" id="minusform1">
                                    <i class="fas fa-minus ml-3 btn-primary" id="minusSites" style="display:flex; align-items:center; margin-top: 10px; border-radius:50%; height:20px; width:20px; justify-content:center; color:white; cursor:pointer;"></i>
                                </div>
                            </div>
                    <?php
                            for ($i=1;$i<count($data['localisation']['description']);$i++) {?>
                                <div class="form-row" id="<?='blocSites'.$i?>">
                                    <div class="form-group col-md-2" style="margin-left:60px;" >
                                        <input type="text" class="form-control" placeholder="Meter_ID" id="<?='meter'.$i?>" name="<?='meter'.$i?>" value="<?=$data['idCompteur'][$i]?>">
                                    </div>
                                    <div class="form-group col-md-8">
                                        <input type="text" class="form-control" placeholder="location" id="<?='meter'.$i?>" name="<?='home'.$i?>" value="<?=$data['localisation']['description'][$i]?>">
                                    </div>
                                </div>
                        <?php
                            }
                        }
                    ?>
                </div>


                <div class="part3">Subscription</div>
                <div class="form-group mt-2">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="date" class="form-control" id="subs_date" name="subs_date" value="<?= $data['subscriptionDate']?>" placeholder="Date">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" class="form-control" id="subs_amount" name="subs_amount" value="<?= $data['subscriptionAmount']?>" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" placeholder="Observation" id="observation" name="observation" value="<?= $data['observation']?>">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-2">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Image</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                            @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="profileImage" id="profileImage" value="<?= $data['profileImage']?>"/>
                        </div>
                    </div>
                </div>

                <div class="row float-right mt-3">
                    <a href="/admin/customer">
                        <button class="btn btn-secondary" type="button">Cancel</button>
                    </a>
                    <a href="#">
                        <button class="btn btn-primary ml-2" name="submit" type="submit">Proceed</button>
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    var nbrePhone = <?=count($data['phone'])?>;
    var blocSites = <?=count($data['localisation']['description'])?>;

    $("#plusPhone").on("click", function(){
        $("#addPhone").append(
            "<div class='form-group col-md-10' style='margin-left:60px;' id='input_phone_"+nbrePhone+"'>"+
                "<input type='number' class='form-control @error('phone"+nbrePhone+"') is-invalid @enderror' placeholder='phone number' id='phone"+nbrePhone+"' name='phone"+nbrePhone+"' value='{{ old('phone"+nbrePhone+"') }}'>"+
                "@error('phone"+nbrePhone+"')"+
                        "<div class='invalid-feedback'>{{ $message }}</div>"+
                "@enderror"+
            "</div>"
        );
        if($("#form0").hasClass('col-md-11')){
            $("#form0").removeClass('col-md-11').addClass('col-md-10');
            $('#minusform0').css('display', 'flex');
        }
        nbrePhone+=1;
        $("#nbrePhone").val(nbrePhone);
    });

    $('#minusPhone').on("click",function(){
        nbrePhone-=1;
        $("#input_phone_"+nbrePhone).remove();
        if(nbrePhone==1){
            $("#form0").removeClass('col-md-10').addClass('col-md-11');
            $('#minusform0').css('display', 'none');
        }
        $("#nbrePhone").val(nbrePhone);
    });

    $("#plusSites").on("click", function(){
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
        if($("#form1").hasClass('col-md-3')){
            $("#form1").removeClass('col-md-3').addClass('col-md-2');
            $('#minusform1').css('display', 'flex');
        }
        blocSites+=1;
        $("#blocSites").val(blocSites);
    });

    $('#minusSites').on("click",function(){
        blocSites-=1;
        $("#blocSites"+blocSites).remove();
        if(blocSites==1){
            $("#form1").removeClass('col-md-2').addClass('col-md-3');
            $('#minusform1').css('display', 'none');
        }
        $("#blocSites").val(blocSites);
    });

</script>

@stop

