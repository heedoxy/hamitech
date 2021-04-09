<?
require_once "functions/database.php";
$action = new Action();

// check admin access
if ($action->guest()) {
    echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
    return 0;
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<!-- ----------- start head ---------------------------------------------------------------------------------------- -->
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
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
    <link rel="stylesheet" href="css/jquery.Bootstrap-PersianDateTimePicker.css"/>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
    <!-- All Jquery -->

    <script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>

    <!-- select2 -->
    <link href="css/select2.min.css" rel="stylesheet"/>
    <script src="js/select2.min.js"></script>
    <script src="js/select2.full.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/status-indicator@1.0.9/styles.css">
    <link type="text/css" rel="stylesheet" href="css/kamadatepicker.css"/>
    <link type="text/css" rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css"/>
    <script type="text/javascript" src="class/ckeditor/ckeditor.js"></script>
    <script src="js/kamadatepicker.js"></script>
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<!-- ----------- end head ------------------------------------------------------------------------------------------ -->


<body class="fix-header fix-sidebar">
<!-- Preloader - style you can find in spinners.css -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>

<div id="main-wrapper">

    <!-- ----------- start header ---------------------------------------------------------------------------------- -->
    <div class="header">

        <nav class="navbar top-navbar navbar-expand-md navbar-light">

            <!-- ----------- show logo ----------------------------------------------------------------------------- -->
            <div class="navbar-header">
                <a class="navbar-brand" href="panel.php">
                    <span><img src="images/hamitech.png" alt="homepage" height="50" class="dark-logo"/></span>
                </a>
            </div>
            <!-- ----------- show logo ----------------------------------------------------------------------------- -->

            <div class="navbar-collapse">

                <!-- ----------- show name of user ----------------------------------------------------------------- -->
                <ul class="navbar-nav mr-auto mt-md-0">
                    <span class="user_name">
                        كاربر
                        |
                        <? echo $action->admin()->first_name . " " . $action->admin()->last_name; ?>
                    </span>
                </ul>
                <!-- ----------- show name of user ----------------------------------------------------------------- -->

                <!-- ----------- start profile --------------------------------------------------------------------- -->
                <ul class="navbar-nav my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted  header_user" href="#" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user user_icon"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                            <ul class="dropdown-user">
                                <li><a href="profile.php"><i class="ti-user"></i> پروفایل </a></li>
                                <li><a href="logout.php"><i class="fa fa-power-off"></i> خروج</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <!-- ----------- end profile ----------------------------------------------------------------------- -->

            </div>
        </nav>
    </div>
    <!-- ----------- end header ------------------------------------------------------------------------------------ -->

    <!-- ----------- start left sidebar ---------------------------------------------------------------------------- -->
    <div class="left-sidebar">
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <? include_once "sidebar.php" ?>
            </nav>
        </div>
    </div>
    <!-- ----------- end left sidebar ------------------------------------------------------------------------------ -->
