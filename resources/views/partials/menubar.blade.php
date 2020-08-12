
<div id="sidebar-menu">
    <ul class="metismenu" id="side-menu">
        <li class="menu-title">@lang('global.title')</li>
        <li>
            <a href="#">
                <i class="fe-users"></i>
                <span> {{ trans('cruds.userManagement.title') }} </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li>
                    <a href="{{ route('permissions.index') }}">
                        <i class="fa-fw fas fa-unlock-alt"></i>
                        <span> {{ trans('cruds.permission.title') }} </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}">
                        <i class="fa-fw fas fa-briefcase"></i>
                        <span> {{ trans('cruds.role.title') }} </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="fa-fw fas fa-user"></i>
                        <span> {{ trans('cruds.user.title') }} </span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>