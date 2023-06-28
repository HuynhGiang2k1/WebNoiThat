@extends('front.user.sidebar')
{{--@section('title', 'aaa')--}}

@section('myPageContent')
    @php
        if (!$user->address) {
            $address = explode('-', '-0-0-0');
        } else {
            $address = explode('-', $user->address);
        }
    @endphp
    <div class="user-information">
        <div class="user-information-img">
            @if($user->avatar)
                <img src="{{asset('avatars/'.$user->avatar)}}" alt="">
            @else
                <img src="{{asset('logo/no-avatar.png')}}" alt="">
            @endif
        </div>
        <div class="user-information-content">
            <table>
                <tr>
                    <th><span>Họ và tên:</span></th>
                    <td><span>{{$user->name}}</span></td>
                </tr>
                <tr>
                    <th><span>Email:</span></th>
                    <td><span>{{$user->email}}</span></td>
                </tr>
                <tr>
                    <th><span>Số điện thoại:</span></th>
                    <td><span>{{$user->tel}}</span></td>
                </tr>
                <tr>
                    <th><span>Địa chỉ:</span></th>
                    <td>
                        <span>{{$address[0]}},</span>
                        <span id="ward"></span>
                        <span id="district"></span>
                        <span id="province"></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Load provinces
            $.getJSON('https://vapi.vnappmob.com/api/province', function(provinces) {
                $.each(provinces.results, function(i, province) {
                    if(province.province_id == {{$address[3]}}) {
                        $('#province').html(province.province_name);
                    }
                });
            });

            // Load districts
            $.getJSON('https://vapi.vnappmob.com/api/province/district/' + {{$address[3]}}, function(districts) {
                $.each(districts.results, function(i, district) {
                    if(district.district_id == {{$address[2]}}) {
                        $('#district').html(district.district_name + ', ');
                    }
                });
            });

            // Load wards
            $.getJSON('https://vapi.vnappmob.com/api/province/ward/' + {{$address[2]}} , function(wards) {
                $.each(wards.results, function(i, ward) {
                    if(ward.ward_id == {{$address[1]}}) {
                        $('#ward').html(ward.ward_name + ', ');
                    }
                });
            });
        });
    </script>
    <style>
        .user-information{
            display: flex;
            align-items: center;
            min-width: 500px;
            min-height: 300px;
            margin:50px;
            border: 1px solid #ccc;
            box-shadow: 0 5px 5px rgba(0,0,0,.6);
            border-radius: 10px;
        }

        .user-information-img{
            border-radius: 20px;
            width: 200px;
            height:200px;
            margin: 50px;
        }

        .user-information-img img{
            border-radius: 20px;
            width: 200px;
            height:200px;
        }

        .user-information-content{
            width:100%;
            text-align: left;
        }

        .user-information-content table tr td{
            font-family: "Open Sans",sans-serif;
            font-size: 15px;
            line-height: 1.8em;
            font-weight: 400;
            color: #8b8b8b;
        }
    </style>
@endsection
