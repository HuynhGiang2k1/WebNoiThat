@extends('front.base')
@section('title', 'Blog - HomeFurniture')
@section('content')
    <div class="blog content">
        <div class="blog-wrapper">
            <div class="cart-top">
                <span><a href="{{route('home')}}">Trang chủ</a></span>
                <span>-</span>
                <span>Blog</span>
            </div>

            <div class="blog-wrapper-content">
                <div class="blog-wrapper-content-left">
                    <span class="blog-wrapper-content-left-item">About us</span>
                    <span class="blog-wrapper-content-left-item">Categories</span>
                    <span class="blog-wrapper-content-left-item">Instagram</span>
                </div>
                <div class="blog-wrapper-content-right">
                    <div class="blog-wrapper-content-right-item">
                        <img src="{{asset('banner/3-2.png')}}" alt="">
                        <span>Blog-By HomeFurniture-27/03/2023</span>
                        <h1>Bí quyết vệ sinh, bảo quản nội thất gỗ công nghiệp</h1>
                        <span></span>
                    </div>

                    <div class="blog-wrapper-content-right-item">
                        <img src="{{asset('banner/3-3.png')}}" alt="">
                        <span>Blog-By HomeFurniture-27/03/2023</span>
                        <h1>5 Lời khuyên cho bàn làm việc hoàn hảo tại nhà</h1>
                        <span>5 lời khuyên cho bàn làm việc hoàn hảo tại nhà Một văn phòng tại gia cần có những yếu tố nào? Tham khảo 5 lời khuyên hữu ích và bắt tay vào sắp xếp lại góc làm việc của bạn nhé!  # 1 Chọn vị trí thoải mái  Hãy chắc chắn nơi bạn đặt […]</span>
                    </div>

                    <div class="blog-wrapper-content-right-item">
                        <img src="{{asset('banner/3-1.png')}}" alt="">
                        <span>Blog-By HomeFurniture-27/03/2023</span>
                        <h1>Mẹo bố trí phòng ngủ để đêm ngon giấc</h1>
                        <span>Phòng ngủ là không gian cá nhân để bạn tận hưởng sự thư giãn sau một ngày dài. Đầu tư cho phòng ngủ cũng chính là đầu
                            tư cho sức khoẻ của bạn. Bố trí phòng ngủ như thế nào để có giấc ngủ ngon, thoải mái. Tham khảo một số mẹo của
                            HomeFurniture nhé!  […]</span>
                    </div>

                    <div class="blog-wrapper-content-right-item">
                        <img src="{{asset('banner/2-1.png')}}" alt="">
                        <span>Blog-By HomeFurniture-27/03/2023</span>
                        <h1>Phân biệt các loại gỗ công nghiệp</h1>
                        <span>Nội thất làm từ gỗ công nghiệp liệu có bền? Gỗ công nghiệp là gì? Làm thế nào để phân biệt được các loại gỗ hiện nay
                            trên thị trường? HomeFurniture sẽ giúp bạn trả lời tất cả các câu hỏi này. Cùng tìm hiểu kỹ nếu như bạn đang có nhu cầu
                            sử dụng […]</span>
                    </div>

                    <div class="blog-wrapper-content-right-item">
                        <img src="{{asset('banner/1.png')}}" alt="">
                        <span>Blog-By homefurniture-27/03/2023</span>
                        <h1>Tại sao gỗ sồi được yêu thích ở các nước âu mỹ</h1>
                        <span>Nguồn gốc gỗ Sồi là loại cây thuộc vùng khí hậu ôn đới lạnh, phổ biến ở khu vực châu Mỹ, châu Á, Bắc Phi,châu Âu. Cây
                            gỗ Sồi chắc khỏe, thân gỗ chắc, vân đẹp nên được ứng dụng rất nhiều trọng nội thất. Hiện tại, HomeFurniture sử dụng gỗ
                            Sồi được [...] </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
