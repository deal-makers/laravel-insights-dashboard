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
                    <a class="btn btn-info mb-3" href="javascript:openSettingModal()">
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
    <!-- Send Report setting modal -->
    <div id="report-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="data-modal" aria-hidden="true" data-id="0">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('global.export_setting') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tag_group" class="control-label">@lang('global.components')</label>
                                <form id="setting_form" action="{{ url('export') }}" method="POST">
                                    @csrf
                                    <select multiple="multiple" class="form-control multi-select" id="multi_select" name="multi_select[]" data-plugin="multiselect" data-selectable-optgroup="true">
                                        <optgroup label="{{ trans('cruds.detections.fields.all_component') }}">
                                            <option value="dec_id">{{ trans('cruds.detections.fields.dec_id') }}</option>
                                            <option value="title">{{ trans('cruds.detections.fields.title') }}</option>
                                            <option value="type">{{ trans('cruds.detections.fields.detection_type') }}</option>
                                            <option value="emergency">{{ trans('cruds.detections.fields.emergency') }}</option>
                                            <option value="detection_level">{{ trans('cruds.detections.fields.detection_level') }}</option>
                                            <option value="tlp">{{ trans('cruds.detections.fields.tlp') }}</option>
                                            <option value="pap">{{ trans('cruds.detections.fields.pap') }}</option>
                                            <option value="tags">{{ trans('cruds.detections.fields.tags_detection') }}</option>
                                            <option value="comment">{{ trans('cruds.detections.fields.analyst_comments') }}</option>
                                            <option value="description">{{ trans('cruds.detections.fields.description') }}</option>
                                            <option value="scenery">{{ trans('cruds.detections.fields.threat_scenery') }}</option>
                                            <option value="tech_detail">{{ trans('cruds.detections.fields.tech_details') }}</option>
                                            <option value="reference">{{ trans('cruds.detections.fields.reference_url') }}</option>
                                            <option value="evidence">{{ trans('cruds.detections.fields.evidences') }}</option>
                                            <option value="ioc">{{ trans('cruds.detections.fields.ioc') }}</option>
                                            <option value="cves">{{ trans('cruds.detections.fields.cves') }}</option>
                                            <option value="cvss">{{ trans('cruds.detections.fields.cvss') }}</option>
                                            <option value="created_at">{{ trans('cruds.detections.fields.created_date') }}</option>
                                        </optgroup>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">@lang('global.close')</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" id="modal-btn-download" onclick="downLoadData()" >@lang('global.download')</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
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
    <link href="{{ asset('assets/libs/multiselect/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->
    <style>
        .btn-secondary:hover{
            background-color: #4fc6e1 !important;
        }
        @media only screen and (max-width: 400px) {
            .ms-selection
            {
                margin-right: 35px;
            }
        }

    </style>
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
    <script src="{{ asset('assets/libs/multiselect/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/js/pages/toastr.init.js') }}"></script>
    <!-- third party js ends -->
    <!-- Datatables init -->
    <script>
        $(document).ready(function(){
            $('#multi_select').multiSelect();
            $('#ms-multi_select').addClass('m-auto');
            $("#datatable").DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                dom: 'Bfrtip',
                buttons: [
                    'pageLength',
                    {
                        "extend": 'collection',
                        "text": "{{ trans('global.table_export') }}",
                        "buttons": [ 'csv', 'print' ],
                        "fade": true
                    },
                ],
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                    $('.dataTables_scrollBody').css('min-height', '460px');
                    $('.btn-secondary').css('background-color', '#37623d');
                },
                "order": [[ 0, "asc" ]]
            });
        });

        let downLoadData = () => {
            let settings = $('#multi_select').val();
            if(settings == '')
            {
                $.NotificationApp.send(
                    "{{ trans('global.warning') }}",
                    "{{ trans('global.msg.set_component') }}",
                    "top-right",
                    "#fd7e14",
                    "warning");
                return false;
            }
            $('#report-modal').modal('hide');
            $('#setting_form').submit();
        }

        let openSettingModal = () => {
            $('#report-modal').modal({backdrop:'static',keyboard:false, show:true});
        }

    </script>
@endpush