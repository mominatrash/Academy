<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">

@include('layouts.head')



<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static" data-open="click"
    data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    @include('layouts.navbar')
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    @include('layouts.sidebar')
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">

                @yield('content')

            </div>
        </div>
    </div>


    <!-- END: Content-->



    <!-- BEGIN: Footer-->

    @include('layouts.footer')



</body>
<!-- END: Body-->

</html>
