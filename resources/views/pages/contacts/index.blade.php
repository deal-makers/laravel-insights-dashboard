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
                    <li class="breadcrumb-item active">{{ trans('global.contacts') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ trans('global.contacts') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.detections.fields.id') }}</th>
                            <th>{{ trans('cruds.detections.fields.dec_id') }}</th>
                            <th>{{ trans('cruds.contacts.fields.reason') }}</th>
                            <th>{{ trans('cruds.contacts.fields.sender_name') }}</th>
                            <th>{{ trans('cruds.contacts.fields.receive_name') }}</th>
                            <th>{{ trans('cruds.detections.fields.datetime') }}</th>
                            <th>{{ trans('global.content') }}</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $key => $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <td>
                                    {{ $row->id ?? '' }}
                                </td>
                                <td id="dec_id_{{ $row->id }}">
                                    {{ $row->dec_id ?? '' }}
                                </td>
                                <td id="td_reason_{{ $row->id }}">
                                    {{ session('contact_reason')[$row->contact_reason] ?? '' }}
                                </td>
                                <td>
                                    {{ \App\User::Find($row->client_id)->name ?? '' }}
                                </td>
                                <td>
                                    {{ \App\User::Find($row->user_id)->name ?? '' }}
                                </td>
                                <td id="td_datetime_{{ $row->id }}">
                                    {{ $row->created_at }}
                                </td>
                                <td id="td_contents_{{ $row->id }}" title="{{ $row->contents }}">
                                    @if (strlen($row->contents) > 25)
                                        {{ substr($row->contents, 0, 25) . '...' }}
                                    @else
                                        {{ $row->contents ?? '' }}
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="javascript:showDetail({{ $row->id }});" >
                                        <i class='fe-eye'></i>
                                        {{ trans('global.view') }}
                                    </a>

                                    <form action="{{ route('contacts.destroy', $row->id) }}" method="POST" onclick="isConfirm(this)" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger">
                                            <i class='fe-trash'></i>
                                            @lang('global.delete')
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create & Edit Modal for Data -->
<div id="data-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="data-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('global.contact') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tag_group" class="control-label" id="modal_contact_reason">{{ trans('cruds.contacts.fields.reason') }} </label>
                            <p id="contact_reason" class="form-control"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tag_group" class="control-label">{{ trans('cruds.contacts.fields.contents') }} </label>
                            <textarea id="contents" class="form-control" rows="7"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
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

        function isConfirm(form)
        {
            event.preventDefault();
            swal({
                title: "{{ trans('global.areYouSure') }}",
                text: "{{ trans('global.canNotRevert') }}",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger m-l-10',
                confirmButtonText: "{{ trans('global.yesDelete') }}"
            }).then((result) => {
                if (result.value) {
                    $(form).submit();
                } else
                {
                    return false;
                }
            });
        }
        let showDetail = (id) => {
            $('#modal_contact_reason').html(`{{ trans('cruds.contacts.fields.reason') }}, ` + $(`#td_datetime_${id}`).text());
            $('#contact_reason').html($(`#td_reason_${id}`).text());
            $('#contents').html($(`#td_contents_${id}`).attr('title'));
            $('#data-modal').modal({backdrop:'static',keyboard:false, show:true});
        }
    </script>
@endpush