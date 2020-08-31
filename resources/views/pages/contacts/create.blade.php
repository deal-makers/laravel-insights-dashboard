@extends('layouts.app')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="#">
                            {{ trans('global.contacts') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ trans('global.send') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ trans('global.send') }} {{ trans('global.contact') }}</h4>
        </div>
    </div>
</div>
<!-- end page title -->

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    {{session('success')}}
</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("contacts.store") }}" method="POST" id="contact_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('reason') ? 'has-error' : '' }}">
                                        <label for="reason">{{ trans('cruds.contacts.fields.reason') }} <span class="text-danger">*</span></label>
                                        {!! Form::select('reason', $contact_reason, old('reason'), ['id'=>'reason', 'class' => 'form-control', 'data-toggle' => 'select2', 'require' => true]) !!}
                                        @if($errors->has('reason'))
                                            <div class="mt-1 require_error">
                                                {{ $errors->first('reason') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                        <label for="dec_id">{{ trans('cruds.detections.fields.dec_id') }} <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-md-11">
                                                {!! Form::select('dec_id', $detections, old('dec_id'), ['id'=>'dec_id', 'class' => 'form-control', 'data-toggle' => 'select2', 'require' => true]) !!}
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-info show-btn" type="button" onclick="showDetection()"> <i class="fe-eye"></i></button>
                                            </div>
                                        </div>

                                        @if($errors->has('dec_id'))
                                            <div class="mt-1 require_error">
                                                {{ $errors->first('dec_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group {{ $errors->has('contents') ? 'has-error' : '' }}">
                                        <label for="contents">{{ trans('cruds.contacts.fields.contents') }} <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="15" name="contents" id="contents" required autofocus maxlength="1000" placeholder="{{ trans('validation.limited', ['attribute' => 1000]) }}">{{ old('contents') }}</textarea>
                                        @if($errors->has('contents'))
                                            <div class="mt-1 require_error">
                                                {{ $errors->first('contents') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 my-auto">
                            <div class="row mb-2">
                                <button class="btn btn-success m-auto width-lg" type="submit" data-type="1"> {{ trans('global.send') }}</button>
                            </div>
                            <div class="row">
                                <button class="btn btn-danger m-auto width-lg" type="submit" data-type="2"><i class="mdi mdi-email-outline"></i> {{ trans('global.send_email') }}</button>
                            </div>
                        </div>
                        <input type="hidden" name="send_type" id="send_type"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <!-- third party css -->
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- third party css end -->
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice
        {
            background-color: #3a3a3a;
        }
        .select2-container{
            width: 100% !important;
        }
        .select2-selection--single{
            height: 40px !important;
            border-color: #ced4da !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow
        {
            top:6px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            line-height:37px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered
        {
            height: 32px;
            padding: 3px 5px;
        }
        .show-btn
        {
            margin-left: -15px;
        }

        @media only screen and (max-width: 767px) {
            .show-btn
            {
                width: 100%;
                margin-left: 0px;
                margin-top: 8px;
            }
        }

    </style>
@endpush

@push('js')
    <!-- third party js -->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <!-- Init js-->
    <script>
        $(document).ready(function(){
            $('[data-toggle="select2"]').select2();
            $('[maxlength]').maxlength({
                alwaysShow: false,
                threshold: 10,
                warningClass: "badge badge-success",
                limitReachedClass: "badge badge-danger",
                placement: 'bottom',
                separator: ' / '
            });
            $('#contact_form').on('submit', function(evt)
            {
               let type = $(document.activeElement).attr('data-type');
               $('#send_type').val(type);
            });
        });

        let showDetection = () => {
            let dec_id = $('#dec_id').val();
            window.open("{{ url('detections') }}" + '/' + dec_id, "_blank");
        }
    </script>
    <!-- third party js end -->
@endpush
