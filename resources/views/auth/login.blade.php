<!DOCTYPE html>
<html lang="en">
    <head>
        @include('partials.head')
    </head>
    <body class="authentication-bg authentication-bg-pattern">
        <div class="account-pages mt-6 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div>
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
                                <form role="form" method="POST" action="{{ url('login') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                    <div class="form-group mb-3">
                                        <label for="email">@lang("global.login_email")</label>
                                        <input class="form-control" autofocus type="email" name="email" value="{{ old('email') }}" required="" placeholder="@lang("global.login_email_placeholder")">
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label for="password">@lang("global.login_password")</label>
                                        <input class="form-control" type="password" value="{{ old('password') }}" minlength="6" required autocomplete name="password" placeholder="@lang("global.login_password_placeholder")">
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signin">
                                            <label class="custom-control-label" for="checkbox-signin"> @lang('global.remember_me') </label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="captcha">Captcha</label>
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary btn-block" type="submit"> @lang("global.login") </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End card block -->
                        
{{--                        <div class="row mt-3">--}}
{{--                            <div class="col-12 text-center">--}}
{{--                                <p class="text-white-50">@lang('global.dont_have_account') --}}
{{--                                    <a class="text-white ml-1" href="{{ url('register') }}">--}}
{{--                                        <b> @lang("global.sign_up") </b>--}}
{{--                                    </a>--}}
{{--                                </p>--}}
{{--                            </div> --}}
{{--                        </div>--}}
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