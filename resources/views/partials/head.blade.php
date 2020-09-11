<meta charset="utf-8" />
<title>@lang('global.title')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
<meta content="Coderthemes" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
<!-- App css -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
<style>
    .spinner{
        border-left: 5px solid #323a46 !important;
    }
    .left-side-menu
    {
        background: #5a5959 !important;
    }
    .navbar-custom
    {
        background-color: #37623D;
    }
    #sidebar-menu .menu-title
    {
        color: #f5f6f8 !important;
    }
    #sidebar-menu>ul>li>a {
        color: #f5f6f8 !important;
    }
    .page-title-box .page-title
    {
        color: #275A29 !important;
    }
    .breadcrumb-item>a
    {
        color: #DAA520 !important;
    }
    .breadcrumb-item.active
    {
        color: #cc9409c4 !important;
    }

    .breadcrumb-item+.breadcrumb-item::before
    {
        color: #DAA520 !important;
    }
    .nav-second-level li a, .nav-thrid-level li a
    {
        color:white;
    }
    .enlarged .left-side-menu #sidebar-menu>ul>li>a
    {
        background-color: #5a5959 !important;
    }
    #side-menu > li > ul.nav-second-level
    {
        background-color: #5a5959 !important;
    }

</style>