<!DOCTYPE html>
<html lang="en">
    <head>
        @include('partials.head')
    </head>
    <body class="authentication-bg authentication-bg-pattern">
        <div class="account-pages mt-6 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        
                        <!-- Start card block -->
                        <div class="card bg-pattern">
                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <a href="{{ url("/") }}">
                                        <span><img src="{{ asset('assets/images/logo-dark-old.png') }}" alt="" height="25"></span>
                                    </a>
                                </div>
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger bg-danger text-white border-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <label>{{ $error }}</label>
                                        @endforeach
                                    </div>
                                @endif
                                <form role="form" method="POST" action="{{ url('register') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group mb-3">
                                        <label for="name">@lang("global.user_name")</label>
                                        <input class="form-control" autofocus name="name" value="{{ old('name') }}" required="" placeholder="@lang("global.signup_name_placeholder")">
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="name">@lang("global.login_email")</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required="" placeholder="@lang("global.login_email_placeholder")">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">@lang("global.login_password")</label>
                                        <input class="form-control" type="password" required="" value="{{ old('password') }}" autocomplete name="password" minlength="6" placeholder="@lang("global.login_password_placeholder")">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">@lang("global.login_password_confirmation")</label>
                                        <input class="form-control" type="password" value="{{ old('password_confirmation') }}" required autocomplete name="password_confirmation" minlength="6" placeholder="@lang("global.signup_password_confirm_placeholder")">
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signup" required>
                                            <label class="custom-control-label" for="checkbox-signup">@lang('global.i_accept') 
                                                <a href="#" class="text-dark">@lang('global.team_condition')</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" type="submit"> @lang("global.sign_up") </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- End card block -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">@lang('global.already_have_account') 
                                    <a class="text-white ml-1" href="{{ url('login') }}">
                                        <b> @lang("global.sign_in") </b>
                                    </a>
                                </p>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <footer class="footer footer-alt">
            @lang('global.login_footer_bar') <a href="" class="text-white-50">@lang('global.login_footer_item')</a> 
        </footer>

        <!-- js -- >
        @include('partials.js')
    </body>
</html>