
<ul class="list-unstyled topnav-menu float-right mb-0">
    <li class="dropdown notification-list">
        <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <i class="fe-bell noti-icon"></i>
            <span class="badge badge-danger rounded-circle noti-icon-badge">9</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-lg">
            <!-- item-->
            <div class="dropdown-item noti-title">
                <h5 class="m-0">
                    <span class="float-right">
{{--                        <a href="" class="text-dark">--}}
{{--                            <small>@lang('global.clear_all')</small>--}}
{{--                        </a>--}}
                    </span>@lang('global.notifications')
                </h5>
            </div>

            <div class="slimscroll noti-scroll">
                @php
                    $curUserId = Auth::user()->id;
                    if(Auth::user()->hasRole('client'))
                    {
                        $notificationLst = \App\Models\Notification::where('seen_users', 'NOT REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->get();
                    } else {
                        $notificationLst = \App\Models\Notification::where('seen_users', 'NOT REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->where('created_id');
                    }



                @endphp



                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item active">
                    <div class="notify-icon">
                        <img src="{{ asset('assets/images/users/default.png') }}" class="img-fluid rounded-circle" alt="" /> </div>
                    <p class="notify-details">Cristina Pride</p>
                    <p class="text-muted mb-0 user-msg">
                        <small>Hi, How are you? What about our next meeting</small>
                    </p>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <div class="notify-icon bg-primary">
                        <i class="mdi mdi-comment-account-outline"></i>
                    </div>
                    <p class="notify-details">Caleb Flakelar commented on Admin
                        <small class="text-muted">1 min ago</small>
                    </p>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <div class="notify-icon bg-warning">
                        <i class="mdi mdi-account-plus"></i>
                    </div>
                    <p class="notify-details">New user registered.
                        <small class="text-muted">5 hours ago</small>
                    </p>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <div class="notify-icon bg-info">
                        <i class="mdi mdi-comment-account-outline"></i>
                    </div>
                    <p class="notify-details">Caleb Flakelar commented on Admin
                        <small class="text-muted">4 days ago</small>
                    </p>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <div class="notify-icon bg-secondary">
                        <i class="mdi mdi-heart"></i>
                    </div>
                    <p class="notify-details">Carlos Crouch liked
                        <b>Admin</b>
                        <small class="text-muted">13 days ago</small>
                    </p>
                </a>
            </div>

            <!-- All-->
            <a href="#" class="dropdown-item text-center text-primary notify-item notify-all">
                @lang('global.view_more')
                <i class="fi-arrow-right"></i>
            </a>

        </div>
    </li>
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
            <img src="{{ asset('assets/images/Imagem1.png') }}" alt="" height="40">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-sm-1.png') }}" alt="" height="45">
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