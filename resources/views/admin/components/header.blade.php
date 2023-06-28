<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin6">
            <a class="navbar-brand" href="dashboard.html">

            </a>
            <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
               href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <li>
                    <div class="profile-pic">
                        <img src="https://datarundown.com/wp-content/uploads/2022/03/Datarundown-Admin-Avatar-Circle-1.png" alt="avatar" width="36" class="img-circle">
                        <span class="text-white font-medium">{{\Auth::user()->name}}</span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>


<style>
    .navbar-collapse{
        z-index: 999;
    }
</style>
