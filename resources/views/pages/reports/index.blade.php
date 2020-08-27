@extends('layouts.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                {{ trans('global.dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ trans('global.reports') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ trans('global.reports') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-info mb-3" href="{{ route('reports.create') }}">
                        <i class="mdi mdi-database-export"></i> {{ trans('global.export') }}
                    </a>
                    <table id="datatable" class="table dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>{{ trans('cruds.detections.fields.id') }}</th>
                            <th>{{ trans('cruds.detections.fields.dec_id') }}</th>
                            <th>{{ trans('cruds.detections.fields.title') }}</th>
                            <th>{{ trans('cruds.detections.fields.datetime') }}</th>
                            <th>{{ trans('cruds.detections.fields.category') }}</th>
                            <th>{{ trans('cruds.detections.fields.creater') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($detections as $key => $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <td>
                                    {{ $row->id ?? '' }}
                                </td>
                                <td>
                                    <a href="{{ route('detections.show', $row->id) }}">{{ $row->dec_id ?? '' }}</a>
                                </td>
                                <td>
                                    {{ $row->title ?? '' }}
                                </td>
                                <td>
                                    {{ $row->created_at }}
                                </td>
                                <td>
                                    {{ session('dec_type')[$row->type] ?? '' }}
                                </td>
                                <td>
                                    {{ \App\User::Find($row->user_id)->name ?? '' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <!-- third party css -->
    <link href="{{ asset('assets/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables/dataTables.checkboxes.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->
@endpush

@push('js')
    <!-- third party js -->
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery-toast/jquery.toast.min.js') }}"></script>
    <!-- third party js ends -->
    <!-- Datatables init -->
    <script>
        $(document).ready(function(){
            $("#datatable").DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                    $('.dataTables_scrollBody').css('min-height', '460px');
                },
                "order": [[ 0, "asc" ]]
            });
        });

    </script>
@endpush