
<ul class="list-unstyled topnav-menu float-right mb-0">

    <li class="dropdown notification-list">
        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <img src="@if(is_null(Auth::user()->avatar) || empty(Auth::user()->avatar))
            {{ asset('assets/images/users/default.png') }}
            @else
            {{ asset('storage/images/avatars')."/".Auth::user()->avatar }}
            @endif
            " alt="user-image" class="rounded-circle">
            <span class="pro-user-name ml-1">
                {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
            <!-- item-->
            <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">@lang('global.welcome') !</h6>
            </div>

            <!-- item-->
            <a href="#" class="dropdown-item notify-item">
                <i class="fe-user"></i>
                <span>@lang('global.my_account')</span>
            </a>

            <!-- item-->
            <a href="{{ route('auth.change_password') }}" class="dropdown-item notify-item">
                <i class="fas fa-key"></i>
                <span>@lang('global.change_password')</span>
            </a>

            <div class="dropdown-divider"></div>

            <!-- item-->
            <a href="javascript:void(0);" class="dropdown-item notify-item"  onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="fe-log-out"></i>
                <span>@lang('global.logout')</span>
            </a>

        </div>
    </li>

</ul>

<!-- LOGO -->
<div class="logo-box">
    <a href="/" class="logo text-center">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="25">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="45">
        </span>
    </a>
</div>
<ul class="list-unstyled topnav-menu topnav-menu-left m-0">
    <li>
        <button class="button-menu-mobile waves-effect waves-light">
            <i class="fe-menu"></i>
        </button>
    </li>
</ul>