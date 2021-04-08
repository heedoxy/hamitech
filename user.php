<?
include('header.php');
$action = new Action();
$connect = new MyDB();
$con=$connect->connect();

$edit=0;
if(isset($_GET['edit'])){
    $edit=1;
    $id=$_GET['edit'];

    $result = mysqli_query($con,"SELECT * FROM tbl_user WHERE id ='$id'");

    if(!$result) {
        echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
        return false;
    }

    $rowcount=mysqli_num_rows($result);
    if(!$rowcount) echo "<script type='text/javascript'>window.location.href = 'user-list.php';</script>";

    $row = mysqli_fetch_assoc($result);
}

$error=0;
if(isset($_SESSION['error'])) {
    $error=1;
    $error_val = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">

            <div class="col-md-12 align-self-center text-right">
                <?php if(!isset($_GET['action'])) { ?>
                    <h3 class="text-primary">ثبت کاربر</h3>
                <?php } else { ?>
                    <h3 class="text-primary">ویرایش کاربر</h3>
                <?php } ?>
            </div>

            <div class="col-md-12 align-self-center text-right">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">خانه</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">کاربران</a></li>
                    <?php if($edit) { ?>
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
            <? if($error) {
                if($error_val){  ?>
                    <div class="alert alert-danger">
                        عملیات ناموفق بود .
                    </div>
                <? }else{ ?>
                    <div class="alert alert-info text-right">
                        عملیات موفق بود .
                    </div>
                <? } } ?>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="" method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <input type="text" name="fullname" class="form-control input-default " placeholder="نام"
                                               value="<? if($edit) echo $row['fullname']; ?>" >
                                    </div>

                                    <div class="form-group">
                                        <input type="number" name="codemeli" class="form-control" placeholder="کدملی"
                                               value="<? if($edit) echo $row['codemeli']; ?>" >
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="mobile" class="form-control input-default " placeholder="تلفن همراه"
                                               value="<? if($edit) echo $row['mobile']; ?>" >
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="pin" class="form-control input-default " placeholder="پین"
                                               value="<? if($edit) echo $row['pin']; ?>" >
                                    </div>

                                    <div class="form-group">
                                        <input type="text" id="date" name="bdate" class="form-control" placeholder="تاریخ تولد"
                                               value="<? if($edit) echo $action->condatesh(date('Y-m-d', $row['bdate'])); ?>" >
                                    </div>

                                    <div class="form-actions">
                                        <input type="checkbox" class="float-right m-1" name="status" value="1"
                                            <? if($edit && $row['status']) echo "checked"; ?>>
                                        <label class="float-right">فعال</label>

                                        <button type="submit" name="submit" class="btn btn-success sweet-success"> <i class="fa fa-check"></i> ثبت </button>
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



<?
//add or edit
if(isset($_POST['submit'])){

    $fullname=$action->cleansql($_POST['fullname']);
    $codemeli=$action->cleansql($_POST['codemeli']);
    $phone=$action->cleansql($_POST['phone']);
    $pin=$action->cleansql($_POST['pin']);

    $bdate=$action->cleansql($_POST['bdate']);
    $bdate=$action->condate($bdate);
    $bdate=strtotime($bdate);

    $status=$action->cleansql($_POST['status']);

    if($edit) {
        $id=$action->cleansql($_GET['edit']);
        $command = $action -> user_edit($id, $fullname, $codemeli, $mobile, $pin, $bdate, $status);
    } else {
        $command = $action -> user_add($fullname, $codemeli, $mobile, $pin, $bdate, $status);
    }

    if($command){
        $_SESSION['error'] = 0;
    }else{
        $_SESSION['error'] = 1;
    }

    echo "<script type='text/javascript'>window.location.href = 'user.php?edit=$command';</script>";
}


//delete
if(isset($_GET['remove'])) {
    $id = $action->cleansql($_GET['remove']);
    $_SESSION['error'] = !$action->user_remove($id);
    echo "<script type='text/javascript'>window.location.href = 'user-list.php';</script>";
}

include('footer.php');
?>