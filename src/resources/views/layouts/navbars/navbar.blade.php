<!-- je verifie s\'il est conecté -->
@auth()
    @include('layouts.navbars.navs.navbar_connecte.navbar')
@endauth

@guest()
    @include('layouts.navbars.navs.navbar_deconnecte.navbar')
@endguest