@extends('front.base')
@section('content')
    <style type="text/css">
        .content {
            margin-left: 100px;
            background:url({{asset('banner/notfound.png')}}) no-repeat right top;
            background-size: contain;
        }
        @media screen and (max-width: 767px){
            .content{
                background: none;
            }
        }

        h2 {
            border-bottom:1px dotted #aaa;
            margin-bottom:20px;
            color:#555;
            padding-bottom: 20px;
        }

        #errorNo {
            line-height:1em;
            font-size: 20em;
            letter-spacing:-0.07em;
        }
        @media screen and (max-width: 767px){
            #errorNo {
                font-size: 10em;
            }
        }

        #errorText {
            font-size: 2em;
            margin-bottom:20px;
        }
    </style>
    <div class="content clearfix notfound" >
        <p id="errorNo">403</p>
        <p id="errorText">Page Forbidden</p>
        <h2>Lạc đường? Đừng lo lắng, bị lạc là một phần của cuộc phiêu lưu.</h2>
        <div class="other">
            <div class="exp">
                <p>Trang bạn đang tìm không thể truy cập.
                    Nó có thể tạm thời không truy cập được, hoặc nó có thể đã bị di chuyển hoặc xóa.</p>
                <div class="wrapper-link-hover" style="margin-bottom: 20px; margin-top: 20px;">
                    <a href="{{route('home')}}" class="link-hover" style="color: #0c63e4">Trở về trang chủ</a>
                </div>
            </div>
        </div><!--other-->
    </div><!--contents-->

@endsection
