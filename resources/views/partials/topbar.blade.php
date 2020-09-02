
<ul class="list-unstyled topnav-menu float-right mb-0">
    @php
        $curUserId = Auth::user()->id;
        if(Auth::user()->hasRole('client'))
        {
            $notificationLst = \App\Models\Notification::where('seen_users', 'NOT LIKE', '%%%'.serialize($curUserId).'%%')
            ->where('send_clients', 'REGEXP', '.*;s:[0-9]+:"'.$curUserId.'".*')->orderBy('id', 'desc')->get();
        } else {
            $notificationLst = \App\Models\Notification::where('seen_users', 'NOT LIKE', '%%%'.serialize($curUserId).'%%')->where('creater_id', '<>', $curUserId)->orderBy('id', 'desc')->get();
        }
        $notiCnt = sizeof($notificationLst);
    @endphp
    <li class="dropdown notification-list">
        <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <i class="fe-bell noti-icon"></i>
            @if($notiCnt > 0)
            <span class="badge badge-danger rounded-circle noti-icon-badge">{{ $notiCnt }}</span>
            @endif
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
                @if($notiCnt == 0)
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <p class="notify-details">
                        @lang('global.msg.no_notification')
                    </p>
                </a>
                @else

                    @foreach($notificationLst as $row)
                    <!-- item-->
                    <a href="{{ route('detections.edit', $row->detection_id) }}" class="dropdown-item notify-item" title="{{ session('dec_type')[$row->detection_type] }}">
                        @if($row->detection_type == 2)
                        <div class="notify-icon bg-danger">
                            <i class="fe-zap"></i>
                        </div>
                        @elseif($row->detection_type == 0)
                            <div class="notify-icon bg-warning">
                                <i class="fe-rss"></i>
                            </div>
                        @elseif($row->detection_type == 1)
                            <div class="notify-icon bg-warning">
                                <i class="fe-share-2"></i>
                            </div>
                        @elseif($row->detection_type == 3)
                            <div class="notify-icon bg-info">
                                <i class="fe-tv"></i>
                            </div>
                        @elseif($row->detection_type == 4)
                            <div class="notify-icon bg-info">
                                <i class="fe-crop"></i>
                            </div>
                        @elseif($row->detection_type == 5)
                            <div class="notify-icon bg-danger">
                                <i class="fe-shield-off"></i>
                            </div>
                        @elseif($row->detection_type == 6)
                            <div class="notify-icon bg-dark">
                                <i class="fe-gitlab"></i>
                            </div>
                        @elseif($row->detection_type == 7)
                            <div class="notify-icon bg-warning">
                                <i class="fe-bold"></i>
                            </div>
                        @elseif($row->detection_type == 8)
                            <div class="notify-icon bg-dark">
                                <i class="fe-wifi-off"></i>
                            </div>
                        @endif
                        <p class="notify-details"><label class="text-dark">{{ session('dec_type')[$row->detection_type] }}</label><br>
                            {{ \App\models\Detection::find($row->detection_id)->title }}
                            <small class="text-muted">{{ \App\models\Notification::time_elapsed_string($row->created_at) }}</small>
                        </p>
                    </a>
                    @endforeach
                @endif
            </div>


        @if($notiCnt > 0)
            <!-- All-->
            <a href="#" class="dropdown-item text-center text-primary notify-item notify-all">
                @lang('global.view_more')
                <i class="fi-arrow-right"></i>
            </a>
        @endif


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