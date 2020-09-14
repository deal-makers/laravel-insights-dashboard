@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
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
            <h4 class="page-title">{{ __('global.dashboard') }}</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="widget-rounded-circle card-box">
            <div class="row slimscroll row-1-items">
                <div class="table-responsive ml-2">
                    <table class="table table-borderless table-hover table-centered m-0 slimScrollBar">
                        <thead class="thead-light">
                        <tr>
                            <th>{{ trans('global.category') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($index = 0; $index < sizeof($detection_cnt) - 1; $index+=2)
                            <tr>
                                <td title="{{ session('dec_type')[$detection_cnt[$index]->type] }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-md rounded-circle border-dark border">
                                                <i class="{{ $notification_icons[$detection_cnt[$index]->type] }} font-22 avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-left icon-left">
                                                <h3 class="text-dark mt-1">{{ number_format($detection_cnt[$index]->count) }}</h3>
                                                <p class="text-muted mb-1 text-truncate">{{ session('dec_type')[$detection_cnt[$index]->type] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td title="{{ session('dec_type')[$detection_cnt[$index + 1]->type] }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-md rounded-circle border-dark border">
                                                <i class="{{ $notification_icons[$detection_cnt[$index + 1]->type] }} font-22 avatar-title text-dark"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-left icon-left">
                                                <h3 class="text-dark mt-1">{{ number_format($detection_cnt[$index + 1]->count) }}</h3>
                                                <p class="text-muted mb-1 text-truncate">{{ session('dec_type')[$detection_cnt[$index + 1]->type] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3" id="morris-donut-dec-div">
        <!-- Portlet card -->
        <div class="card-box row-2-items">
            <div class="m-auto">
                <h4 class="header-title mb-2">{{ trans('cruds.detections.fields.detection_level') }}</h4>
                <div id="morris-donut-dec-level" class="morris-chart m-auto"></div>
            </div> <!-- end row-->
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card-box">
            <div class="row align-items-center row-1-items">
                <div class="col">
                    <h3 class="ml-3 mb-lg-2" style="font-size: 2rem;">{{ number_format($takedown_cnt) }}
                        <p class="ml-0 text-muted mb-5" style="font-size: 1rem;">{{ trans('global.take_down') }}</p>
                    </h3>
                </div>
                <div class="col">
                    <div class="bomb-lg m-auto">
                        <img src="{{ asset('assets/images/bomb-drop.png') }}" class="img-fluid">
                    </div>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div>

    <div class="col-md-6 col-xl-2">
        <div class="widget-rounded-circle card-box">
            <div class="row slimscroll row-1-items">
                <div class="table-responsive ml-2">
                    <table class="table table-borderless table-hover table-centered m-0 slimScrollBar">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ trans('global.tags') }}</th>
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
                                <h5 class="m-0 font-weight-normal">{{ $index.'. '.$key.' ('.$val.')' }}</h5>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div> <!-- end col-->
</div>

<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="widget-rounded-circle card-box">
            <div class="row-2-items">
                <div id="morris-donut-dec-type" class="morris-chart"></div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="widget-rounded-circle card-box">
            <div class="row slimscroll row-2-items">
                <div class="table-responsive ml-2">
                    <table class="table table-borderless table-hover table-centered m-0 slimScrollBar">
                        <thead class="thead-light">
                        <tr>
                            <th>{{ trans('global.ioc_type') }}</th>
                            <th>{{ trans('global.content') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($iocRes as $key => $val)
                        <tr>
                            <td>
                                <h5 class="m-0 font-weight-normal">{{ session('ioc')[explode('|*\/*|', $key)[0]] }}</h5>
                            </td>
                            <td>
                                {{ explode('|*\/*|', $key)[1] }} ({{ $val }})
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="float-right d-md-inline-block">
                    <div class="btn-group mb-1">
                        <button type="button" class="btn btn-xs btn-secondary" id="btn_weekly">Weekly</button>
                        <button type="button" class="btn btn-xs btn-light" id="btn_monthly">Monthly</button>
                    </div>
                </div>
                <div class="mt-4">
                    <div id="area-dec-chart" class="morris-chart"></div>
                </div>
            </div> <!-- end card-body-->
        </div>
    </div> <!-- end col-->
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
            min-height: 377px;
            max-height: 377px;
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
        .border
        {
            border: 2px solid !important;
        }

        .flatpickr-input
        {
            width: 210px !important;
        }
        .morris-chart
        {
            height: 340px;
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

        <!-- third party js ends -->

        <!-- Datatables init -->
        <script>
            $(document).ready(function(){
                $("#dash-daterange").flatpickr({
                    altInput: true,
                    dateFormat: 'Y-m-d',
                    mode: "range",
                    altFormat: "m/d/Y",
                    defaultDate: ["2017-08-29", "2017-08-29"],
                    locale: '{{ session('cur_lang') }}',
                    onClose: function(selectedDates, dateStr, instance) {
                        let startDate = formatDate(selectedDates[0]);
                        let endDate = formatDate(selectedDates[1]);
                        $.post("{{ url('change_lang') }}", {lang: str}, function () {


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

                $.jqplot('morris-donut-dec-level', [data], {
                    seriesDefaults: {
                        // make this a donut chart.
                        renderer:$.jqplot.DonutRenderer,
                        seriesColors: ['#ff0000', '#7fc6f5', '#ffe971','#26B99A', '#DE8244',
                            '#b3deb8', '#887aff','#DE8244', '#ffd3dc', '#AA0BAC', '#00FF0A'],
                        rendererOptions:{
                            // Donut's can be cut into slices like pies.
                            sliceMargin: 2,
                            diameter : 180,
                            // Pies and donuts can start at any arbitrary angle.
                            startAngle: -90,
                            showDataLabels: true,
                            dataLabels: 'value',
                            totalLabel: true,
                        }
                    },
                    grid: {
                        gridLineColor: 'red',    // *Color of the grid lines.
                        background: 'white',     // CSS color spec for background color of grid.
                        borderWidth: 0.0,        // pixel width of border around grid.
                        shadow: false,           // draw a shadow for grid.
                    },
                    legend: {
                        show:true,
                        location: 's',
                        renderer: $.jqplot.EnhancedPieLegendRenderer,
                        rendererOptions: {
                            numberColumns: 2,
                        }
                    }
                });

                var barColorsArray = ['#ff0000', '#3498DB', '#ffe971','#26B99A', '#DE8244',
                    '#1fc02f', '#887aff','#DE8244'];
                data = [
                    @foreach($detection_cnt as $row)
                        { y: '{{ session('dec_type')[$row->type] }}', a: '{{ $row->count }}'},
                    @endforeach
                    ];
                config = {
                    data: data,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['{{ trans('global.count') }}'],
                    fillOpacity: 0.6,
                    hideHover: 'auto',
                    behaveLikeLine: true,
                    resize: true,
                    pointFillColors:['#ffffff'],
                    pointStrokeColors: ['black'],
                    lineColors:['gray','red'],
                    barColors: function (row) {
                        return barColorsArray[row.x];
                    },
                };
                config.element = 'morris-donut-dec-type';
                Morris.Bar(config);

                data = [
                    @foreach($decWeeklyCount as $key=>$val)
                    { y: '{{ $key }}', a: '{{ $val }}'},
                    @endforeach
                ];
                config = {
                    data: data,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['{{ trans('global.count') }}'],
                    fillOpacity: 0.6,
                    hideHover: 'auto',
                    behaveLikeLine: true,
                    resize: true,
                    pointFillColors:['#ffffff'],
                    pointStrokeColors: ['black'],
                    lineColors:['#eaca06','grey']
                };
                config.element = 'area-dec-chart';
                Morris.Area(config);

                $('#btn_weekly').click(function(){
                    $('#area-dec-chart').empty();
                    $(this).removeClass('btn-light');
                    $(this).addClass('btn-secondary');
                    $('#btn_monthly').removeClass('btn-secondary');
                    $('#btn_monthly').addClass('btn-light');
                    data = [
                            @foreach($decWeeklyCount as $key=>$val)
                        { y: '{{ $key }}', a: '{{ $val }}'},
                        @endforeach
                    ];
                    config = {
                        data: data,
                        xkey: 'y',
                        ykeys: ['a'],
                        labels: ['{{ trans('global.count') }}'],
                        fillOpacity: 0.6,
                        hideHover: 'auto',
                        behaveLikeLine: true,
                        resize: true,
                        pointFillColors:['#ffffff'],
                        pointStrokeColors: ['black'],
                        lineColors:['#eaca06','grey']
                    };
                    config.element = 'area-dec-chart';
                    Morris.Area(config);
                });

                $('#btn_monthly').click(function(){
                    $('#area-dec-chart').empty();
                    $(this).removeClass('btn-light');
                    $(this).addClass('btn-secondary');
                    $('#btn_weekly').removeClass('btn-secondary');
                    $('#btn_weekly').addClass('btn-light');
                    data = [
                            @foreach($decMonthlyCount as $key=>$val)
                        { y: '{{ $key }}', a: '{{ $val }}'},
                        @endforeach
                    ];
                    config = {
                        data: data,
                        xkey: 'y',
                        ykeys: ['a'],
                        labels: ['{{ trans('global.count') }}'],
                        fillOpacity: 0.6,
                        hideHover: 'auto',
                        behaveLikeLine: true,
                        resize: true,
                        pointFillColors:['#ffffff'],
                        pointStrokeColors: ['black'],
                        lineColors:['#eaca06','grey']
                    };
                    config.element = 'area-dec-chart';
                    Morris.Area(config);

                });
            });
        </script>
@endpush

