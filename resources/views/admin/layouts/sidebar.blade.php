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
                    <a class="nav-link menu-link {{ Request::is('admin/trailer*') || Request::is('admin/order*') || Request::is('admin/delivery*') ? '' : 'collapsed' }}"
                        href="#sidebarForms" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Request::is('admin/trailer*') || Request::is('admin/order*') || Request::is('admin/delivery*') ? 'true' : 'false' }}"
                        aria-controls="sidebarForms">
                        <i class="ri-store-2-fill"></i> <span data-key="t-forms">Orders Management</span>
                    </a>
                    <div class="menu-dropdown {{ Request::is('admin/trailer*') || Request::is('admin/order*') || Request::is('admin/delivery*') ? 'collapse show' : 'collapse' }}"
                        id="sidebarForms" style="">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.order.index', ['tab' => 'All']) }}"
                                    class="nav-link {{ Request::is('admin/order*') && !Request::is('admin/order/daily') ? 'active' : '' }}"
                                    data-key="t-product-Details"> Order Lists </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.order.report', ['date_type' => 'Custom']) }}"
                                    class="nav-link {{ Request::is('admin/order/report') ? 'active' : '' }}"
                                    data-key="t-product-Details"> Order Reports </a>
                            </li>



                            <li class="nav-item">
                                <a href="{{ route('admin.delivery.index') }}"
                                    class="nav-link {{ Request::is('admin/delivery*') ? 'active' : '' }}"
                                    data-key="t-products"> Delivery Partner </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.trailer.index') }}"
                                    class="nav-link {{ Request::is('admin/trailer*') ? 'active' : '' }}"
                                    data-key="t-products"> Trailer Lists </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::is('admin/customer*') || Request::is('admin/sms*') || Request::is('admin/sms-message*') ? '' : 'collapsed' }}"
                        href="#smsCustomer" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Request::is('admin/customer*') || Request::is('admin/sms*') || Request::is('admin/sms-message*') ? 'true' : 'false' }}"
                        aria-controls="smsCustomer">
                        <i class="bx bx-male-female"></i> <span data-key="t-forms">Customer management</span>
                    </a>
                    <div class="menu-dropdown {{ Request::is('admin/customer*') || Request::is('admin/sms*') || Request::is('admin/sms-message*') ? 'collapse show' : 'collapse' }}"
                        id="smsCustomer" style="">

                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('admin.customer.index') }}"
                                    class="nav-link {{ Request::is('admin/customer*') ? 'active' : '' }}"
                                    data-key="t-products"> Customer Lists </a>
                            </li>


                            <li class="nav-item">

                                <a href="{{ route('sms.index') }}"
                                    class="nav-link {{ Request::is('admin/sms') ? 'active' : '' }}"
                                    data-key="t-products"> SMS </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('message.index') }}"
                                    class="nav-link {{ Request::is('admin/sms-message') ? 'active' : '' }}"
                                    data-key="t-products"> SMS Messages </a>
                            </li>
                        </ul>
                    </div>

                </li>


                <li class="nav-item">

                    <a class="nav-link menu-link {{ Request::is('admin/category*') || Request::is('admin/product*') ? '' : 'collapsed' }}"
                        href="#categoryProduct" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Request::is('admin/category*') || Request::is('admin/product*') ? 'true' : 'false' }}"
                        aria-controls="categoryProduct">
                        <i class="bx bx-table"></i> <span data-key="t-forms">Category Management</span>
                    </a>
                    <div class="menu-dropdown {{ Request::is('admin/category*') || Request::is('admin/product*') ? 'collapse show' : 'collapse' }}"
                        id="categoryProduct" style="">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index', ['type' => 1]) }}"
                                        class="nav-link {{ Request::is('admin/category*') && Request::input('type') == 1 ? 'active' : '' }}"
                                        data-key="t-products">Main Category</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index', ['type' => 2]) }}"
                                        class="nav-link {{ Request::is('admin/category*') && Request::input('type') == 2 ? 'active' : '' }}"
                                        data-key="t-product-Details">Category</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index', ['type' => 3]) }}"
                                        class="nav-link {{ Request::is('admin/category*') && Request::input('type') == 3 ? 'active' : '' }}"
                                        data-key="t-product-Details">Sub Category</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.product.index') }}"
                                        class="nav-link {{ Request::is('admin/product*') ? 'active' : '' }}"
                                        data-key="t-create-product"> Product </a>
                                </li>
                            </ul>
                        </div>

                </li>


                <li class="nav-item">

                    <a class="nav-link menu-link {{ Request::is('admin/measurement*') || Request::is('admin/pattern*') ? '' : 'collapsed' }}"
                        href="#sidebarProduct" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ Request::is('admin/measurement*') || Request::is('admin/pattern*') ? 'true' : 'false' }}"
                        aria-controls="sidebarProduct">
                        <i class="bx bx-sitemap"></i> <span data-key="t-forms">Product Management
                    </a></span>
                    </a>
                    <div class="menu-dropdown {{ Request::is('admin/measurement*') || Request::is('admin/pattern*') ? 'collapse show' : 'collapse' }}"
                        id="sidebarProduct" style="">


                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('admin.measurement.index') }}"
                                    class="nav-link {{ Request::is('admin/measurement*') ? 'active' : '' }}"
                                    data-key="t-product-Details"> Measurement </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.pattern.index') }}"
                                    class="nav-link {{ Request::is('admin/pattern*') ? 'active' : '' }}"
                                    data-key="t-product-Details"> Pattern </a>
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
                    <a class="nav-link menu-link {{ Request::is('admin/vendors*') || Request::is('admin/items*') || Request::is('admin/suppliers*') ? '' : 'collapsed' }}"
                    href="#sidebarEcommerce" data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ Request::is('admin/vendors*') || Request::is('admin/items*') || Request::is('admin/suppliers*') ? 'true' : 'false' }}"
                    aria-controls="sidebarEcommerce">
                    <i class="ri-record-circle-line"></i> <span data-key="t-forms">Supplier Management</span>
                </a>
                <div class="menu-dropdown {{ Request::is('admin/vendors*') || Request::is('admin/items*') || Request::is('admin/suppliers*') ? 'collapse show' : 'collapse' }}"
                    id="sidebarEcommerce" style="">


                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.items-category.index',['type'=>1]) }}"
                                    class="nav-link {{Request::is('admin/items-category*') && Request::input('type') ==1 ? 'active':'' }}"
                                    data-key="t-product-Details"> Supply Category </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.items-category.index',['type'=>2]) }}"
                                    class="nav-link {{ Request::is('admin/items-category*') && Request::input('type') ==2 ? 'active' : '' }}"
                                    data-key="t-product-Details"> Supply Sub Category </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.items.index') }}"
                                    class="nav-link {{ Request::is('admin/items*') ? 'active' : '' }}"
                                    data-key="t-product-Details">Supply Item </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.vendors.index') }}"
                                    class="nav-link {{ Request::is('admin/vendors*') ? 'active' : '' }}"
                                    data-key="t-products"> Suppliers </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.suppliers.index') }}"
                                    class="nav-link {{ Request::is('admin/suppliers*') ? 'active' : '' }}"
                                    data-key="t-create-product"> Vendor Purchase </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.vendors-payment.index') }}"
                                    class="nav-link {{ Request::is('admin/vendors-payment*') ? 'active' : '' }}"
                                    data-key="t-create-product"> Vendor Payment </a>
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
