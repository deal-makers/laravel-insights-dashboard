@extends('layouts.app')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('users.index') }}">
                            {{ trans('cruds.user.title_singular') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ trans('global.change_password') }}</li>
                </ol>
            </div>
            <h4 class="page-title">@lang('global.change_password')</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="card">
    <div class="card-body">
        <form action="{{ route('auth.change_password') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
                <label for="current_password">Current password *</label>
                <input type="password" id="current_password" minlength="6" name="current_password" class="form-control" required>
                @if($errors->first() == "Current password is incorrect")
                    <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                        {{ $errors->first() }}
                    </div>@endif
            </div>
            <div class="form-group {{ $errors->has('new_password') ? 'has-error' : '' }}">
                <label for="new_password">New password *</label>
                <input type="password" id="new_password" name="new_password" minlength="6" class="form-control" required>
                @if($errors->has('new_password'))
                    <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                        {{ $errors->first('new_password') }}
                    </div>
                @endif
            </div>
            <div class="form-group {{ $errors->has('new_password_confirmation') ? 'has-error' : '' }}">
                <label for="new_password_confirmation">New password confirmation *</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" minlength="6" class="form-control" required>
                @if($errors->has('new_password_confirmation'))
                    <div class="mt-1" style="color: #e6334d; font-weight: 500;">
                        {{ $errors->first('new_password_confirmation') }}
                    </div>
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection