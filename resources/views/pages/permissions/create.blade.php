@extends('layouts.admin')
@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.permissions.index') }}">
                            {{ trans('cruds.permission.title_singular') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ trans('global.create') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ trans('global.create') }} {{ trans('cruds.permission.title_singular') }}</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.permissions.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', trans('cruds.permission.fields.title')."*", ['class' => 'col-md-12']) !!}
                        <div class="col-md-12">
                            {!! Form::text('name', old('name', isset($permission) ?? $permission->name), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            @if($errors->has('name'))
                                <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection