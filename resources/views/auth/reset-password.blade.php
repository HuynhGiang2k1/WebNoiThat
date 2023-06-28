@extends('front.base')

@section('content')
    <div class="content product-content">
        <form action="{{route('password.update')}}" method="post" class="edit-information">
            @csrf
            <div class="edit-information-title"><h1>Đổi mật khẩu</h1></div>
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="edit-information-item">
                <label for="">Email</label>
                <input type="email" name="email" value="{{$email}}">
                @error('email')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="edit-information-item">
                <label for="">Mật khẩu</label>
                <input type="password" name="password">
                @error('password')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="edit-information-item">
                <label for="">Nhập lại mật khẩu</label>
                <input type="password" name="passwordConfirm">
                @error('passwordConfirm')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="edit-information-item edit-information-item-btn"">
                <button type="submit">Cập nhật</button>
            </div>
        </form>
    </div>
    <style>
        .edit-information{
            width: 1000px;
            margin: 50px 0 100px;
            padding: 10px;
            /* display:flex;
            flex-direction:column;
            align-items:center; */
        }

        .edit-information-title{
            width: 100%;
            text-align: center;
        }

        .edit-information h1{
            font-family: "Josefin Sans",sans-serif;
            font-weight: 500;
            text-transform: uppercase;
            color: #1d1d1d;
            font-size: 29px;
            line-height: 1.55em;
            letter-spacing: .2em;
            margin: 0 0 40px;
            font-size: 20px;
            line-height: 1.55em;
        }

        .edit-information-item{
            display: flex;
            flex-direction: column;
            margin-bottom: 30px;
            width: 50%;
        }

        .edit-information-item label{
            font-size: 15px;
            color: #8a8a8a;
            line-height: 1.5em;
            margin-bottom: 4px;
        }

        .edit-information-item input{
            display: block;
            border: 1px solid #ccc;
            outline: none;
            padding: 10px 20px;
            font-family: "EB Garamond",serif;
            font-size: 18px;
            font-style: italic;
            line-height: 1.5em;
            color: #8a8a8a;
            cursor: pointer;
        }

        .edit-information-item span{
            padding-top: 9px;
            padding-left: 10px;
            font-size: 15px;
            color: red;
            font-style: italic;
            letter-spacing: 0.5px;
        }

        .edit-information-item-avt input {
            border: none;
        }

        .edit-information-item-btn{
            width: 100%;
            display: flex;
            align-items: center;
        }

        .edit-information-item button{
            background-color: transparent;
            border: 1px solid #8b8b8b;
            font-family: "EB Garamond",serif;
            font-size: 18px;
            font-weight: 400;
            font-style: italic;
            color: #1d1d1d;
            height: 54px;
            padding: 0 30px;
            cursor: pointer;
            transition: all 1s ease;
            width: 20%;
        }

        .edit-information-item button:hover{
            border: 1px solid #1d1d1d;
            color: #8a8a8a;
        }
    </style>
@endsection
