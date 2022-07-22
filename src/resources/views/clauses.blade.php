<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css"/>
    <title>Legal notice & privacy policy</title>
  </head>
  <body style="background-color:#e7e7e7;">
    <div class="container">
      <h1 class="text-primary text-center" style="margin-top:20px;">Legal notice & privacy policy</h1>
    
      <hr>
      <br>
      @if(Session::has('profile'))
        @if(Session::get('profile') != "user")

      <div class="row">
        <div class="col-xs-12 col-md-4">
          <h4>Website editor  :</h4>
          <p>
            Editorial manager: Aboutir Emploi - Jean-Marc BOUTINEAU
            <br>
            Address : 303 Avenue Jean Guiton - 17000 La Rochelle - France
            <br>
            Telephone : 05 46 30 63 06
            <br>
            E-mail : <a href="mailto:#">contact@aboutiremploi.fr</a>
          </p>
        </div>
        <div class="col-xs-12 col-md-4">
          <h4>Hosting :</h4>
          <p>
            Host: OVH France
            <br>
            Address: 2 rue Kellermann - 59100 ROUBAIX
            <br>
            Website: <a href="#">www.ovh.com/fr</a>
          </p>
        </div>
        <div class="col-xs-12 col-md-4">
          <h4> Development : </h4>
          <p>
            Montgomery Ouest
            <br>
            Address: 8 rue de la Bonette - 17000 LA ROCHELLE
            <br>
            Website : <a href="#">www.montgomery-ouest.com</a>
          </p>
        </div>
      </div>
      <br>
      
        @endif
      @endif
      <div class="row">
        <div class="col-xs-12 col-md-6">
          <h2 class="text-primary"> Legal Notice </h2>
          <br>
          <p>
            Please read carefully the various terms and conditions of the legal notices for use of this site before browsing its pages. By connecting to this site, you accept without reservation the present terms and conditions in accordance with article n°6 of the Law n°2004-575 of 21 June 2004 for confidence in the digital economy.
          </p>  
          <br>
          <h4>Terms of use</h4>
          This site (www.aboutiremploi.fr) is offered in different web languages (HTML, HTML5, Javascript, CSS, etc...) for a better comfort of use and a more pleasant graphics, we recommend you to use modern browsers like Safari, Firefox, Google Chrome, etc...
          The legal notices were generated on the Legal Notice Generator site, offered by Welye.

          Aboutir Emploi uses all the means at its disposal to ensure reliable information and a reliable update of its websites. However, errors or omissions may occur. The Internet user must therefore ensure that the information is accurate and report any changes to the site that he or she considers useful. Aboutir Emploi is in no way responsible for the use made of this information, and for any direct or indirect prejudice that may result from it.
        </div>
        <div class="col-xs-12 col-md-6">
          <h2 class="text-primary"> Privacy Policy</h2>
          <br>
          <p>
            In the context of the implementation of the new Regulation on the Protection of Personal Data (RGPD) from 25 May 2018, the companies ABOUTIR EMPLOI and TRANSPARENCE RH wish to present its personal data privacy policy.
            This document is available on our website www.aboutiremploi.fr or on request at: acettrgpd@orange.fr
          </p>
          <br>
          <h4>Our commitment to privacy</h4>
          We do everything possible to protect your data, and we are committed to ensuring the highest level of security and confidentiality, in accordance with the applicable French and European regulations (Regulation 2016/679/EU and Law n° 78-17 of 6 January 1978).
          In this document, we present our policy on the information, collection and processing of your personal data and the procedures for accessing, modifying, deleting and portability of your data.
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-xs-12 col-md-4"></div>
        <div class="col-xs-12 col-md-4 text-center">
            <form method="post" action="/preview/clauses/validation">
              @csrf
              <div class="input-field">
                <input type="checkbox" class="form-check-input" name="location" id="location" required> 
                <label for="location" class="form-check-label">Accept the confidentiality clauses</label>
              </div>
              <input type="hidden" name="lat" id="lat"/> 
              <input type="hidden" name="lng" id="lng"/>
              <div class="mt-3">
                <button class="btn btn-primary" name="submit" id="submit" type="submit">Home</button>
                <a href="/" class="ml-3"><button class="btn btn-secondary" type="button">Cancel</button></a>
              </div>
            </form>
        </div>
        <div class="col-xs-12 col-md-4"></div>
      </div>
      <br>
    </div>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery-3.6.0.min.js"></script>
    <script>

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
                      info += "Access refused to site";
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
          
    </script>
  </body>
</html>

