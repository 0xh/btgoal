@extends('spark::layouts.no-app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="s-logo">
                        <img src="/img/mono-logo.png">
                    </div>
                </div>

                <div class="panel-body login">
                    @include('spark::shared.errors')

                    <form role="form" method="POST" action="/login">
                        {{ csrf_field() }}

                        <!-- E-Mail Address -->
                        <div class="form-group">
                            <label class=" control-label">Email address</label>

                            <div class="input-icon">
                                <i class="fa fa-envelope-o  fa-lg" aria-hidden="true"></i>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label class=" control-label">Password</label>

                            <div class="input-icon">
                                <i class="fa fa-lock  fa-lg" aria-hidden="true"></i>
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="form-group">
                            <div >
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                Login
                            </button>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot your password?</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="already">
                <div class="pull-left top-s">
                    <a  href="http://bettergoals.com.au" target="_blank">About Better Goals</a>
                </div>
                <div class="pull-right">
                    <span>Don't have an account? </span>
                    <a class="btn btn-default" href="/register">Sign up</a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
