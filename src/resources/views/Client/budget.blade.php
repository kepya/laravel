@extends('Client.layout.default')
    @section('title', 'Consumption')
    @section('nav')
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home">
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
        <li class="nav-item active">
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

        <!-- Nav Item - Profile Setting -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profile">
            <i class="fas fa-fw fa-cog"></i>
            <span>Profile Setting</span>
            </a>
        </li>

        <!-- Nav Item - Policy -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/clauses" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profile">
            <i class="fas fa-list"></i>
            <span>Confidentiality Clauses</span>
            </a>
        </li>

        <!-- Nav Item - Log out -->
        <li class="nav-item">
            <a class="nav-link collapsed"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Log Out" href="/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log out</span>
            </a>
        </li>

@stop
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Budget-Statistic</h1>
        {{-- <a href="#" class="btn btn-info btn-icon-split col-md-12 col-lg-2 offset-lg-5 mr-3">
            <span class="icon text-white-50">
                <i class="fas fa-info-circle"></i>
            </span>
            <span class="text">Monthly</span>
        </a>
        <a href="#" class="btn btn-success btn-icon-split col-md-12 col-lg-2 offset-lg-0">
            <span class="icon text-white-50">
                <i class="fas fa-check"></i>
            </span>
            <span class="text">Yearly</span>
        </a> --}}
    </div>

    <div class="row">
        <!-- Detail Part -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chartdiv"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

<!-- Styles -->
<style>
    #chartdiv {
      width: 100%;
      height: 500px;
    }

    </style>

    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    <!-- Chart code -->
    <script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart);

    // Add data
    data = JSON.parse('<?= $data ?>')
    chart.data = data;

    // Create axes
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    //dateAxis.renderer.grid.template.location = 0;
    //dateAxis.renderer.minGridDistance = 30;

    var valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis1.title.text = "Amount";

    var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis2.title.text = "Slices";
    valueAxis2.renderer.opposite = true;
    valueAxis2.renderer.grid.template.disabled = true;

    // Create series
    var series1 = chart.series.push(new am4charts.ColumnSeries());
    series1.dataFields.valueY = "montant";
    series1.dataFields.dateX = "date";
    series1.yAxis = valueAxis1;
    series1.name = "Amount";
    series1.tooltipText = "{name}\n[bold font-size: 20]{valueY}Fcfa[/]";
    series1.fill = chart.colors.getIndex(0);
    series1.strokeWidth = 8;
    series1.clustered = false;
    series1.columns.template.width = am4core.percent(40);

    var series3 = chart.series.push(new am4charts.LineSeries());
    series3.dataFields.valueY = "tranche";
    series3.dataFields.dateX = "date";
    series3.name = "number of slices";
    series3.strokeWidth = 2;
    series3.tensionX = 0.7;
    series3.yAxis = valueAxis2;
    series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";

    var bullet3 = series3.bullets.push(new am4charts.CircleBullet());
    bullet3.circle.radius = 3;
    bullet3.circle.strokeWidth = 2;
    bullet3.circle.fill = am4core.color("#fff");

    // Add cursor
    chart.cursor = new am4charts.XYCursor();

    // Add legend
    chart.legend = new am4charts.Legend();
    chart.legend.position = "top";

    // Add scrollbar
    chart.scrollbarX = new am4charts.XYChartScrollbar();
    chart.scrollbarX.series.push(series1);
    chart.scrollbarX.series.push(series3);
    chart.scrollbarX.parent = chart.bottomAxesContainer;

    }); // end am4core.ready()
    </script>
