@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box dashboard-title-box">
            <div class="page-title-right dashboard-title-box">
                <form class="form-inline">
                    <div class="form-group">
                        <div class="input-group input-group-sm">
                            <input type="hidden" class="form-control flatpickr-input" id="dash-daterange" readonly="readonly"/>
                            <div class="input-group-append">
                                <span class="input-group-text bg-blue border-blue text-white">
                                    <i class="mdi mdi-calendar-range"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <h4 class="page-title" id="dashboard_title">{{ __('global.dashboard') }}</h4>
        </div>
    </div>
</div>

<div class="row">
    @foreach($detection_count_list as $key => $value)
    <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-3">
                    <div class="avatar-lg rounded-circle bg-soft-{{ $notification_colors[$key] }} border-{{ $notification_colors[$key] }} border">
                        <i class="{{ $notification_icons[$key] }} font-24 avatar-title text-{{ $notification_colors[$key] }}"></i>
                    </div>
                </div>
                <div class="col-9">
                    <div class="text-right">
                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ number_format($value) }}</span></h3>
                        <p class="text-muted mb-1 text-truncate">{{ session('dec_type')[$key] ?? __('global.take_down') }}</p>
                    </div>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div> <!-- end col-->
    @endforeach
</div>

<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="widget-rounded-circle card-box">
            <h4 class="header-title mb-3">{{ __('global.severity_detections') }}</h4>
            <div class="row-donut-items">
                @if(sizeof($detection_count_level) == 0)
                    <h5 class="text-center text-muted">{{ __('global.msg.no_data') }}</h5>
                @endif
                <div id="morris-donut-dec-type" class="morris-chart"></div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div>

    <div class="col-md-6 col-xl-8">
        <div class="card">
            <div class="card-body">
                <div class="float-right d-md-inline-block">
                    <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-secondary" id="btn_daily"> {{ __('global.daily') }} </button>
                        <button type="button" class="btn btn-xs btn-light" id="btn_weekly">{{ __('global.weekly') }}</button>
                        <button type="button" class="btn btn-xs btn-light" id="btn_monthly">{{ __('global.monthly') }}</button>
                    </div>
                </div>
                <h4 class="header-title mb-1">{{ __('global.volumetry') }}</h4>
                <div class="mt-3 row-donut-items">
                    <div id="area-dec-chart" class="morris-chart"></div>
                </div>
            </div> <!-- end card-body-->
        </div>
    </div> <!-- end col-->
</div>

