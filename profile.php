<? require_once "functions/database.php";
$database = new DB();
$connection = $database->connect();
$action = new Action();

// ----------- get data from database  --------------------------------------------------------------
$id = $action->admin()->id;
$result = $connection->query("SELECT * FROM tbl_admin WHERE id ='$id'");
if (!$action->result($result)) return false;
if (!$result->num_rows) header("Location: user-list.php");
$row = $result->fetch_object();
// ----------- get data from database when action is edit --------------------------------------------------------------

// ----------- check error ---------------------------------------------------------------------------------------------
$error = false;
if (isset($_SESSION['error'])) {
    $error = true;
    $error_val = $_SESSION['error'];
    unset($_SESSION['error']);
}
// ----------- check error ---------------------------------------------------------------------------------------------

// ----------- edit ---------------------------------------------------------------------------------------------
if (isset($_POST['submit'])) {

    // get fields
    $first_name = $action->request('first_name');
    $last_name = $action->request('last_name');
    $phone = $action->request('phone');
    $password = $action->request('password');

    // send query
    $command = $action->profile_edit($first_name, $last_name, $phone, $password);


    // check errors
    if ($command) {
        $_SESSION['error'] = 0;
    } else {
        $_SESSION['error'] = 1;
    }

    // bye bye :)
    header("Location: profile.php");

}
// ----------- add or edit ---------------------------------------------------------------------------------------------

// ----------- start html :) ------------------------------------------------------------------------------------------
include('header.php'); ?>

<div class="page-wrapper">

    <div class="row page-titles">

        <!-- ----------- start title --------------------------------------------------------------------------- -->
        <div class="col-md-12 align-self-center text-right">
            <h3 class="text-primary">
                مشخصات شما
                |
                <?= $action->admin()->username ?>
            </h3>
        </div>
        <!-- ----------- end title ----------------------------------------------------------------------------- -->

        <!-- ----------- start breadcrumb ---------------------------------------------------------------------- -->
        <div class="col-md-12 align-self-center text-right">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="panel.php">
                        <i class="fa fa-dashboard"></i>
                        خانه
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="user-list.php">پروفایل</a></li>
            </ol>
        </div>
        <!-- ----------- end breadcrumb ------------------------------------------------------------------------ -->

    </div>

    <!-- ----------- start main container ---------------------------------------------------------------------- -->
    <div class="container-fluid">

        <!-- ----------- start error list ---------------------------------------------------------------------- -->
        <? if ($error) {
            if ($error_val) { ?>
                <div class="alert alert-danger">
                    عملیات ناموفق بود .
                </div>
            <? } else { ?>
                <div class="alert alert-info text-right">
                    عملیات موفق بود .
                </div>
            <? }
        } ?>
        <!-- ----------- end error list ------------------------------------------------------------------------ -->

        <div class="row">
            <div class="col-lg-6">

                <!-- ----------- start history ----------------------------------------------------------------- -->
                <div class="row m-b-0">
                    <div class="col-lg-6">
                        <p class="text-right m-b-0">
                            تاریخ ثبت :
                            <?= $action->time_to_shamsi($row->created_at) ?>
                        </p>
                    </div>
                    <? if ($row->updated_at) { ?>
                        <div class="col-lg-6">
                            <p class="text-right m-b-0">
                                آخرین ویرایش :
                                <?= $action->time_to_shamsi($row->updated_at) ?>
                            </p>
                        </div>
                    <? } ?>
                </div>
                <!-- ----------- end history ------------------------------------------------------------------- -->

                <!-- ----------- start row of fields ----------------------------------------------------------- -->
                <div class="card">
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <input type="text" name="first_name" class="form-control input-default "
                                           placeholder="نام"
                                           value="<?= $row->first_name  ?>">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="last_name" class="form-control input-default "
                                           placeholder="نام خانوادگی"
                                           value="<?= $row->last_name ?>">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control input-default "
                                           placeholder="تلفن همراه"
                                           value="<?= $row->phone ?>">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="password" class="form-control input-default "
                                           placeholder="رمز عبور"
                                           value="<?= $row->password ?>">
                                </div>

                                <div class="form-actions">
                                    <button type="submit" name="submit" class="btn btn-success sweet-success">
                                        <i class="fa fa-check"></i> ثبت
                                    </button>
                                    <a href="panel.php"><span name="back" class="btn btn-inverse">بازگشت</span></a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- ----------- end row of fields ----------------------------------------------------------- -->

            </div>
        </div>
    </div>
    <!-- ----------- end main container ------------------------------------------------------------------------ -->

</div>
<? include('footer.php'); ?>
// ----------- end html :) ---------------------------------------------------------------------------------------------

