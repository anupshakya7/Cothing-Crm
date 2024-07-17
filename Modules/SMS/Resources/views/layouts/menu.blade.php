@php
    $route = \Request::route()->getName();

@endphp
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ URL::to('/admin') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets') }}/images/tukutuku_logo.png" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets') }}/images/tukutuku_logo.png" alt="" height="50">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ URL::to('/admin') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets') }}/images/tukutuku_logo.png" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets') }}/images/tukutuku_logo.png" alt="" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ $route == 'admin.dashboard' ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>

                </li>

                <li class="nav-item">
                    <a href="#sidebarEcommercetest" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEcommercetest" data-key="t-ecommerce"><i class="ri-store-2-fill"></i>Orders Management
                    </a>
                    <div class="{{ Request::is('admin/trailer*') || Request::is('admin/order*') || Request::is('admin/delivery*') || Request::is('admin/customer*') ? '' : 'collapse' }} menu-dropdown" id="sidebarEcommercetest">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.order.index', ['tab' => 'All']) }}" class="nav-link {{ Request::is('admin/order*') && !Request::is('admin/order/daily') ? 'active' : '' }}" data-key="t-product-Details"> Order Lists </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.customer.index') }}" class="nav-link {{ Request::is('admin/customer*') ? 'active' : '' }}" data-key="t-products"> Customer Lists  </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.delivery.index') }}" class="nav-link {{ Request::is('admin/delivery*') ? 'active' : '' }}" data-key="t-products"> Delivery Partner  </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.trailer.index') }}" class="nav-link {{ Request::is('admin/trailer*') ? 'active' : '' }}" data-key="t-products"> Trailer Lists  </a>
                            </li>


                            {{-- <li class="nav-item">
                                <a href="{{ route('admin.order.daily') }}" class="nav-link {{ Request::is('admin/order/daily') ? 'active' : '' }}" data-key="t-product-Details"> Daily Orders </a>
                            </li> --}}


                        </ul>
                    </div>
                </li>



                <li class="nav-item">
                    <a href="#categoryProduct" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categoryProduct" data-key="t-product"><i class="bx bx-table"></i>Category Management
                    </a>
                    <div class="{{ Request::is('admin/category*') || Request::is('admin/product*')  ? '' : 'collapse' }} menu-dropdown" id="categoryProduct">
                        <div class="menu-dropdown" id="categoryProduct">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index', ['type' => 1]) }}" class="nav-link {{ Request::input('type') == 1 ? 'active' : '' }}" data-key="t-products">Main Category</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index', ['type' => 2]) }}" class="nav-link {{ Request::input('type') == 2 ? 'active' : '' }}" data-key="t-product-Details">Category</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index', ['type' => 3]) }}" class="nav-link {{ Request::input('type') == 3 ? 'active' : '' }}" data-key="t-product-Details">Sub Category</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.index') }}" class="nav-link {{ Request::is('admin/product*') ? 'active' : '' }}" data-key="t-create-product"> Product </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </li>


                <li class="nav-item">
                    <a href="#sidebarProduct" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProduct" data-key="t-product"><i class="bx bx-sitemap"></i>Product Management
                    </a>
                    <div class="{{ Request::is('admin/measurement*') || Request::is('admin/pattern*')  ? '' : 'collapse' }} menu-dropdown" id="sidebarProduct">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('admin.measurement.index') }}" class="nav-link {{ Request::is('admin/measurement*') ? 'active' : '' }}" data-key="t-product-Details"> Measurement </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.pattern.index') }}" class="nav-link {{ Request::is('admin/pattern*') ? 'active' : '' }}" data-key="t-product-Details"> Pattern </a>
                            </li>


                        </ul>
                    </div>
                </li>



                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/enquiry*') ? 'active' : '' }}"
                        href="{{ route('admin.enquiry.index') }}">
                        <i class="ri-apps-2-line"></i> <span data-key="t-dashboards">Enquiry Management</span>
                    </a>

                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link menu-link {{ $route == 'admin.users.profile' ? 'active' : '' }}"
                        href="{{ route('admin.users.profile') }}">
                        <i class="ri-account-circle-line"></i> <span data-key="t-dashboards">My Profile</span>
                    </a>

                </li> --}}




                <li class="nav-item">
                    <a href="#sidebarEcommerce" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce"><i class="ri-record-circle-line"></i>Suppliers Management
                    </a>
                    <div class="{{ Request::is('admin/vendors*') || Request::is('admin/items*') || Request::is('admin/suppliers*') ? '' : 'collapse' }} menu-dropdown" id="sidebarEcommerce">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.vendors.index') }}" class="nav-link {{ Request::is('admin/vendors*') ? 'active' : '' }}" data-key="t-products"> Suppliers  </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.items.index') }}" class="nav-link {{ Request::is('admin/items*') ? 'active' : '' }}" data-key="t-product-Details"> Items </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.suppliers.index') }}" class="nav-link {{ Request::is('admin/suppliers*') ? 'active' : '' }}" data-key="t-create-product"> Supply Items </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link {{ $route == 'admin.users.index' || $route == 'admin.users.edit' ? 'active' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        <i class="ri-account-circle-line"></i> <span data-key="t-dashboards">Users</span>
                    </a>

                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
