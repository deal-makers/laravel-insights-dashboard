@extends('layouts.admin')
@section('styles')
    <!-- third party css -->
    <link href="{{ asset('admin_assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->
    <style>
        .select2-container{
            width: 100% !important;
        }
        .select2-selection--single{
            height: 32px !important;
            border-color: #ced4da !important;
        }
        .select2-selection__rendered{
            /*line-height: 32px !important;*/
        }
    </style>
@endsection
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.index') }}">
                            {{ trans('cruds.user.title_singular') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ trans('global.create') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.users.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                        @if($errors->has('name'))
                            <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                        @if($errors->has('email'))
                            <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        @if($errors->has('password'))
                            <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                        {!! Form::label('roles', trans('cruds.user.fields.roles')) !!}
                        <div>
                            {!! Form::select('roles[]', $roles, old('roles'), ['class' => 'form-control', 'data-toggle'=>'select2']) !!}
                        </div>
                        @if($errors->has('roles'))
                            <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                                {{ $errors->first('roles') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('trial_type', trans('cruds.user.fields.trial_type')) !!}
                        <div>
                            {!! Form::select('trial_type', $trial_types, old('trial_type'), ['class' => 'form-control', 'data-toggle'=>'select2']) !!}
                        </div>
                        @if($errors->has('trial_type'))
                            <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                                {{ $errors->first('trial_type') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('status', trans('cruds.user.fields.status')) !!}
                        <div>
                            {!! Form::select('status', $status, old('status'), ['class' => 'form-control', 'data-toggle'=>'select2']) !!}
                        </div>
                        @if($errors->has('status'))
                            <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                                {{ $errors->first('status') }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
    <script src="{{ asset('admin_assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/pages/datatables.init.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="select2"]').select2()
        });
    </script>
@endsection