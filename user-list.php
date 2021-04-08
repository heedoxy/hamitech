<?
include('header.php');
$edit = 0;
$connect = new MyDB();
$con = $connect->connect();
$action = new Action();
?>

    <div class="page-wrapper">

        <div class="row page-titles">
            <div class="col-md-5 align-self-center text-right">
                <h3 class="text-primary">لیست کاربران</h3></div>
            <div class="col-md-7 align-self-center text-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">خانه</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">کاربران</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">لیست کاربران</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive m-t-5">
                                <table id="example23"
                                       class="display nowrap table table-hover table-striped table-bordered"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>نام</th>
                                        <th>کد ملی</th>
                                        <th>شماره تماس</th>
                                        <th>ویرایش</th>
                                        <th>حذف</th>
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
                                    while ($row = $result->fetch_row()) {
                                        ?>
                                        <tr class="text-center">

                                            <td><? echo $counter++; ?></td>
                                            <td><? echo $row[1] ?></td>
                                            <td><? echo $row[2] ?></td>
                                            <td><? echo $row[3] ?></td>
                                            <td><a href="user.php?action=edit&id=<? echo $row[0]; ?>"><i
                                                        class="fa fa-pencil-square-o"></i></a></td>
                                            <td class="text-center">
                                                <a href="user.php?action=remove&id=<? echo $row[0]; ?>">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
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

<?
include('footer.php');
?>