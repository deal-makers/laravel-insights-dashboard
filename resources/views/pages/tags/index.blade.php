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
                    <li class="breadcrumb-item active">@lang('global.tags')</li>
                </ol>
            </div>
            <h4 class="page-title">@lang('global.tags')</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a class="btn btn-success mb-3" href="javascript:openCreateModal();">
                    <i class="fe-plus"></i> {{ trans('global.add') }} {{ trans('global.tag') }}
                </a>
                <table id="datatable" class="table dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>{{ trans('cruds.permission.fields.id') }}</th>
                            <th>{{ trans('global.group') }}</th>
                            <th>{{ trans('global.tag') }}</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $key => $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <td>
                                    {{ $row->id ?? '' }}
                                </td>
                                <td>
                                    @if($row->group == 0)
                                    Global
                                    @elseif($row->group == 1)
                                    NIST
                                    @else
                                    MITER Att & Ck
                                    @endif
                                </td>
                                <td>
                                    {{ $row->tag ?? '' }}
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="javascript:openEditModal('{{ $row->group ?? 0}}', '{{ $row->tag ?? '' }}', '{{ $row->id ?? '' }}');">
                                        <i class='fe-edit'></i>
                                        {{ trans('global.edit') }}
                                    </a>
                                    <form action="{{ route('tags.destroy', $row->id) }}" method="POST" onclick="isConfirm(this)" style="display: inline-block;">
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
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tag_group" class="control-label">@lang('global.group') <span class="text-danger">*</span></label>
                            {!! Form::select('tag_group', ["Global", "NIST", "MITER Att & Ck"], 0, ['id' => 'tag_group', 'class' => 'form-control']) !!}
                            <label for="tag" class="control-label mt-1">@lang('global.tag') <span class="text-danger">*</span></label>
                            <input type="text" required class="form-control" value="" id="tag">
                            <span class="mt-1 require_error" id="tag_error"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="edit_tag" />
                <input type="hidden" id="tag_val" />
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">@lang('global.close')</button>
                <button type="button" class="btn btn-info waves-effect waves-light" id="modal-btn-save" action-type="create" onclick="saveData()" >@lang('global.save')</button>
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
                    },
                    info: "{{ __('global.datatables.showing') }} _START_ {{ __('global.datatables.to') }} _END_ {{ __('global.datatables.of') }} _TOTAL_ {{ __('global.datatables.entries') }}",
                    search: "{{ __('global.search') }}",
                    lengthMenu:"{{ __('global.show') }} _MENU_ {{ __('global.datatables.entries') }}",
                    zeroRecords:    "{{ __('global.datatables.zero_records') }}",
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                    $('.dataTables_scrollBody').css('min-height', '460px');
                },
                "order": [[ 0, "asc" ]]
            });

            $("input").on('keyup', function (e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    saveData();
                }
            });
        });
        let openCreateModal = () => {
            $('.modal-title').text("{{ trans('global.add') }} {{ trans('global.tag') }}");
            $('#edit_tag').val('');
            $("#tag_error").text('');
            $('#modal-btn-save').attr('action-type', 'create');
            $('#data-modal').modal({backdrop:'static',keyboard:false, show:true});
        }

        let openEditModal = (group, tag, id) => {
            $('.modal-title').text("{{ trans('global.edit') }} {{ trans('global.tag') }}");
            $('#modal-btn-save').attr('action-type', 'edit');
            $('#edit_tag').val(id);
            $('#tag_group').val(group);
            $("#tag_error").text('');
            $('#tag').val(tag);
            $('#tag_val').val(tag);
            $('#data-modal').modal({backdrop:'static',keyboard:false, show:true});
        }

        let saveData = () => {
            let group = $('#tag_group').val();
            let tag = $('#tag').val();
            if(tag == '')
            {
                $('#tag').focus();
                @php
                    $filed = strtolower(trans('global.tag'));
                @endphp
                $("#tag_error").text('{{ trans('validation.filled', ['attribute' => $filed]) }}');
                return false;
            }
            let action_type = $('#modal-btn-save').attr('action-type');
            if(action_type == 'create')
            {
                $.ajax({
                    url: "{{ route('tags.store') }}",
                    data: {group: group, tag: tag},
                    type: 'POST',
                    dataType: 'json', // added data type
                    success: function(res) {
                        location.reload();
                    },
                    error: function(jqXHR, exception)
                    {
                        $.each(jqXHR.responseJSON, function(key, val) {
                            $("#tag_error").text(val[0]);
                        });
                    }
                });
            } else
            {
                let tag_id = $('#edit_tag').val();
                let change_flag = 0;
                if($('#tag_val').val() != tag) change_flag = 1;
                $.ajax({
                    url: "{{ url('tagupdate') }}" + `/${tag_id}`,
                    data: {group: group, tag: tag, change_flag: change_flag},
                    type: 'POST',
                    dataType: 'json', // added data type
                    success: function(res) {
                        location.reload();
                    },
                    error: function(jqXHR, exception)
                    {
                        $.each(jqXHR.responseJSON, function(key, val) {
                            $("#tag_error").text(val[0]);
                        });
                    }
                });
            }
        }

        $('#data-modal').on('shown.bs.modal', function () {
            $('input:text:visible:first', this).focus();
        }); 
    </script>
@endpush