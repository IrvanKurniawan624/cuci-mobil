@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Dashboard</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="" class="text-muted">Home</a>
    </li>
    <li class="breadcrumb-item text-dark"> Dashboard </li>
</ul>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Rekap Pendapatan 5 Hari Terakhir</h5>
                        </div>
                    </div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Yearly Breakup -->
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-9 fw-semibold">Total Pendapatan Bulan Ini</h5>
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4 class="fw-semibold mb-3">{{ "Rp. ".number_format($pendapatan_bulan_ini->total_pendapatan, 0 , ',' , '.' ) }}</h4>
                                    <div class="d-flex align-items-center">
                                        <div class="me-4">
                                            <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                            <span class="fs-2">{{ $month_year_ind }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="d-flex justify-content-center">
                                        <div id="breakup"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <!-- Monthly Earnings -->
                    <div class="card">
                        <div class="card-body" style="padding-bottom: 40px">
                            <div class="row alig n-items-start">
                                <div class="col-8">
                                    <h5 class="card-title mb-9 fw-semibold"> Pendapatan Hari Ini </h5>
                                    <h4 class="fw-semibold mb-3">{{ "Rp. ".number_format($pendapatan_hari_ini->total_pendapatan, 0 , ',' , '.' ) }}</h4>
                                    <div class="d-flex align-items-center pb-1 positon-relative">
                                        <img src="{{ asset('assets\images\avatar\graph-bg.png') }}" style="position: absolute; right: 0; bottom: 0; z-index: 2" alt="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div
                                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-currency-dollar fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $.ajax({
    url: "{{ route('dashboard') . '/get-data' }}",
    type: 'GET',
    dataType: 'json',
    success: function (response) {
        let data = response.data;
        var chart = {
            series: [{
                    name: "Owner:",
                    data: data.owner_percentage_list
                },
                {
                    name: "Karyawan:",
                    data: data.karyawan_percentage_list
                },
                {
                    name: "Operasional:",
                    data: data.operasional_percentage_list
                },
            ],

            chart: {
                type: "bar",
                height: 345,
                offsetX: -15,
                toolbar: {
                    show: true
                },
                foreColor: "#adb0bb",
                fontFamily: 'inherit',
                sparkline: {
                    enabled: false
                },
            },


            colors: ["#5D87FF", "#FFA426", "#CB2E2E"],


            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "35%",
                    borderRadius: [6],
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'all'
                },
            },
            markers: {
                size: 0
            },

            dataLabels: {
                enabled: false,
            },


            legend: {
                show: false,
            },


            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
            },

            xaxis: {
                type: "category",
                categories: data.date_list,
                labels: {
                    style: {
                        cssClass: "grey--text lighten-2--text fill-color"
                    },
                },
            },


            yaxis: {
                show: true,
                min: 0,
                tickAmount: 4,
                labels: {
                    style: {
                        cssClass: "grey--text lighten-2--text fill-color",
                    },
                },
            },
            stroke: {
                show: true,
                width: 3,
                lineCap: "butt",
                colors: ["transparent"],
            },


            tooltip: {
                theme: "light"
            },

            responsive: [{
                breakpoint: 600,
                options: {
                    plotOptions: {
                        bar: {
                            borderRadius: 3,
                        }
                    },
                }
            }]


        };

        var chart = new ApexCharts(document.querySelector("#chart"), chart);
        chart.render();
    },error: function (jqXHR, textStatus, errorThrown) {
        Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
    },
    })

    // =====================================
    // Breakup
    // =====================================
    var breakup = {
        color: "#adb5bd",
        series: [{{ $pendapatan_bulan_ini->owner_percentage .',' . $pendapatan_bulan_ini->karyawan_percentage . ',' . $pendapatan_bulan_ini->operasional_percentage }}],
        labels: ["Owner", "Karyawan", "Operasional"],
        chart: {
            width: 180,
            type: "donut",
            fontFamily: "Plus Jakarta Sans', sans-serif",
            foreColor: "#adb0bb",
        },
        plotOptions: {
            pie: {
                startAngle: 0,
                endAngle: 360,
                donut: {
                    size: '75%',
                },
            },
        },
        stroke: {
            show: false,
        },

        dataLabels: {
            enabled: false,
        },

        legend: {
            show: false,
        },
        colors: ["#5D87FF", "#FFA426", "#CB2E2E"],

        responsive: [{
            breakpoint: 991,
            options: {
                chart: {
                    width: 150,
                },
            },
        }, ],
        tooltip: {
            theme: "dark",
            fillSeriesColor: false,
        },
    };

    var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
    chart.render();
</script>
@endsection
