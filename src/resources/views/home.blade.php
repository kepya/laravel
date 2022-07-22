<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Georgia';
            }
        </style>

        <!-- Link css -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap_css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">
        <!-- link js -->
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
        <script src="https://kit.fontawesome.com/7328ff3444.js" crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
        <header>
            @include('layouts.navbars.navbar')
        </header>
        <main class="mb-1">
            <!-- Carousel -->
            <!-- <section class="container-fluid"> -->
            <div id="carouselExampleIndicators" class="carousel slide carosel" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ URL('img/bg2.jpg')}}" height="650px" alt="First slide">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block w-100" src="{{ URL('img/bg1.jpg')}}" height="650px" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                    <img class="d-block w-100" src="{{ URL('img/bg3.jpg')}}" height="650px" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <hr class="noscreen mb-0 mt-0 bare_separation" />
            <!-- </section> -->
            <section class="grid mb-0 mt-0" style="display: block;">
                <section class="align-self-center">
                    <h1 class="flex justify-center">Présentation du projet</h1>
                </section>
                <section class="pr-3 pl-3">
                    <p>Notre projet à pour but de controller l'eau d'un forage en vous proposant un service de gestion de votre installation</p>
                    <!-- <ul>
                        <li>le client à la possiblilité de demander une installation</li>
                        <li>le client à la possiblilité de prendre etat sa consommation mensuelle et de la payer</li>
                        <li>le client à la possibiliter de faire par au propriétaire des pannes</li>
                    </ul> -->
                    <section class="pr-3 pl-3 card-deck mb-2">
                        <section class="card linear-gradient" style="height: 450px;">
                            <object type="image/svg+xml" data="{{ URL('img/undraw_Questions_re_1fy7.svg')}}" height="500" class="svgImg">
                                Le navigateur ne peut lire ce kiwi
                            </object>
                            <p style="text-align: right;font-weight: bold;">le client à la possiblilité de demander une installation</p>
                        </section>
                        <section class="card linear-gradient" style="height: 450px;">
                            <object type="image/svg+xml" data="{{ URL('img/undraw_add_to_cart_vkjp.svg')}}" height="500" class="svgImg">
                                Le navigateur ne peut lire ce kiwi
                            </object>
                            <p class="posText">le client à la possiblilité de prendre etat sa consommation mensuelle et de la payer</p>
                        </section>
                        <section class="card linear-gradient" style="height: 450px;">
                            <object type="image/svg+xml" data="{{ URL('img/undraw_Notify_re_65on.svg')}}" height="500" class="svgImg">
                                Le navigateur ne peut lire ce kiwi
                            </object> 
                            <p class="posText">le client à la possibiliter de faire par au propriétaire des pannes</p>
                        </section>
                    </section>
                </section>
            </section>
            <section class="grid mb-0 mt-0">
                <section class="align-self-center">
                    <section class="flex">
                        <hr class="block bg-secondary align-self-center" width="50%">
                        <div class="roundedImage roundedImageShadow roundedImageBorder img-responsive rounded-circle logo"></div>
                        <hr class="block bg-secondary align-self-center" width="50%">
                    </section>
                </section>
            </section>
            <section class="mb-2 mt-2">
                <section class="grid mb-0 mt-0">
                    <section class="align-self-center">
                        <h3 class="flex justify-center">Notre Team</h3>
                    </section>
                    <!-- card-deck OU card-group-->
                    <!-- <section class="pr-3 pl-3 card-deck mb-2">
                        <section class="card round">
                            <img src="" alt="" srcset="" width="300">
                            <h1 class="flex justify-center">Sipoufo Yvan</h1>
                            <p>Futur développeur, toujours à la recherche de la connaissance, passioné par le deep learning, la programmation. suis un jeune entrepreneur donc l'objectif est de developper l'afrique central</p>
                        </section>
                        <section class="card round">
                            <img src="{{ URL('img/thirten_eight.png')}}" alt="" srcset="" width="300">
                            <h1 class="flex justify-center">Feyom Bryan</h1>
                            <p>suis une jeune entrepreneur à la recherche du savoir passioné du réseau, suis un gar cool sympa et travailleur qui a pour principal but d'oevrer pour le developpement</p>
                        </section>
                        <section class="card round">
                            <img src="" alt="" srcset="" width="300">
                            <h1 class="flex justify-center">Christian Kepya</h1>
                            <p>Futur développeur, passioné par la programmation et la creation des jeux videos à la recherche constante du progres</p>
                        </section>
                    </section> -->
                </section>
            </section>
            <hr class="noscreen mb-0 mt-0 bare_separation" />
            <section class="grid mb-0 mt-0">
                <section class="align-self-center">
                    <h1 class="flex justify-center">Nous contacter</h1>
                </section>
                <section class="pr-3 pl-3 card-deck mb-2">
                    <section class="card linear-gradient" style="height: 500px;">
                        <object type="image/svg+xml" data="{{ URL('img/i2.svg')}}" height="500" class="sv">
                            Le navigateur ne peut lire ce kiwi
                        </object>
                        <div class="small-cercle"></div>
                    </section>
                    <section class="card cache col linear-gradient">
                        <h6 class="pl-3">Notre Démarche</h6>
                        <h3 class="card-title pl-3">Nous sommes à votre écoute</h3>
                        <p class="pl-3">il est important que tout client souhaitant soucrire à nos service sache comment nous fonctionnons</p>
                        <section class="flex">
                            <section class="pl-3">
                                <h3>Recueil des informations</h3>
                                <p>Nous situons votre domicile</p>
                                <h3>Enregistrement</h3>
                                <p>Nous vous enregistrons comme client</p>
                                <h3>Suivie</h3>
                                <p>Nous vous accordons une maintenance pendant 2mois du système</p>
                            </section>
                            <section>
                                <h3>Analyse</h3>
                                <p>Nous validons vos demandes d'adhésion</p>
                                <h3>Installations</h3>
                                <p>Nous intallons votre système de gestion</p>
                                <h3>Notification</h3>
                                <p>Nous vous notifion en cas de changement ou de modification survenue</p>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
            <hr class="noscreen mb-0 mt-0 bare_separation" />
        </main>
        <footer class="bg-primary">
            <section class="grid mb-0 mt-0">
                <section class="align-self-center">
                    <h1 class="flex justify-center">footer</h1>
                </section>
            </section>
        </footer>
        <!-- Link js -->
        <script type="text/javascript" src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap_js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
