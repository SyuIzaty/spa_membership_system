<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
            <title>{{ config('app.name', 'Raudhah Serenity') }}</title>
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <meta content="" name="keywords">
            <meta content="" name="description">

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/img/favicon/apple-touch-icon.jpg') }}">
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/img/favicon/favicon-32x32.jpg') }}">
            <link rel="mask-icon" href="{{ asset('admin/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>

        <style>
            body {
                margin: 0;
                color: #ffffff;
                background: #ffffff;
                font: 16px/18px "Open Sans", sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                letter-spacing: 2px;
            }

            .login-box{
                width:100%;
                margin:auto;
                max-width:525px;
                min-height:670px;
                position:relative;
                background: url("{{ asset('customer/img/carousel-4.jpg') }}") no-repeat center;
                box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
            }
            .login-snip{
                width:100%;
                height:100%;
                position:absolute;
                padding:55px 55px 55px 55px;
                background:#ff4f9d94;
            }
            .login-snip .login,
            .login-snip .sign-up-form{
                top:0;
                left:0;
                right:0;
                bottom:0;
                position:absolute;
                transform:rotateY(180deg);
                backface-visibility:hidden;
                transition:all .4s linear;
            }
            .login-snip .sign-in,
            .login-snip .sign-up,
            .login-space .group .check{
                display:none;
            }
            .login-snip .tab,
            .login-space .group .label,
            .login-space .group .button{
                text-transform:uppercase;
            }
            .login-space .group .input:focus {
                outline: none;
                border: 2px solid #f67db3;
                background-color: rgba(255, 255, 255, 0.5);
                box-shadow: 0 0 5px #ff4f9d;
            }
            .login-snip .tab{
                font-size:22px;
                margin-right:15px;
                padding-bottom:5px;
                margin:0 15px 10px 0;
                display:inline-block;
                border-bottom:2px solid transparent;
            }
            .login-snip .sign-in:checked + .tab,
            .login-snip .sign-up:checked + .tab{
                color:#fff;
                border-color:#fff;
            }
            .login-space{
                min-height:345px;
                position:relative;
                perspective:1000px;
                transform-style:preserve-3d;
            }
            .login-space .group{
                margin-bottom:15px;
            }
            .login-space .group .label,
            .login-space .group .input,
            .login-space .group .button{
                width:100%;
                color:#fff;
                display:block;
            }
            .login-space .group .input,
            .login-space .group .button{
                border:none;
                padding:15px 20px;
                border-radius:25px;
                background:rgb(255 255 255 / 28%);
            }
            .login-space .group input[data-type="password"]{
                text-security:circle;
                -webkit-text-security:circle;
            }
            .login-space .group .label{
                color:#ffe4e4;
                font-size:12px;
            }
            .login-space .group .button{
                background:#ff4f9d;
            }
            .login-space .group label .icon{
                width:15px;
                height:15px;
                border-radius:2px;
                position:relative;
                display:inline-block;
                background:rgba(255,255,255,.1);
            }
            .login-space .group label .icon:before,
            .login-space .group label .icon:after{
                content:'';
                width:10px;
                height:2px;
                background:#fff;
                position:absolute;
                transition:all .2s ease-in-out 0s;
            }
            .login-space .group label .icon:before{
                left:3px;
                width:5px;
                bottom:6px;
                transform:scale(0) rotate(0);
            }
            .login-space .group label .icon:after{
                top:6px;
                right:0;
                transform:scale(0) rotate(0);
            }
            .login-space .group .check:checked + label{
                color:#fff;
            }
            .login-space .group .check:checked + label .icon{
                background:#ff4f9d;
            }
            .login-space .group .check:checked + label .icon:before{
                transform:scale(1) rotate(45deg);
            }
            .login-space .group .check:checked + label .icon:after{
                transform:scale(1) rotate(-45deg);
            }
            .login-snip .sign-in:checked + .tab + .sign-up + .tab + .login-space .login{
                transform:rotate(0);
            }
            .login-snip .sign-up:checked + .tab + .login-space .sign-up-form{
                transform:rotate(0);
            }

            *,:after,:before{box-sizing:border-box}
            .clearfix:after,.clearfix:before{content:'';display:table}
            .clearfix:after{clear:both;display:block}
            a{color:inherit;text-decoration:none}


            .hr{
                height:2px;
                margin:40px 0 40px 0;
                background:rgba(255,255,255,.2);
            }
            .foot{
                text-align:center;
            }
            .card{
                width: 500px;
                left: 100px;
            }

            ::placeholder{
            color: #b3b3b3;
            }
        </style>
    </head>
    <body>
        <div class="login-box">
            <div class="login-snip">
                <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
                <label for="tab-1" class="tab" style="font-family: 'PT Serif', serif; font-weight: 500;">Login</label>
                <input id="tab-2" type="radio" name="tab" class="sign-up">
                <label for="tab-2" class="tab" style="font-family: 'PT Serif', serif; font-weight: 500;"></label>
                <div class="login-space">
                    <div class="login">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><p style="font-size: 12px"> {{$error}} </p></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li><p style="font-size: 12px">{{ session('success') }}</p></li>
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="group">
                                <label for="username" class="label" style="margin-bottom: 10px; margin-top: 40px">Username</label>
                                <input id="username" type="text" class="input" name="username" value="{{ old('username') }}" required autofocus>
                                <small class="form-text text-muted">
                                    The username is your email before the @ <br>
                                    e.g: raudhah@example.com → raudhah
                                </small>
                            </div>
                            <br>
                            <div class="group">
                                <label for="password" class="label" style="margin-bottom: 10px">Password</label>
                                <input id="password" type="password" class="input" name="password" required autocomplete="off">
                            </div>
                            <br>
                            <div class="group" style="font-size: 12px">
                                <input id="check" type="checkbox" class="check" checked>
                                <label for="check"><span class="icon"></span> Remember Me</label>
                            </div>
                            <div class="group">
                                <button type="submit" class="button">
                                    <span class="font-weight-bold">Login</span>
                                </button>
                            </div>
                        </form>
                        <div class="hr"></div>
                        <div class="foot" style="text-align: right; font-size: 12px;">
                            <a href="/signup" style="display: block; text-decoration: none; color: #fff;">
                                <i class="fa fa-user" style="margin-right: 5px;"></i> Signup
                            </a><br>
                            <a href="/password" style="display: block; text-decoration: none; color: #fff;">
                                <i class="fa fa-key" style="margin-right: 5px;"></i> Forgot Password?
                            </a><br>
                            <a href="/home" style="display: block; text-decoration: none; color: #fff;">
                                <i class="fa fa-home" style="margin-right: 5px;"></i> Return Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
