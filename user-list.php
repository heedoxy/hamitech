<? require_once "class/database.php";

$database = new DB();
$connection = $database->connect();
$action = new Action();

// ----------- check error ---------------------------------------------------------------------------------------------
$error = false;
if (isset($_SESSION['error'])) {
    $error = true;
    $error_val = $_SESSION['error'];
    unset($_SESSION['error']);
}
// ----------- check error ---------------------------------------------------------------------------------------------

// ----------- get data ------------------------------------------------------------------------------------------------
$counter = 1;
$result = $connection->query("SELECT * FROM `tbl_user` ORDER BY `id` DESC");
if (!$action->result($result)) return false;
// ----------- get data ------------------------------------------------------------------------------------------------

// ----------- start html :) ------------------------------------------------------------------------------------------
include('header.php'); ?>

<div class="page-wrapper">

    <div class="row page-titles">
        <!-- ----------- start breadcrumb ---------------------------------------------------------------------- -->
        <div class="col-md-12 align-self-center text-right">
            <h3 class="text-primary">کاربران</h3></div>
        <div class="col-md-12 align-self-center text-right">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="panel.php">خانه</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">کاربران</a></li>
            </ol>
        </div>
        <!-- ----------- end breadcrumb ------------------------------------------------------------------------ -->

    </div>

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

        <!-- ----------- add button ---------------------------------------------------------------------------- -->
        <div class="row">
            <a class="add-user mb-2" href="user.php"> ثبت کاربر <i class="fas fa-plus"></i></a>
        </div>
        <!-- ----------- add button ---------------------------------------------------------------------------- -->

        <!-- ----------- start row of table -------------------------------------------------------------------- -->
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive m-t-5">
                            <table id="example23" class="display nowrap table table-hover table-striped"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">ردیف</th>
                                    <th class="text-center">نام</th>
                                    <th class="text-center">نام خانوادگی</th>
                                    <th class="text-center">کدملی</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">مدیریت</th>
                                </tr>
                                </thead>

                                <tbody class="text-center">
                                <? while ($row = $result->fetch_object()) { ?>
                                    <tr class="text-center">

                                        <td class="text-center"><?= $counter++ ?></td>
                                        <td class="text-center"><?= $row->first_name ?></td>
                                        <td class="text-center"><?= $row->last_name ?></td>
                                        <td class="text-center"><?= $row->national_code ?></td>

                                        <td class="text-center">
                                            <a href="user.php?status=<?= $row->id ?>">
                                                <?
                                                if ($row->status) echo "<status-indicator positive pulse></status-indicator>";
                                                else echo "<status-indicator negative pulse></status-indicator>";
                                                ?>
                                            </a>
                                        </td>

                                        <td class="text-center">
                                            <a href="user.php?edit=<?= $row->id ?>">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            |
                                            <a href="user.php?remove=<?= $row->id ?>">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>

                                    </tr>
                                <? } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ----------- end row of table ---------------------------------------------------------------------- -->

    </div>
</div>

<? include('footer.php'); ?>
// ----------- end html :) ---------------------------------------------------------------------------------------------
