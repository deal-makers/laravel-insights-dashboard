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
                        <li class="breadcrumb-item active">{{ trans('global.feedback') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ trans('global.feedback') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table dt-responsive table-hover nowrap">
                        <thead>
                        <tr>
                            <th>{{ trans('cruds.detections.fields.dec_id') }}</th>
                            <th>{{ trans('cruds.detections.fields.title') }}</th>
                            <th>{{ trans('cruds.detections.fields.description') }}</th>
                            <th>{{ trans('cruds.detections.fields.detection_level') }}</th>
                            <th>{{ trans('cruds.detections.fields.datetime') }}</th>
                            <th>{{ trans('cruds.detections.fields.category') }}</th>
                            <th>{{ trans('cruds.detections.fields.mark_read') }}</th>
                            <th>{{ trans('cruds.detections.fields.feedback') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($detections as $key => $row)
                            <tr id="{{ $row->id }}">
                                <td>
                                    <a href="{{ route('detections.show', $row->id) }}">{{ $row->dec_id ?? '' }}</a>
                                </td>
                                <td>
                                    {{ $row->title ?? '' }}
                                </td>
                                <td title="{{ $row->description }}">
                                    @if (strlen($row->description) > 25)
                                        {{ substr($row->description, 0, 25) . '...' }}
                                    @else
                                        {{ $row->description ?? '' }}
                                    @endif
                                </td>
                                <td>
                                    {{ session('dec_level')[$row->detection_level] }}
                                </td>
                                <td>
                                    {{ $row->created_at }}
                                </td>
                                <td>
                                    {{ session('dec_type')[$row->type] ?? '' }}
                                </td>
                                <td>
                                    <input type="checkbox" data-plugin="switchery" @if($row->mark_read == 1) checked @endif />
                                </td>
                                <td id="td_feedback_{{ $row->id }}" title="@if(!is_null($row->feedback)) {{ $row->feedback }} @endif">
                                    @if(!is_null($row->feedback) && $row->feedback != '')
                                        <button type="button" id="send_feedback_{{ $row->id }}" data-status="1" class="btn btn-success btn-sm waves-effect waves-light ml-2" onclick="openFeedbackModal({{ $row->id }})"><i class="fe-eye"></i> {{ trans('global.view') }}</button>
                                    @else
                                        <button type="button" id="send_feedback_{{ $row->id }}" data-status="0" class="btn btn-blue btn-sm waves-effect waves-light ml-2" disabled><i class="fe-camera-off"></i> {{ trans('global.none') }}</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Send Feedback modal -->
    <div id="feedback-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="data-modal" aria-hidden="true" data-id="0">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('cruds.detections.fields.feedback') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tag_group" class="control-label">@lang('global.contents')</label>
                                <textarea class="form-control" id="feedback" rows="5" maxlength="500" placeholder="{{ trans('validation.limited', ['attribute' => 500]) }}"></textarea>
                                <span class="mt-1 require_error" id="input_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="edit_tag" />
                    <input type="hidden" id="tag_val" />
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">@lang('global.close')</button>
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
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->
    <style>
        .switchery-small
        {
            margin-left: 20px;
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
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('assets/libs/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/toastr.init.js') }}"></script>

    <!-- third party js ends -->
    <!-- Datatables init -->
    <script>
        $(document).ready(function(){
            $('[maxlength]').maxlength({
                alwaysShow: false,
                threshold: 10,
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger",
                placement: 'bottom',
                separator: ' / '
            });
            let table = $("#datatable").DataTable({
                scrollY: '60vh',
                responsive: {
                    details: true
                },
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
            let elems = $('[data-plugin="switchery"]');
            for (var i = 0; i < elems.length; i++) {
                let init = new Switchery(elems[i], {size:'small'});
                init.disable();
            }

        });
        let openFeedbackModal = (rowId) => {
            $('#feedback').val($('#td_feedback_' + rowId).attr('title'));
            $('#feedback-modal').modal({keyboard:false, show:true});
        }

    </script>
@endpush