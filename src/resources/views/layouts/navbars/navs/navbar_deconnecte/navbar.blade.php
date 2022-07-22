<?php
      // On recupere l'URL de la page pour ensuite affecter class = "active" aux liens de nav
      $page = $_SERVER['REQUEST_URI'];
      $page = str_replace("/", "",$page);
    //   echo $page;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-primary" id="bare">
    <section class="container-fluid">
        <a class="nav-link nav-item barColor" href="#" id="link0"><img class="roundedImage roundedImageShadow roundedImageBorder img-responsive rounded-circle logo" src="{{URL::asset('img/logo.png')}}"></a>
        <a class="nav-link nav-item barColor" <?php if($page == "home"){echo 'id="active"';} ?> href="home"><i class="fas fa-home"></i> home</a>
        <a href="register" class="nav-item sign barColor" <?php if($page == "register"){echo 'id="active"';} ?>><i class="fa fa-user-plus fa-fw mr-1"></i> Sign up</a>
        <a href="login" class="nav-item log mr-4 barColor" <?php if($page == "login"){echo 'id="active"';} ?>><i class="fas fa-sign-in-alt"></i> Sign in</a>
    </section>
</nav>
