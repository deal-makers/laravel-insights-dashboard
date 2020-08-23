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
                    <li class="breadcrumb-item active">{{ trans('global.detections') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ trans('global.detections') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a class="btn btn-success mb-3" href="{{ route('detections.create') }}">
                    <i class="fe-plus"></i> {{ trans('global.add') }} {{ trans('cruds.detections.title') }}
                </a>
                <table id="datatable" class="table dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.detections.fields.dec_id') }}</th>
                            <th>{{ trans('cruds.detections.fields.title') }}</th>
                            <th>{{ trans('cruds.detections.fields.datetime') }}</th>
                            <th>{{ trans('cruds.detections.fields.category') }}</th>
                            <th>{{ trans('cruds.detections.fields.analyst') }}</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detections as $key => $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <td>
                                    {{ $row->dec_id ?? '' }}
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
                                    <span class="badge badge-info">{{ \App\User::Find($row->user_id)->name ?? '' }}</span>
                                </td>
                                <td>
                                    @if(Auth::user()->id == $row->user_id)
                                    <a class="btn btn-xs btn-info" href="{{ route('detections.edit', $row->id) }}">
                                        <i class='fe-edit'></i>
                                        {{ trans('global.edit') }}
                                    </a>

                                    <form action="{{ route('detections.destroy', $row->id) }}" method="POST" onclick="isConfirm(this)" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger">
                                            <i class='fe-trash'></i>
                                            @lang('global.delete')
                                        </button>
                                    </form>
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
                    $('div.dataTables_scrollBody table tbody tr:last td').attr('style', 'border-bottom:solid 1px #8080805c;')
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

    </script>
@endpush