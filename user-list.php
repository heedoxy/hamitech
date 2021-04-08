<? include('class/database.php');

$connect = new MyDB();
$con = $connect->connect();
$action = new Action();

// ----------- check error ---------------------------------------------------------------------------------------------
$error=0;
if(isset($_SESSION['error'])) {
    $error=1;
    $error_val = $_SESSION['error'];
    unset($_SESSION['error']);
}
// ----------- check error ---------------------------------------------------------------------------------------------

// ----------- start html :) ------------------------------------------------------------------------------------------
include('header.php'); ?>

    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-12 align-self-center text-right">
                <h3 class="text-primary">کاربران</h3> </div>
            <div class="col-md-12 align-self-center text-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="panel.php">خانه</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">کاربران</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row">
                <a class="add-user mb-2" href="user.php">ثبت کاربر <i class="fas fa-plus"></i></a>
            </div>

            <div class="row">
                <div class="col-12">

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

                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive m-t-5">
                                <table id="example23"
                                       class="display nowrap table table-hover table-striped"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ردیف</th>
                                        <th class="text-center">نام</th>
                                        <th class="text-center">کدملی</th>
                                        <th class="text-center">وضعیت</th>
                                        <th class="text-center">مدیریت</th>
                                    </tr>
                                    </thead>

                                    <tbody class="text-center">
                                    <?
                                    $counter = 1;
                                    $result = mysqli_query($con, "SELECT * FROM tbl_user");
                                    if (!$result) {
                                        echo mysqli_errno($this->_conn) . mysqli_error($this->_conn);
                                        return false;
                                    }
                                    while($row = mysqli_fetch_assoc($result))
                                    {

                                        ?>
                                        <tr class="text-center">

                                            <td class="text-center"><? echo $counter++; ?></td>
                                            <td class="text-center"><? echo $row['fullname']; ?></td>
                                            <td class="text-center"><? echo $row['codemeli']; ?></td>
                                            <td class="text-center"><?
                                                if($row['status']==1) echo "<status-indicator positive pulse></status-indicator>";
                                                else echo "<status-indicator negative pulse></status-indicator>";
                                                ?></td>
                                            <td class="text-center">
                                                <a href="user.php?edit=<? echo $row['id']; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                                |
                                                <a href="user.php?remove=<? echo $row['id']; ?>"><i class="fa fa-trash"></i></a>
                                            </td>

                                        </tr>
                                        <?
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

<?include('footer.php');?>