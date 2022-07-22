@if (auth() -> user() -> promotion === "membreBde")
	@include('layouts.navbars.navs.navbar_connecte.navbar_admin.navbar')
@elseif (auth() -> user() -> promotion === "salarie")

@else
	@include('layouts.navbars.navs.navbar_connecte.navbar_user.navbar')
@endif