@extends('admin.layouts.skeleton')
@section('title', 'Stock')
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
        <li class="nav-item active">
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

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Product <?php if (isset($nametype)) echo '- '.$nametype; else echo '' ; ?></h1> 
</div>

@if(Session::has('message'))
    <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
        {{ Session::get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <form action="/admin/stock/type" method="post" enctype="multipart/form-data" class="form-horizontal row-border">
        <div class="col-sm-12">

            <label>Display according to the Type</label>        
            <div class="row">
                <div class="col-9">
                    @csrf
                    <select name="type" id="type" class="form-control"> 
                      <?php 
                            if(isset($nametype)){ ?>

                            <option value="<?= $nametype?>"><?= $nametype ?></option>
                            <option value="all">All</option> 
                      <?php     
                                foreach($types as $type){

                                    if($type['name'] != $nametype){
                        ?>
                                        <option value="<?= $type['name']?>"><?= $type['name']?></option>
                        <?php 
                                    }
                                }
                            }else{ ?>

                                <option value="all">All</option> 

                        <?php        
                                foreach($types as $type){ ?>

                                    <option value="<?= $type['name']?>"><?= $type['name']?></option>
                        <?php       
                                }

                            }
                        ?> 
                    </select>
                </div>
                
                <div class="col-2">
                    <button class="btn-sm btn-success" type="submit">Proceed</button>
                </div>
            </div>

        </div>

    </form>
</div>

<div class="row">
    <br>
    <br>
    <br>
</div>

    <?php 

        if(isset($materials)){ ?>

<div class="row">
    
<?php        

            $data = $materials['result'];  //table informations returned
            $allmaterials = $data['docs']; //table of materials

            $totalDocs = $data['totalDocs']; //number of materials in the database
            $limit = $data['limit']; // limit of materials on a page
            $totalPages = $data['totalPages']; //number of pages 
            $page = $data['page']; //current page
            $pagingCounter = $data['pagingCounter']; //paging counter
            $hasPrevPage = $data['hasPrevPage']; //boolean if previous page exists
            $hasNextPage = $data['hasNextPage']; //boolean if next page exists
            $prevPage = $data['prevPage']; //index of the previous page
            $nextPage = $data['nextPage']; //index of the next page

            if(empty($hasPrevPage)){
                $hasPrevPage = 0;
            }

            if(empty($hasNextPage)){
                $hasNextPage = 0;
            }

            if(empty($prevPage)){
                $prevPage = 0;
            }

            if(empty($nextPage)){
                $nextPage = 0;
            }

            // print_r($allmaterials);
            // echo $totalDocs,$totalPages,$limit,$page,$pagingCounter,$hasPrevPage,$hasNextPage,$prevPage,$nextPage;

            foreach ($allmaterials as $material){

    ?>

        <div class="col-md-6 col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-success">

                    <h6 class="m-0 font-weight-bold text-white" style="font-size:25px;"><?= $material['name'] ?>

                    <a href="#productModal" data-toggle="modal" data-target="#productModal" edit="<?= $material['_id'] ?>" class="btn bg-success float-right productModal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                        <span class="icon"  style="color:white;">
                            <i class="fas fa-edit"></i>
                        </span>
                    </a>

                    </h6>
                </div>
                <div class="card-body text-center">
                    <img class="img-profile rounded-circle w-75" src="<?= url('storage/'.$material['picture'])?>" />
                    <hr /> 
                    <div class="float-left">
                        <h5><b>Quantity : </b><?= $material['quantity']?></h5>
                    </div>
                    <div class="float-right">
                        <h5><b>Unit : </b><?= $material['prixUnit']?></h5>
                    </div>
                </div>
            </div>
        </div>

    <?php 
            } 
    ?>

</div>


<div class="row">

    <div class="container">

        <div class="float-right">

            <?php 

                //previous page 
                if($hasPrevPage == 0){
                    $prevDisabled = 'disabled';
                    $prevAriadisabled = 'true';
                    $prevHref = '#';
                }else{
                    $prevDisabled = '';
                    $prevAriadisabled = '';
                    $prevHref = '/admin/stock/'.$prevPage;
                }

                //next page
                if($hasNextPage == 0){
                    $nextDisabled = 'disabled';
                    $nextAriadisabled = 'true';
                    $nextHref = '#';
                }else{
                    $nextDisabled = '';
                    $nextAriadisabled = '';
                    $nextHref = '/admin/stock/'.$nextPage ;
                }

            ?>

             <!-- Pagination -->
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item <?= $prevDisabled?>">
                      <a class="page-link" href="<?=$prevHref?>" aria-label="Previous" aria-disabled="<?=$prevAriadisabled?>">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <?php 
                        // for($i=1; $i<=$totalPages; $i++){

                        //     if($page == $i){
                        //         $active = 'active';
                        //         $ariacurrent = 'page'; 
                        //     }else{
                        //         $active = '';
                        //         $ariacurrent = '';
                        //     }
                         // }
                    ?>
                    <li class="page-item active" aria-current="page"><a class="page-link" href="/admin/stock/<?= $page ?>"><?= $page ?></a></li>
                    
                    <li class="page-item <?=$nextDisabled?>">
                      <a class="page-link" href="<?= $nextHref ?>" aria-label="Next" aria-disabled="<?=$nextAriadisabled?>">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>

        </div>

    </div>
    
</div>
<?php } ?>

<!-- Second part :  Materials according to the type  -->

<?php
    
        if (isset($typeMaterials)){ ?>

 <div class="row">

<?php
            $data = $typeMaterials['result'];  //table informations returned
            $allmaterials = $data['docs']; //table of materials

            foreach ($allmaterials as $material){
?>

        <div class="col-md-6 col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-success">

                    <h6 class="m-0 font-weight-bold text-white" style="font-size:25px;"><?= $material['name'] ?>

                    <a href="#productModal" data-toggle="modal" data-target="#productModal" edit="<?= $material['_id'] ?>" class="btn bg-success float-right productModal" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                        <span class="icon"  style="color:white;">
                            <i class="fas fa-edit"></i>
                        </span>
                    </a>

                    </h6>
                </div>
                <div class="card-body text-center">
                    <img class="img-profile rounded-circle w-75" src="<?= url('storage/'.$material['picture'])?>" />
                    <hr /> 
                    <div class="float-left">
                        <h5><b>Quantity : </b><?= $material['quantity']?></h5>
                    </div>
                    <div class="float-right">
                        <h5><b>Unit : </b><?= $material['prixUnit']?></h5>
                    </div>
                </div>
            </div>
        </div>

    <?php 
            } 
    ?>

</div>

<?php } 

?>

<!-- UPDATE PRODUCT MODAL -->

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update a product </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/admin/stock/update" class="user" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <input type="hidden" id="id" name="id"  value="">
                        
                        <div class="form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" placeholder="Enter your product name" value="" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div> 
                        <div class="form-group">
                            <select name="type" id="type" class="form-control">
                                <?php 
                                    foreach($types as $type){
                                ?>
                                    <option value="<?= $type['_id']?>"><?= $type['name']?></option>
                                <?php 
                                    }
                                ?>  
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" placeholder="Quantity" value="" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control @error('unitprice') is-invalid @enderror"
                                id="unitprice" name="unitprice" placeholder="Unit price" value="" required>
                                @error('unitprice')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" placeholder="Enter the description of the product" value="" required>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image" placeholder="Enter your image">
                            <input type="hidden" name="oldimage" id="oldimage" value="">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        
                        <hr>
                        <div class="row float-right mt-3">
                            <a href="#">
                                <button href="#" class="btn btn-primary btn-user" name="submit" type="submit">
                                    Proceed
                                </button>
                            </a>
                            <a href="#">
                                <button class="btn btn-secondary btn-user ml-2" type="button" data-dismiss="modal">Cancel</button>
                            </a>
                        </div>
                    </form>
                    
                </div>
               <!--  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" type="submit" id="edit" href="#">Proceed</a>
                </div> -->
            </div>
       </div>
</div>


<script>
    $(document).ready(function() {
        $("body").on('click', '.productModal', function(event) {
            event.preventDefault();
            // body...
            var id = $(this).attr('edit');  

            <?php

                $alltoken = $_COOKIE['token'];
                $alltokentab = explode(';', $alltoken);
                $token = $alltokentab[0];
                $tokentab = explode('=',$token);
                $tokenVal = $tokentab[1];
                $Authorization = 'Bearer '.$tokenVal;
            ?>
                    
            $.ajax({

                url: "<?= 'http://172.17.0.2:4000/stock/' ?>" + id,
                headers: { 'Authorization': '<?= $Authorization ?>', 'Content-Type': 'application/json' },

                success: function(success) {
                    // var obj = $.parseJSON(success);
                    var obj = success;
                    // var result = JSON.stringify(obj.result);
                    var result = obj['result'];
                    // console.log(result['_id']);
                    //console.log(obj['result']);
                    $("#id").val(result['_id']);
                    $("#name").val(result['name']);
                    $("#type").val(result['type']);
                    $("#quantity").val(result['quantity']);
                    $("#unitprice").val(result['prixUnit']);
                    $("#description").val(result['description']);
                    $("#oldimage").val(result['picture']);
                }

            
            })
                
        })
    });
</script>

@stop