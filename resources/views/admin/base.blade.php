<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
          content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
          content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Admin - HomeFurniture</title>
    <!-- Custom CSS -->
    <link href="{{asset('assets/admin/plugins/bower_components/chartist/dist/chartist.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/style.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{asset('assets/admin/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/admin/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/admin/js/app-style-switcher.js')}}"></script>
    <script src="{{asset('assets/admin/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js')}}"></script>


    <!--Menu sidebar -->
    <script src="{{asset('assets/admin/js/sidebarmenu.js')}}"></script>

    <!--Custom JavaScript -->
    <script src="{{asset('assets/admin/js/custom.js')}}"></script>

    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="{{asset('assets/admin/plugins/bower_components/chartist/dist/chartist.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js')}}"></script>

</head>

<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
     data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    @include('admin.components.header')
    @include('admin.components.sidebar')
    <div class="notification-promotion">
        @if(session('status'))
            <div class="alert alert-success position-fixed w-25 d-flex justify-content-between notification-promotion-item" style="z-index: 999; left: 14%; top:0;" role="alert">
                <span>{{session('status')}}</span>
            </div>
        @endif
        @yield('page-content')
    </div>
</div>


</body>

<style>
    .notification-promotion{
        position: relative;
    }

    .notification-promotion-item{
        z-index: 1 !important;
        position: absolute !important;
        top: 0;
        left: 40% !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        font-size: 15px;
        transition: top 1s ease-in;
        margin-top: 5px !important;
        border-radius: 5px;
        background-color: #b4bcc4 !important;
        text-align: center !important;
        height: 40px;
        width: 300px !important;
    }
</style>

<script>
    const notification = document.getElementsByClassName('notification-promotion-item')[0]
        setTimeout(()=>{
            notification.style.top = "-50px";
        },3000)

</script>
</html>