<div class="row">
    <div class="col-md-6 col-xl-7">
        <div class="widget-rounded-circle card-box">
            <h4 class="header-title mb-3">{{ __('global.ioc_express') }}</h4>
            <div class="row slimscroll row-3-items">
                <div class="table-responsive ml-2">
                    <table class="table table-borderless table-hover table-centered m-0 slimScrollBar">
                        <thead class="thead-light">
                        <tr>
                            <th>{{ __('global.ioc_type') }}</th>
                            <th>{{ __('global.content') }}</th>
                            <th>{{ __('global.alert_id') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($iocRes as $key => $val)
                            <tr>
                                <td>
                                    <h5 class="m-0 font-weight-normal">{{ session('ioc')[explode('|*\/*|', $key)[0]] }}</h5>
                                </td>
                                <td>
                                    {{ explode('|*\/*|', $key)[1] }} ({{ $val[0] }})
                                </td>
                                <td>
                                    <a href="{{ route('detections.show', $val[1]) }}">{{ $val[2] }}</a>
                                </td>
                            </tr>
                        @endforeach
                        @if(sizeof($iocRes) == 0)
                            <tr align="center">
                                <td colspan="3">{{ __('global.msg.no_data') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div>
    <div class="col-md-6 col-xl-5">
        <div class="widget-rounded-circle card-box">
            <h4 class="header-title mb-3">{{ __('global.tags') }}</h4>
            <div class="row slimscroll row-3-items">
                <div class="table-responsive ml-2">
                    <table class="table table-borderless table-hover table-centered m-0 slimScrollBar">
                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('global.tags') }}</th>
                            <th>{{ __('global.count') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $index = 0;
                        @endphp
                        @foreach($tag_ranking as $key => $val)
                            @php
                                $index ++;
                            @endphp
                            <tr>
                                <td>
                                    <h5 class="m-0 font-weight-normal">{{ $index }}</h5>
                                </td>
                                <td>
                                    <h5 class="m-0 font-weight-normal">{{ $key }}</h5>
                                </td>
                                <td>
                                    <h5 class="m-0 font-weight-normal">{{ $val }}</h5>
                                </td>
                            </tr>
                        @endforeach
                        @if(sizeof($tag_ranking) == 0)
                            <tr align="center">
                                <td colspan="3">{{ __('global.msg.no_data') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div>
</div>



@endsection
@push('css')
    <!-- third party css -->
    <link href="{{ asset('assets/libs/jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Flat Picker -->
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Jqplot chart -->
    <link href="{{ asset('assets/libs/jqplot/jquery.jqplot.css') }}" rel="stylesheet" type="text/css" />

    <!-- third party css end -->
    <style>
        .row-1-items {
            min-height: 332px;
            max-height: 332px;
        }
        .row-2-items {
            min-height: 350px;
            max-height: 350px;
        }

        .row-3-items {
            min-height: 300px;
            max-height: 300px;
        }

        .row-donut-items
        {
            min-height: 392px;
            max-height: 392px;
        }
        .bomb-lg
        {
            height: 1.5rem;
            width: 5.2rem;
        }
        .icon-left
        {
            margin-left: -1.5vw;
        }

        .flatpickr-input
        {
            width: 210px !important;
        }
        .morris-chart
        {
            height: 340px;
        }
        .jqplot-data-label
        {
            font-size: 13pt;
            color: black;
        }

        @media (max-width: 375px) {
            .dashboard-title-box
            {
                display: block !important;
                width: 100%;
            }
            #dashboard_title
            {
                display: block;
            }
            .flatpickr-input
            {
                width: 290px !important;
            }
        }


        @media only screen and (max-width: 1024px) {

        }
    </style>
@endpush

@push('js')
        <!-- third party js -->
        <script src="{{ asset('assets/libs/jquery-toast/jquery.toast.min.js') }}"></script>
        <script src="{{ asset('assets/libs/morris-js/morris.min.js') }}"></script>
        <script src="{{ asset('assets/libs/raphael/raphael.min.js') }}"></script>

        <!-- Flat Picker -->
        <!-- https://cdnjs.com/libraries/flatpickr  Flatpickr js cnd library-->
        <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('assets/libs/flatpickr/lang/pt.min.js') }}"></script>


        <!-- Flot chart -->
        <script src="{{ asset('assets/libs/flot-charts/jquery.flot.js') }}"></script>
        <script src="{{ asset('assets/libs/flot-charts/jquery.flot.tooltip.min.js') }}"></script>

        <!-- Jqplot chart -->
        <script src="{{ asset('assets/libs/jqplot/jquery.jqplot.js') }}"></script>
        <script src="{{ asset('assets/libs/jqplot/jqplot.pieRenderer.js') }}"></script>
        <script src="{{ asset('assets/libs/jqplot/jqplot.donutRenderer.js') }}"></script>

        <!-- Apex chart -->
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>


        <!-- third party js ends -->

        <!-- Datatables init -->
        <script>
            $(document).ready(function(){
                $("#dash-daterange").flatpickr({
                    altInput: true,
                    dateFormat: 'Y-m-d',
                    mode: "range",
                    altFormat: "m/d/Y",
                    defaultDate: ["{{ session('start_date') }}", "{{ session('end_date') }}"],
                    locale: '{{ session('cur_lang') }}',
                    onClose: function(selectedDates, dateStr, instance) {
                        let startDate = formatDate(selectedDates[0]);
                        let endDate = formatDate(selectedDates[1]);
                        $.post("{{ url('reg_daterange') }}", {start_date: startDate, end_date: endDate}, function () {

                        }).done(function() {
                            location.reload();
                        }).fail(function(res) {

                        });
                    }
                });

                var data = [
                        @foreach($detection_count_level as $key => $row)
                            ["{{ session('dec_level')[$row->detection_level] }}", {{ $row->count }}],
                        @endforeach
                    ];

                if(data.length > 0)
                $.jqplot('morris-donut-dec-type', [data], {
                    seriesDefaults: {
                        // make this a donut chart.
                        renderer:$.jqplot.DonutRenderer,
                        seriesColors: ['#ff0000', '#7fc6f5', '#ffe971','#26B99A', '#DE8244',
                            '#b3deb8', '#887aff','#DE8244', '#ffd3dc', '#AA0BAC', '#00FF0A'],
                        fontSize: '30pt',
                        rendererOptions:{
                            // Donut's can be cut into slices like pies.
                            sliceMargin: 2,
                            diameter : 235,
                            // Pies and donuts can start at any arbitrary angle.
                            startAngle: -90,
                            showDataLabels: true,
                            dataLabels: 'value',
                            totalLabel: true,
                        },
                    },
                    grid: {
                        gridLineColor: 'red',    // *Color of the grid lines.
                        background: 'white',     // CSS color spec for background color of grid.
                        borderWidth: 0.0,        // pixel width of border around grid.
                        shadow: false,
                    },
                    legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedPieLegendRenderer,
                        rendererOptions: {
                            numberColumns: 2,
                        },
                        border: '0px solid black',
                        marginTop: '15px',
                        fontSize: '9pt',
                        borderWidth: 0.0,
                    }
                });

                data = [
                    @foreach($decWeeklyCount as $key=>$val)
                    { y: '{{ $key }}', a: '{{ $val }}'},
                    @endforeach
                ];

                let colors = ["#4a81d4"];

                let datas = [
                    @foreach($decDailyCount as $key=>$val)
                        '{{ $val }}',
                    @endforeach
                ];

                let labels = [
                    @foreach($decDailyCount as $key=>$val)
                        '{{ $key }}',
                    @endforeach
                ];

                let options = {
                    series: [{
                        name: "{{ __('global.count') }}",
                        type: "line",
                        data: datas,
                    }],
                    chart: {
                        height: 378,
                        type: "line"
                    },
                    stroke: {
                        width: [2]
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: "50%"
                        }
                    },
                    colors: colors,
                    dataLabels: {
                        enabled: !0,
                        enabledOnSeries: [0]
                    },
                    labels: labels,
                    xaxis: {
                        type: "datetime"
                    },
                    legend: {
                        offsetY: 7
                    },
                    grid: {
                        padding: {
                            bottom: 20
                        }
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: "light",
                            type: "horizontal",
                            shadeIntensity: .25,
                            gradientToColors: 0,
                            inverseColors: !0,
                            opacityFrom: .75,
                            opacityTo: .75,
                            stops: [0, 0, 0]
                        }
                    },
                    yaxis: [{
                        title: {
                            text: "{{ __('global.detections') }}"
                        }
                    }, {
                        opposite: true,
                        title: {
                            text: "{{ __('global.number_detections') }}"
                        }
                    }]
                };
                let apexChart = new ApexCharts(document.querySelector('#area-dec-chart'), options);
                apexChart.render();

                $('#btn_daily').click(function(evt)
                {
                    resetBtn();
                    $(this).removeClass('btn-light');
                    $(this).addClass('btn-secondary');
                    let datas = [
                        @foreach($decDailyCount as $key=>$val)
                            '{{ $val }}',
                        @endforeach
                    ];

                    let labels = [
                        @foreach($decDailyCount as $key=>$val)
                            '{{ $key }}',
                        @endforeach
                    ];

                    buildingApex(datas, labels);
                });

                $('#btn_weekly').click(function(evt)
                {
                    resetBtn();
                    $(this).removeClass('btn-light');
                    $(this).addClass('btn-secondary');
                    let datas = [
                        @foreach($decWeeklyCount as $key=>$val)
                            '{{ $val }}',
                        @endforeach
                    ];

                    let labels = [
                        @foreach($decWeeklyCount as $key=>$val)
                            '{{ $key }}',
                        @endforeach
                    ];

                    buildingApex(datas, labels);

                });

                $('#btn_monthly').click(function(evt)
                {
                    resetBtn();
                    $(this).removeClass('btn-light');
                    $(this).addClass('btn-secondary');
                    let datas = [
                        @foreach($decMonthlyCount as $key=>$val)
                            '{{ $val }}',
                        @endforeach
                    ];

                    let labels = [
                        @foreach($decMonthlyCount as $key=>$val)
                            '{{ $key }}',
                        @endforeach
                    ];

                    buildingApex(datas, labels);
                });

                let resetBtn = () => {
                    $('#btn_daily').removeClass('btn-secondary');
                    $('#btn_weekly').removeClass('btn-secondary');
                    $('#btn_monthly').removeClass('btn-secondary');
                    $('#btn_daily').addClass('btn-light');
                    $('#btn_weekly').addClass('btn-light');
                    $('#btn_monthly').addClass('btn-light');
                };

                let buildingApex = (datas, labels) => {
                    apexChart.updateSeries([
                        {
                            data: datas,
                        }
                    ]);
                    apexChart.updateOptions(
                        {
                            labels: labels,
                        }
                    );
                }

            });
        </script>
@endpush

