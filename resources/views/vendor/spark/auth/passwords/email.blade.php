@extends('spark::layouts.no-app')

<!-- Main Content -->
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
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form role="form" method="POST" action="{{ url('/password/email') }}">
                        {!! csrf_field() !!}

                        <!-- E-Mail Address -->
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class=" control-label">Email address</label>

                            <div class="input-icon">
                                <i class="fa fa-envelope-o  fa-lg" aria-hidden="true"></i>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Send Password Reset Link Button -->
                        <div class="form-group">
                            <div >
                                <button type="submit" class="btn btn-primary">
                                    Send password reset link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="already">
                <div class="pull-left top-s">
                    <a  href="#">About Better Goals</a>
                </div>
                <div class="pull-right">
                    <span>Go back to </span>
                    <a class="btn btn-default" href="/login">Login</a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
