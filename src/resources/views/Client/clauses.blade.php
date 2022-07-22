@extends('admin.layouts.skeleton')
@section('title', 'Add a Customer')
@section('nav')
        <li class="nav-item">
            <a class="nav-link" href="/home">
            <i class="fas fa-home"></i>
            <span>Home</span></a
            >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Information</div>

        <!-- Nav Item - consumption -->
        <li class="nav-item ">
            <a class="nav-link collapsed"  href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Budget</span>
            </a>
            <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities1" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Budget</h6>
                    <a class="collapse-item" href="/budget-stat" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices paid">statistics</a>
                    <a class="collapse-item" href="/budget-detail" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices unpaid">Details</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Invoice -->
        <li class="nav-item ">
            <a class="nav-link collapsed"  href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices">
                <i class="fas fa-money-bill-alt"></i>
                <span>Invoices</span>
            </a>
            <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities1" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Invoices</h6>
                    <a class="collapse-item" href="/invoices_paid" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices paid">Invoices Paid</a>
                    <a class="collapse-item" href="/unpaid_invoices" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices unpaid">Unpaid Invoices</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Profile Setting -->
        @if(Session::has('status'))
            @if(Session::get('status') != 0)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="/user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profile">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Profile Setting</span>
                    </a>
                </li>
            @endif
        @endif

        <!-- Nav Item - Policy -->
        <li class="nav-item active">
            <a class="nav-link collapsed" href="/clauses" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profile">
            <i class="fas fa-list"></i>
            <span>Confidentiality Clauses</span>
            </a>
        </li>

        <!-- Nav Item - Log out -->
        <li class="nav-item ">
            <a class="nav-link collapsed"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Log Out" href="/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log out</span>
            </a>
        </li>
@stop
@section('content')

    <div class="container">
      <h1 class="text-primary text-center" style="margin-top:20px;">Privacy policy</h1>

      <hr>
      <br>
      <div class="row">
        <div class="col-md-8 offset-md-3">
          {{-- <h4>Hosting :</h4>
          <p>
            Host: OVH France
            <br>
            Address: 2 rue Kellermann - 59100 ROUBAIX
            <br>
            Website: <a href="#">www.ovh.com/fr</a>
          </p> --}}
          <p>
            This policy applies to the : <b>M. Tanguy Kuate</b>
            <br>
            Tel : <b>+237 697752242</b>
            <br>
            Date of last update : <b>21 August 2021</b>
          </p>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-10 offset-1 text-center">
          <p>
            Your privacy is of the utmost importance to <b>M. Tanguy Kuate</b>, who is responsible for this site.
          </p>
          <br>
      </div>
      <div class="row">
        <div class="col-md-6 text-center">
          <h4 class="text-primary">
            The purpose of this privacy policy is to explain to you:
          </h4>
          <br>
          <ul class="text-left">
            <li>How your personal information is collected and processed. Personal information is any information that can identify you. This includes your first and last name, your age, your postal address, your e-mail address and your location;</li>
            <li>What are your rights regarding this information;</li>
            <li>Who is responsible for processing the personal information collected and processed?</li>
            <li>To whom this information is provided ;</li>
          </ul>
        </div>
        <div class="col-md-4 offset-2">
          <h4 class="text-primary text-center">
            Personal information collected:
          </h4>
          <br>
          <ul class="text-left">
            <li>Name</li>
            <li>Postal address</li>
            <li>E-mail adresse</li>
            <li>Phone number</li>
            <li>Geolocation data</li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div>
          <p class="text-center">
            "The personal information we collect is collected through the collection methods described below, in the "Forms and Collection Methods" and following sections".
          </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h4 class="text-primary text-center">
            purpose of collecting your informations:
          </h4>
          <br>
          <ul class="text-left">
            <li>Statistics;</li>
            <li>Contact;</li>
          </ul>
        </div>
        <div class="col-md-6">
          <h4 class="text-primary text-center">
            Sharing of personal information:
          </h4>
          <br>
          <p>
            We will not sell to third parties or generally market the personal information collected.
          </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h4 class="text-primary text-center">
            Duration of retention of personal information:
          </h4>
          <br>
          <p>
            The data controller will keep all personal information collected in its computer systems on the site under reasonable security conditions for an unlimited period of time
          </p>
        </div>
        <div class="col-md-6">
          <h4 class="text-primary text-center">
            Hosting of personal information:
          </h4>
          <br>
          <p>
            Our site is hosted by <b>Not set</b>, whose registered office is located at the following address: <b>Not set</b>
            <br>
            The host can be contacted on the following telephone number : <b>Not set</b>
            <br>
            The personal information we collect and process is transferred to the following country or countries: Cameroon.
          </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 offset-1">
          <h4 class="text-primary text-center">
            Person responsible for the processing of personal information :
          </h4>
          <br>
          <p>
            The personal information we collect is kept in a secure environment. People working for us are required to respect the confidentiality of your information.
            <br>
            To ensure the security of your personal information, we use the following measure: Phone number/password
          </p>
          <p>
            We are committed to maintaining a high level of privacy by incorporating the latest technological innovations to ensure the confidentiality of your transactions. However, as no mechanism offers maximum security, there is always a degree of risk involved when using the Internet to transmit personal information.
          </p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 offset-1">
          <h4 class="text-primary text-center">
            Security :
          </h4>
          <br>
          <p>
            The controller of personal information <b>Mr. Tanguy Kuate</b> is responsible for determining the purposes and means of processing personal information.
          </p>
          <p>
            The data controller undertakes to protect the personal information collected, not to pass it on to third parties without your knowledge and to respect the purposes for which the information was collected.
            In addition, the data controller undertakes to notify you if your personal information is corrected or deleted. In the event that the integrity, confidentiality or security of your personal information is compromised, the data controller undertakes to inform you by any means.
          </p>
        </div>
      </div>
      <br>
      <br>
    </div>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery-3.6.0.min.js"></script>

@stop

