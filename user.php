<?
include('header.php');
$edit=0;
$action = new Action();
$connect = new MyDB();
$con=$connect->connect();
?>
    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <!-- Bread crumb -->
        <div class="row page-titles">

            <div class="col-md-5 align-self-center text-right">
                <?php if(!isset($_GET['action'])) { ?>
                    <h3 class="text-primary">افزودن کاربر</h3>
                <?php } else { ?>
                    <h3 class="text-primary">ویرایش کاربر</h3>
                <?php } ?>
            </div>

            <div class="col-md-7 align-self-center text-left">

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">خانه</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">کاربران</a></li>
                    <?php if(!isset($_GET['action'])) { ?>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">افزودن کاربر</a></li>
                    <?php } else { ?>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">لیست کاربران</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">ویرایش</a></li>
                    <?php } ?>
                </ol>

            </div>
        </div>
        <!-- End Bread crumb -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- Start Page Content -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-title">
                            <?

                            if(isset($_GET['action'])=="edit"){
                                $edit=1;
                            }

                            if(isset($_GET['error'])){
                                if($_GET['error']==0){  ?>
                                    <div class="alert alert-info">
                                        عملیات موفق بود .
                                    </div>
                                <? }elseif($_GET['error']==1){ ?>
                                    <div class="alert alert-danger">
                                        عملیات ناموفق بود .
                                    </div>
                                <? } } ?>

                        </div>

                        <?
                        if($edit){
                            $id=$_GET['id'];

                            $result = mysqli_query($con,"SELECT * FROM tbl_user WHERE id ='$id'");

                            if(!$result) {
                                echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
                                return false;
                            }

                            $row = $result->fetch_row();
                        }
                        ?>
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="" method="post" enctype="multipart/form-data">


                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control input-default " placeholder="نام"
                                            <?
                                            echo ($edit==1 ? 'value="'.$row[1].'"' : '');
                                            ?> required>
                                    </div>


                                    <div class="form-group">
                                        <input type="text" name="code" class="form-control input-default " placeholder="کد ملی"
                                            <?
                                            echo ($edit==1 ? 'value="'.$row[3].'"' : '');
                                            ?> required>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control input-default " placeholder="شماره تماس"
                                            <?
                                            echo ($edit==1 ? 'value="'.$row[2].'"' : '');
                                            ?> required>
                                    </div>


                                    <div class="form-group">
                                        <input type="text" name="bdate" id="date_start" class="form-control input-default " placeholder="تاریخ تولد"
                                            <?
                                            echo ($edit==1 ? 'value="'.$action->condatesh(date("Y-m-d",$row[4])).'"' : '');
                                            ?> required>
                                    </div>


                                    <div class="form-group">
                                        <select class="form-control" name="status">
                                            <option value="-1"
                                                <?php if(!isset($_GET['action'])) echo "selected"; ?>
                                            >وضعیت کاربر را انتخاب فرمایید</option>

                                            <option
                                                <?
                                                if($edit==1 && $row[6]==1)
                                                    echo 'selected="selected"';
                                                ?>
                                                    value="1">فعال</option>


                                            <option
                                                <?
                                                if($edit==1 && $row[6]==0)
                                                    echo 'selected="selected"';
                                                ?>
                                                    value="0">غیرفعال</option>


                                        </select>


                                    </div>

                                    <div class="form-actions">
                                        <?
                                        if($edit){
                                            ?>
                                            <button type="submit" name="subedit" class="btn btn-success sweet-success"> <i class="fa fa-check"></i>ذخیره</button>

                                            <?
                                        }else{
                                            ?>
                                            <button type="submit" name="submit" class="btn btn-success sweet-success"> <i class="fa fa-check"></i>افزودن</button>
                                            <?
                                        }
                                        ?>

                                        <button type="restart" class="btn btn-inverse">انصراف</button>
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
if(isset($_POST['submit'])){

    $name=$action->cleansql($_POST['name']);
    $phone=$action->cleansql($_POST['phone']);
    $code=$action->cleansql($_POST['code']);
    $bdate=$action->cleansql($_POST['bdate']);
    $bdate=$action->condate($bdate);
    $bdate=strtotime($bdate);
    $status=$action->cleansql($_POST['status']);

    $addmatch = $action->user_add($name, $phone, $code, $bdate, $status);

    if($addmatch){
        echo "<script type='text/javascript'>window.location.href = 'user.php?error=0';</script>";
    }else{
        echo "<script type='text/javascript'>window.location.href = 'user.php?error=1';</script>";
    }
}

//edit action
if(isset($_POST['subedit'])){
    $id = $action->cleansql($_GET['id']);
    $name=$action->cleansql($_POST['name']);
    $phone=$action->cleansql($_POST['phone']);
    $code=$action->cleansql($_POST['code']);
    $bdate=$action->cleansql($_POST['bdate']);
    $bdate=$action->condate($bdate);
    $bdate=strtotime($bdate);
    $status=$action->cleansql($_POST['status']);

    $editcat = $action->edit_user($id, $name, $phone, $code, $bdate, $status);

    if($editcat){
        echo "<script type='text/javascript'>window.location.href = 'user.php?error=0';</script>";
    }else{
        echo "<script type='text/javascript'>window.location.href = 'user.php?error=1';</script>";
    }
}


//delete
if(isset($_GET['action']) && $_GET['action']=="remove") {
    $id = $action->cleansql($_GET['id']);
    if ($action->user_remove($id)) {
        echo "<script type='text/javascript'>window.location.href = 'user.php?error=0';</script>";
    }
    else
        echo "<script type='text/javascript'>window.location.href = 'user.php?error=1';</script>";

}

include('footer.php');
?>