<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Forage - My Bills </title>
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/facture.css" />
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
    </head>

    <body class="bodyhome">
        
        <nav class="navbar navbar1 navbar-expand-lg bg-dark">
                                            <!-- navbar-light -->
            <div class="container-fluid">

                <a class="navbar-brand" href="#"><h4 class="band">Forage</h4></a>

                <div class="mx-auto order-2" id="consommationNavbarNavAltMarkup">
                        <a class="navbar-brand mx-auto active " aria-current="page" href="#"><h6 class="band">Consommation</h6></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#consommationNavbarNavAltMarkup" aria-controls="#consommationNavbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                </div>
                <div class="mx-auto order-3" id="NavbarNavAltMarkup">
                        <a class="navbar-brand mx-auto" aria-current="page" href="#"><h6 class="band">Reçus</h6></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#NavbarNavAltMarkup" aria-controls="#NavbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                </div>
                
            </div>
        </nav>

        <nav class="navbar navbar2 navbar-expand-lg navbar-light bg-dark">

            <div class="container-fluid">

                <a class="navbar-brand" href="#"><h4 class="band">Forage</h4></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#consommationNavbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="consommationNavbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="#"><h6 class="band">Consommation</h6></a>
                    <a class="nav-link" href="#"><h6 class="band">Reçus</h6></a>
                </div>
                </div>

            </div>

        </nav>

        <section>

            <div class="container">

                <div class="row">

                    <div class="col-xs-12 col-md-4"></div>
                    <div class="col-xs-12 col-md-4">

                            <div class="profile-pic-div">
                                <img src="/images/facture/bryan.jpg " id="photo">
                                <input type="file" id="file">
                                <label for="file" id="uploadBtn">Choose Photo</label>
                            </div>

                            <div class="sh-info">
                            
                                <button class="btn btn-outline-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Show my informations</button>

                                <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    <p><b class="card-text card-text-one">Name :</b> ??? </p>
                                    <hr class="line">
                                    <p><b class="card-text card-text-two"> N° of Bills :</b> ??? </p>
                                </div>

                                </div>
                            
                            </div>
                    </div>
                    <div class="col-xs-12 col-md-4"></div>

                </div>
                      <!-- row no-gutters -->
                      <!--  img - class="img-fluid" -->        
                      <!-- //px-5 pt-5 -->                      
                      <!-- // form type text - my-3 p-4 -->
            </div>
        </section>

        <section class="facture-bloc">
            
            <div class="facture-bloc-heading">

                <h2 class="facture-bloc-title"> MY BILLS </h2> 
                <form method="" action="">
                <input class="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-search btn-warning" type="submit">Search</button>
                </form>

            </div>

            <div class="bloc-1"></div>

            <div class="bloc-2">

                <div class="facture-1">

                    <div class="facture-bloc-text">

                        <p class="facture-text-one"><b>Period : </b>????</p>
                        <hr class="line-two">
                        <p class="facture-text-two"><b>Amount : </b>?????</p>

                        <button class="btn btn-1-facture btn-dark" type="button" aria-expanded="false">
                        Details</button>

                        <button class="btn btn-sm btn-fac-1-sec btn-dark" type="button" aria-expanded="false">
                        Details</button>

                        <button class="btn btn-success btn-facture-1-paiement" type="button" aria-expanded="false">
                        Payer</button>

                        <button class="btn btn-sm btn-success btn-fac-1-pay-sec" type="button" aria-expanded="false">
                        Payer</button>


                    </div>
                </div>

                <div class="details-facture-1">

                    <div class="details-facture-bloc-text">

                        <h2 class="details-facture-bloc-text-title">BILL</h2>
                        <hr>
                        <p><b>Name : </b>????</p>
                        <hr>
                        <p><b>Period : </b>????</p>
                        <hr>
                        <p><b>Amount : </b>?????</p>
                        <hr>
                        <p><b>Tel : </b>?????</p>
                        <hr>
                        <p><b>Proprietor : </b>?????</p>

                        <button class="btn btn-dark btn-facture-1-close" type="button" aria-expanded="false">
                        Close</button>

                        <button class="btn btn-dark btn-sm btn-fac-1-close" type="button" aria-expanded="false">
                        Close</button>

                    </div>
                </div>

                <div class="facture-2">

                    <div class="facture-bloc-text">

                        <p class="facture-text-one"><b>Period : </b>????</p>
                        <hr class="line-two">
                        <p class="facture-text-two"><b>Amount : </b>?????</p>

                        <button class="btn btn-2-facture btn-dark" type="button" aria-expanded="false">
                        Details</button>

                        <button class="btn btn-sm btn-fac-2-sec btn-dark" type="button" aria-expanded="false">
                        Details</button>

                        <button class="btn btn-success btn-facture-2-paiement" type="button" aria-expanded="false">
                        Payer</button>

                        <button class="btn btn-sm btn-success btn-fac-2-pay-sec" type="button" aria-expanded="false">
                        Payer</button>

                    </div>
                    
                </div>

                <div class="details-facture-2">

                    <div class="details-facture-bloc-text">

                        <h2 class="details-facture-bloc-text-title">BILL</h2>
                        <hr>
                        <p><b>Name : </b>????</p>
                        <hr>
                        <p><b>Period : </b>????</p>
                        <hr>
                        <p><b>Amount : </b>?????</p>
                        <hr>
                        <p><b>Tel : </b>?????</p>
                        <hr>
                        <p><b>Proprietor : </b>?????</p>

                        <button class="btn btn-dark btn-facture-2-close" type="button" aria-expanded="false">
                        Close</button>

                        <button class="btn btn-dark btn-sm btn-fac-2-close" type="button" aria-expanded="false">
                        Close</button>

                    </div>
                </div>

                <div class="facture-3">

                    <div class="facture-bloc-text">

                        <p class="facture-text-one"><b>Period : </b>????</p>
                        <hr class="line-two">
                        <p class="facture-text-two"><b>Amount : </b>?????</p>

                        <button class="btn btn-3-facture btn-dark" type="button" aria-expanded="false">
                        Details</button>

                        <button class="btn btn-sm btn-fac-3-sec btn-dark" type="button" aria-expanded="false">
                        Details</button>

                        <button class="btn btn-success btn-facture-3-paiement" type="button" aria-expanded="false">
                        Payer</button>

                        <button class="btn btn-sm btn-success btn-fac-3-pay-sec" type="button" aria-expanded="false">
                        Payer</button>

                    </div>
  
                </div>

                <div class="details-facture-3">

                    <div class="details-facture-bloc-text">

                        <h2 class="details-facture-bloc-text-title">BILL</h2>
                        <hr>
                        <p><b>Name : </b>????</p>
                        <hr>
                        <p><b>Period : </b>????</p>
                        <hr>
                        <p><b>Amount : </b>?????</p>
                        <hr>
                        <p><b>Tel : </b>?????</p>
                        <hr>
                        <p><b>Proprietor : </b>?????</p>

                        <button class="btn btn-dark btn-facture-3-close" type="button" aria-expanded="false">
                        Close</button>

                        <button class="btn btn-dark btn-sm btn-fac-3-close" type="button" aria-expanded="false">
                        Close</button>

                    </div>
                </div>



            </div>

            <div class="bloc-3"></div>

            </div>

        </section>

        <!-- JS -->
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/facture.js"></script>
    </body>
</html>