<?
include('functions/database.php');
$action = new Action();

// check admin access
if ($action->auth()) {
    echo "<script type='text/javascript'>window.location.href = 'panel.php';</script>";
    return 0;
}

// ----------- check error ---------------------------------------------------------------------------------------------
$error = 0;
if (isset($_SESSION['error'])) {
    $error = 1;
    $error_val = $_SESSION['error'];
    unset($_SESSION['error']);
}
// ----------- check error ---------------------------------------------------------------------------------------------

// ----------- check login ---------------------------------------------------------------------------------------------
if (isset($_POST['sub1'])) {

    // get fields
    $user = $action->request('user');
    $pass = $action->request('pass');

    // send query
    $command = $action->admin_login($user, $pass);

    // check errors
    if (!$command) {
        $_SESSION['error'] = 1;
        header("Location: index.php");
    }

    // bye bye :)
    header("Location: panel.php");
}
// ----------- check login ---------------------------------------------------------------------------------------------
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
    <title>ورود به پنل مدیریت</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
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

    <div class="unix-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="login-content card">
                        <div class="login-form">
                            <h4>ورود</h4>

                            <!-- ----------- start error list ------------------------------------------------------ -->
                            <? if ($error) {
                                if ($error_val) { ?>
                                    <div class="alert alert-danger">
                                        نام کاربری یا پسورد درست وارد نشده است
                                    </div>
                                <? }
                            } ?>
                            <!-- ----------- end error list -------------------------------------------------------- -->

                            <!-- ----------- start login form ------------------------------------------------------ -->
                            <form action="" method="POST">

                                <div class="form-group">
                                    <label>نام کاربری</label>
                                    <input type="text" class="form-control" name="user" placeholder="نام کاربری">
                                </div>

                                <div class="form-group">
                                    <label>پسورد</label>
                                    <input type="password" class="form-control" name="pass" placeholder="پسورد">
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> مرا بخاطر بسپار
                                    </label>
                                </div>

                                <button type="submit" name="sub1" class="btn btn-primary btn-flat m-b-30 m-t-30">
                                    ورود
                                </button>

                            </form>
                            <!-- ----------- end login form -------------------------------------------------------- -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ----------- start scripts ------------------------------------------------------------------------------------- -->
<!-- All Jquery -->
<script src="js/lib/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="js/lib/bootstrap/js/popper.min.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Menu sidebar -->
<script src="js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->
<script src="js/scripts.js"></script>
<!-- ----------- end scripts --------------------------------------------------------------------------------------- -->

</body>
</html>