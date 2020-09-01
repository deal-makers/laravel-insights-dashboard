@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#">@lang('global.system')</a></li>
                    <li class="breadcrumb-item active">@lang('global.dashboard')</li>
                </ol>
            </div>
            <h4 class="page-title">@lang('global.dashboard')</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card-box">
            <div class="row slimscroll row-1-items">
                <div class="table-responsive ml-2">
                    <table class="table table-borderless table-hover table-centered m-0 slimScrollBar">
                        <thead class="thead-light">
                        <tr>
                            <th>{{ trans('global.category') }}</th>
                            <th>{{ trans('global.count') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($detection_cnt as $row)
                            <tr>
                                <td>
                                    <h5 class="m-0 font-weight-normal">{{ session('dec_type')[$row->type] }}</h5>
                                </td>
                                <td>
                                    <h5 class="m-0 font-weight-normal">{{ number_format($row->count) }}</h5>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- end row-->
        </div> <!-- end widget-rounded-circle-->
    </div> <!-- end col-->

    <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card-box">
            <div class="row align-items-center row-1-items">
                <div class="col">
                    <h3 class="ml-3 mb-lg-3" style="font-size: 2rem;">{{ number_format($takedown_cnt) }}
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

    <div class="col-md-6 col-xl-3">
        <!-- Portlet card -->
        <div class="card-box">
            <div class="m-auto">
                <div id="morris-donut-dec-level" class="morris-chart m-auto" style="height: 220px;"></div>
            </div> <!-- end row-->
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
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
    <!-- third party css end -->
    <style>
        .row-1-items {
            min-height: 220px;
            max-height: 220px;
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

        @media only screen and (max-width: 1024px) {

        }

    </style>
@endpush

@push('js')
        <!-- third party js -->
        <script src="{{ asset('assets/libs/jquery-toast/jquery.toast.min.js') }}"></script>
        <script src="{{ asset('assets/libs/morris-js/morris.min.js') }}"></script>
        <script src="{{ asset('assets/libs/raphael/raphael.min.js') }}"></script>
        <!-- third party js ends -->
        <!-- Datatables init -->
        <script>
            $(document).ready(function(){
                Morris.Donut({
                    element: 'morris-donut-dec-level',
                    data: [
                        @foreach($detection_count_level as $row)
                        {label: "{{ session('dec_level')[$row->detection_level] }}", value: "{{ $row->count }}"},
                        @endforeach
                    ],
                });
                var barColorsArray = ['#ff0000', '#3498DB', '#ffe971','#26B99A', '#DE8244',
                    '#1fc02f', '#887aff','#DE8244'];
                var colorIndex = -1;
                var data = [
                    @foreach($detection_cnt as $row)
                        { y: '{{ session('dec_type')[$row->type] }}', a: '{{ $row->count }}'},
                    @endforeach
                    ],
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

