@extends('layouts.user')
@section('styles')

@endsection
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Waiting for Approval</div>

                    <div class="card-body">
                        @if(Auth::user()->status == "Pending")
                            Your account is waiting for our administrator approval.
                        @else
                            Your account is rejected by administrator.
                        @endif
                        <br />
                        <a href="javascript:void(0);" class="text-white-50" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                            Please check back.
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@parent

@endsection