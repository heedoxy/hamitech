<? require_once "class/database.php";

$action = new Action();
$connect = new MyDB();
$con = $connect->connect();

// ----------- get data from database when action is edit --------------------------------------------------------------
$edit = 0;
if (isset($_GET['edit'])) {
    $edit = 1;
    $id = $_GET['edit'];

    $result = mysqli_query($con, "SELECT * FROM tbl_user WHERE id ='$id'");

    if (!$result) {
        echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
        return false;
    }

    $rowcount = mysqli_num_rows($result);
    if (!$rowcount) echo "<script type='text/javascript'>window.location.href = 'user-list.php';</script>";

    $row = mysqli_fetch_assoc($result);
}
// ----------- get data from database when action is edit --------------------------------------------------------------

// ----------- check error ---------------------------------------------------------------------------------------------
$error = 0;
if (isset($_SESSION['error'])) {
    $error = 1;
    $error_val = $_SESSION['error'];
    unset($_SESSION['error']);
}
// ----------- check error ---------------------------------------------------------------------------------------------

// ----------- add or edit ---------------------------------------------------------------------------------------------
if (isset($_POST['submit'])) {

    $fullname = $action->request('fullname');
    $codemeli = $action->request('codemeli');
    $phone = $action->request('phone');
    $pin = $action->request('pin');

    $bdate = $action->request('bdate');
    $bdate = $action->condate($bdate);
    $bdate = strtotime($bdate);

    $status = $action->request('status');

    if ($edit) {
        $id = $action->request('edit');
        $command = $action->user_edit($id, $fullname, $codemeli, $phone, $pin, $bdate, $status);
    } else {
        $command = $action->user_add($fullname, $codemeli, $phone, $pin, $bdate, $status);
    }

    if ($command) {
        $_SESSION['error'] = 0;
    } else {
        $_SESSION['error'] = 1;
    }

    header("Location: user.php?edit=$command");

}
// ----------- add or edit ---------------------------------------------------------------------------------------------

// ----------- delete --------------------------------------------------------------------------------------------------
if (isset($_GET['remove'])) {
    $id = $action->request('remove');
    $_SESSION['error'] = !$action->user_remove($id);
    header("Location : user-list.php");
}
// ----------- delete --------------------------------------------------------------------------------------------------

// ----------- start html :) ------------------------------------------------------------------------------------------
include('header.php'); ?>
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">

            <div class="col-md-12 align-self-center text-right">
                <?php if (!isset($_GET['action'])) { ?>
                    <h3 class="text-primary">ثبت کاربر</h3>
                <?php } else { ?>
                    <h3 class="text-primary">ویرایش کاربر</h3>
                <?php } ?>
            </div>

            <div class="col-md-12 align-self-center text-right">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="panel.php">خانه</a></li>
                    <li class="breadcrumb-item"><a href="user-list.php">کاربران</a></li>
                    <?php if ($edit) { ?>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">ثبت</a></li>
                    <?php } else { ?>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">ویرایش</a></li>
                    <?php } ?>
                </ol>

            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- Start Page Content -->
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

            <div class="row">
                <div class="col-lg-6">

                    <div class="row m-b-0">
                        <div class="col-lg-6">
                            <p class="text-right m-b-0">
                                تاریخ ثبت :
                                <?= $action->condatesh(date("Y-m-d", $row['cdate'])) ?>
                            </p>
                        </div>
                        <div class="col-lg-6"><p class="text-right m-b-0">آخرین ویرایش :</p></div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="" method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <input type="text" name="fullname" class="form-control input-default "
                                               placeholder="نام"
                                               value="<? if ($edit) echo $row['fullname']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="number" name="codemeli" class="form-control" placeholder="کدملی"
                                               value="<? if ($edit) echo $row['codemeli']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control input-default "
                                               placeholder="تلفن همراه"
                                               value="<? if ($edit) echo $row['phone']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="pin" class="form-control input-default "
                                               placeholder="پین"
                                               value="<? if ($edit) echo $row['pin']; ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" id="date" name="bdate" class="form-control"
                                               placeholder="تاریخ تولد"
                                               value="<? if ($edit) echo $action->condatesh(date('Y-m-d', $row['bdate'])); ?>">
                                    </div>

                                    <div class="form-actions">

                                        <label class="float-right">
                                            <input type="checkbox" class="float-right m-1" name="status" value="1"
                                                <? if ($edit && $row['status']) echo "checked"; ?> >
                                            فعال
                                        </label>

                                        <button type="submit" name="submit" class="btn btn-success sweet-success"><i
                                                    class="fa fa-check"></i> ثبت
                                        </button>
                                        <a href="user-list.php"><span name="back" class="btn btn-inverse">بازگشت</span></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>


<? include('footer.php'); ?>