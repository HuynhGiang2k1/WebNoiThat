@extends('front.base')

@section('content')
    @php
        if (!$user->address) {
            $address = explode('-', '-0-0-0');
        } else {
            $address = explode('-', $user->address);
        }
    @endphp
    <div class="content product-content">
        <form action="{{route('front.user.update')}}" method="post" enctype="multipart/form-data" class="edit-information">
            @csrf
            <div class="edit-information-title"><h1>Chỉnh sửa thông tin cá nhân</h1></div>
            <div class="edit-information-item">
                <label for="">Tên</label>
                <input type="text" name="name" value="{{old('name') ?? $user->name }}">
                @error('name')
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
                <label for="">Số điện thoại</label>
                <input type="text" name="tel" value="{{old('tel') ?? $user->tel }}">
                @error('tel')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="edit-information-item">
                <label for="province" class="checkout-information-form-item-content-input-label">Tỉnh/ Thành phố *</label>
                <select id="province" name="province" class="checkout-information-form-item-content-input"></select>
            </div>
            <div class="edit-information-item">
                <label for="district" class="checkout-information-form-item-content-input-label">Quận/ Huyện *</label>
                <select id="district" name="district" class="checkout-information-form-item-content-input"></select>
            </div>
            <div class="edit-information-item">
                <label for="ward" class="checkout-information-form-item-content-input-label">Phường/ Xã *</label>
                <select id="ward" name="ward" class="checkout-information-form-item-content-input"></select>
            </div>
            <div class="edit-information-item">
                <label for="street" class="checkout-information-form-item-content-input-label">Tên đường/ Tòa nhà *</label>
                <input type="text" name="street" id="street" class="checkout-information-form-item-content-input" value="{{$address[0]}}">
            </div>
            <div class="edit-information-item edit-information-item-avt">
                <label for="">Ảnh đại diện</label>
                <input type="file" name="avatar" value="{{old('avatar') }}">
                @error('avatar')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="edit-information-item edit-information-item-btn">
                <button type="submit">Lưu</button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            // Load provinces
            $.getJSON('https://vapi.vnappmob.com/api/province', function(provinces) {
                $.each(provinces.results, function(i, province) {
                    if (province.province_id == {{$address[3]}}) {
                        $('#province').append($('<option>', {
                            value: province.province_id,
                            text: province.province_name
                        }));
                    }
                });
            });

            // Load districts
            $.getJSON('https://vapi.vnappmob.com/api/province/district/' + {{$address[3]}}, function(districts) {
                $.each(districts.results, function(i, district) {
                   if (district.district_id == {{$address[2]}}) {
                       $('#district').append($('<option>', {
                           value: district.district_id,
                           text: district.district_name
                       }));
                   }
                });
            });

            // Load wards
            $.getJSON('https://vapi.vnappmob.com/api/province/ward/' + {{$address[2]}} , function(wards) {
                $.each(wards.results, function(i, ward) {
                    if (ward.ward_id == {{$address[1]}}) {
                        $('#ward').append($('<option>', {
                            value: ward.ward_id,
                            text: ward.ward_name
                        }));
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Load provinces
            $.getJSON('https://vapi.vnappmob.com/api/province', function(provinces) {
                $.each(provinces.results, function(i, province) {
                    $('#province').append($('<option>', {
                        value: province.province_id,
                        text: province.province_name
                    }));
                });
            });

            // Load districts
            $('#province').change(function() {
                var province_id = $('#province').val();
                $('#district').empty();
                $('#ward').empty();
                $.getJSON('https://vapi.vnappmob.com/api/province/district/' + province_id, function(districts) {
                    $.each(districts.results, function(i, district) {
                        $('#district').append($('<option>', {
                            value: district.district_id,
                            text: district.district_name
                        }));
                    });
                });
            });

            // Load wards
            $('#district').change(function() {
                var province_id = $('#province').val();
                var district_id = $('#district').val();
                $('#ward').empty();
                $.getJSON('https://vapi.vnappmob.com/api/province/ward/' + district_id , function(wards) {
                    $.each(wards.results, function(i, ward) {
                        $('#ward').append($('<option>', {
                            value: ward.ward_id,
                            text: ward.ward_name
                        }));
                    });
                });
            });
        });
    </script>
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
