<!DOCTYPE html>
<html lang="en">
<?
include('class/database.php');
if((!isset($_SESSION['adminlog']) && empty($_SESSION['adminlog']))){
    echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
    return 0;
}
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>پنل مدیریت</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>


    <!-- select2 -->
    <link href="css/select2.min.css" rel="stylesheet"/>
    <script src="js/select2.min.js"></script>
    <script src="js/select2.full.js"></script>

    <link type="text/css" rel="stylesheet" href="css/kamadatepicker.css"/>
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css"/>

    <script src="js/kamadatepicker.js"></script>


    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function () {
            $('.userlist').select2({
                dir: "rtl"
            });
        });
    </script>


</head>


<body class="fix-header fix-sidebar">
<!-- Preloader - style you can find in spinners.css -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<!-- Main wrapper  -->
<div id="main-wrapper">
    <!-- header header  -->
    <div class="header">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <!-- Logo -->
            <div class="navbar-header">
                <a class="navbar-brand" href="panel.php">
                    <!-- Logo text -->
                    <span><img src="images/hamitech.png" alt="homepage" height="70" class="dark-logo"/></span>
                </a>
            </div>
            <!-- End Logo -->
            <div class="navbar-collapse">
                <!-- toggle and nav items -->
                <ul class="navbar-nav mr-auto mt-md-0">
                    <!-- This is  -->
                    <li class="nav-item"><a class="nav-link nav-toggler hidden-md-up text-muted  "
                                            href="javascript:void(0)"><i class="mdi mdi-menu"></i></a></li>
                    <li class="nav-item m-l-10"><a class="nav-link sidebartoggler hidden-sm-down text-muted  "
                                                   href="javascript:void(0)"><i class="ti-menu"></i></a></li>

                </ul>
                <!-- User profile and search -->
                <ul class="navbar-nav my-lg-0">


                    <!-- Profile -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false"><img src="images/avatar.jpg" alt="user"
                                                                           class="profile-pic"/></a>
                        <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                            <ul class="dropdown-user">
                                <li><a href="setting.php"><i class="ti-user"></i> پروفایل </a></li>
                                <li><a href="setting.php"><i class="ti-settings"></i> تنظیمات</a></li>
                                <li><a href="logout.php"><i class="fa fa-power-off"></i> خروج</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- End header header -->
    <!-- Left Sidebar  -->
    <div class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-devider"></li>
                    <li class="nav-label">خانه</li>
                    <li><a class="has-arrow  " href="#" aria-expanded="false">
                            <i class="fa fa-tachometer"></i>
                            <span class="hide-menu">داشبورد<span
                                        class="label label-rouded label-primary pull-right">x</span></span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="panel.php">داشبور</a></li>
                        </ul>
                    </li>

                    <li class="nav-label">مدیریت</li>
                    <li><a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-envelope"></i><span
                                    class="hide-menu">کاربران</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="user.php">افزودن کاربر</a></li>
                            <li><a href="user-list.php">لیست کاربران</a></li>

                        </ul>
                    </li>

                    <li class="nav-label">فنی</li>
                    <li><a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-columns"></i><span
                                    class="hide-menu">تنظیمات</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="setting_site.php">تنظیمات سایت</a></li>
                            <li><a href="setting.php">تنظیمات مدیریت</a></li>
                            <li><a href="admin.php">تعریف مدیر</a></li>
                            <li><a href="admin-list.php">لیست مدیران</a></li>
                        </ul>
                    </li>


                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </div>
    <!-- End Left Sidebar  -->