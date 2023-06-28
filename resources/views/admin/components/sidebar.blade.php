<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li class="sidebar-item pt-2">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/admin"
                       aria-expanded="false">
                        <i class="fas fa-chart-line" aria-hidden="true"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/admin/categories"
                       aria-expanded="false">
                        <i class="fa fa-table" aria-hidden="true"></i>
                        <span class="hide-menu">Danh mục</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/admin/subCategories"
                       aria-expanded="false">
                        <i class="fas fa-clipboard-list" aria-hidden="true"></i>
                        <span class="hide-menu">Danh mục phụ</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/admin/products"
                       aria-expanded="false">
                        <i class="fas fa-archive" aria-hidden="true"></i>
                        <span class="hide-menu">Sản phẩm</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/admin/users"
                       aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="hide-menu">Tài khoản</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('admin.orders.success')}}"
                       aria-expanded="false">
                        <i class="far fa-money-bill-alt" aria-hidden="true"></i>
                        <span class="hide-menu">Đơn hàng</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/admin/discounts"
                       aria-expanded="false">
                        <i class="fas fa-percent" aria-hidden="true"></i>
                        <span class="hide-menu">Khuyến mãi</span>
                    </a>
                </li>
                <li class="text-center p-10 upgrade-btn">
                    <a href="{{route('home')}}"
                       class="btn d-grid btn-primary text-white">
                        Trang người dùng</a>
                </li>
                <li class="text-center p-10 upgrade-btn">
                    <a href="{{route('auth.logout')}}"
                       class="btn d-grid btn-danger text-white">
                        Đăng xuất</a>
                </li>
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
