@extends('front.base')

@section('content')
    <div class="content" style="height: 80vh;font-family: 'EB Garamond',serif;">
        <div class="login-box ">
            <h2>Quên mật khẩu</h2>
            <form action="{{route('password.email')}}" method="post">
                @csrf
                <div class="user-box">
                    <input type="email" name="email" required="">
                    <label for="">Email</label>
                </div>
                <div class="login-box-btn">
                    <button type="submit">Gửi mail xác nhận</button>
                </div>
            </form>
            <div class="login-box-forgot-password">
                @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                @if(session('status'))
                    <span>{{session('status')}}</span>
                @endif
            </div>
        </div>
    </div>
    <style>
        .login-box {
            position: absolute;
            top: 25%;
            left: 50%;
            width: 500px;
            padding: 40px;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,.5);
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0,0,0,.6);
            border-radius: 10px;
            display: block;
            background: linear-gradient(#6c6c6c, #c0c0c0);
        }

        .login-box h2 {
            margin: 0 0 30px;
            padding: 0;
            color: #fff;
            text-align: center;
        }

        .login-box .user-box {
            position: relative;
        }

        .login-box .user-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #fff;
            outline: none;
            background-color: transparent;
        }
        .login-box .user-box label {
            position: absolute;
            top:0;
            left: 0;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            pointer-events: none;
            transition: .5s;
        }

        .login-box .user-box input:focus ~ label,
        .login-box .user-box input:valid ~ label {
            top: -20px;
            left: 0;
            color: #03e9f4;
            font-size: 12px;
        }

        .login-box-btn{
            margin-bottom: 10px;
            display:flex;
            align-items:center;
            justify-content: center;
            width: 100%;
        }

        .login-box form button {
            position: relative;
            display: block;
            padding: 10px 20px;
            color: #fff;
            font-size: 14px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            letter-spacing: 2px;
            background-color: transparent;
            cursor: pointer;
            outline: none;
            border: none;
            margin-bottom: 10px;
        }

        .login-box button:hover {
            background: #fff;
            color: #1d1d1d;
            border-radius: 8px;
            box-shadow: 0 0 2px #03e9f4,0 0 10px #03e9f4,0 0 20px #03e9f4,0 0 50px #03e9f4;
        }

        .login-box button span {
            position: absolute;
            display: block;
        }

        .login-box button span:nth-child(1) {
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #1d1d1d);
            animation: btn-anim1 1s linear infinite;
        }

        @keyframes btn-anim1 {
            0% {
                left: -100%;
            }
            50%,100% {
                left: 100%;
            }
        }

        .login-box button span:nth-child(2) {
            top: -100%;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent, #1d1d1d);
            animation: btn-anim2 1s linear infinite;
            animation-delay: .25s
        }

        @keyframes btn-anim2 {
            0% {
                top: -100%;
            }
            50%,100% {
                top: 100%;
            }
        }

        .login-box button span:nth-child(3) {
            bottom: 0;
            right: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(270deg, transparent, #1d1d1d);
            animation: btn-anim3 1s linear infinite;
            animation-delay: .5s
        }

        @keyframes btn-anim3 {
            0% {
                right: -100%;
            }
            50%,100% {
                right: 100%;
            }
        }

        .login-box button span:nth-child(4) {
            bottom: -100%;
            left: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(360deg, transparent, #1d1d1d);
            animation: btn-anim4 1s linear infinite;
            animation-delay: .75s
        }

        @keyframes btn-anim4 {
            0% {
                bottom: -100%;
            }
            50%,100% {
                bottom: 100%;
            }
        }

        .login-box-forgot-password{
            font-family: "Handlee", Roboto;
            margin-top: 20px;
            text-align: center;
        }

        .login-box-forgot-password a{
            color: #8b8b8b;

        }

        .login-box-forgot-password a:hover{
            color: #03e9f4;
            transition: all 1s ease;
        }

        .login-box-options{
            margin-top: 20px;
            font-family: "Handlee", Roboto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .login-box-options a{
            display: flex;
            align-items: center;
            color: #fff;
        }

        .login-box-options a span{
            margin-right: 5px;
        }

        .login-box-options a:hover{
            color: #1d1d1d;
            transition: all 1s ease;
        }

        .login-remember{
            display: flex;
            align-items: center;
            margin-bottom: 10px;

        }

        .login-remember label{
            margin-left: 5px;
            color: #fff;
        }
    </style>
@endsection
